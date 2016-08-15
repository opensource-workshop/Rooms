<?php
/**
 * SaveRoomAssociations Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * SaveRoomAssociations Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Model\Behavior
 */
class SaveRoomAssociationsBehavior extends ModelBehavior {

/**
 * 関連テーブルの初期値の登録処理
 *
 * @param Model $model 呼び出し元のモデル
 * @param bool $created 作成フラグ
 * @param array $options Model::save()のoptions.
 * @return void
 */
	public function saveDefaultAssociations(Model $model, $created, $options) {
		//デフォルトデータ登録処理
		$room = $model->data;
		if ($created) {
			$model->saveDefaultRolesRoom($room);
			$model->saveDefaultRoomRolePermission($room);
		}

		if ($created || Hash::get($room, 'Room.in_draft')) {
			$model->saveDefaultRolesRoomsUser($room, true);
			$model->saveDefaultRolesPluginsRoom($room);
		}

		if (! Hash::get($room, 'Room.in_draft') &&
				($created || Hash::get($options, 'preUpdate.Room.in_draft'))) {
			$page = $model->saveDefaultPage($room);
			$model->data = Hash::merge($room, $page);
		}
	}

/**
 * RolesRoomのデフォルトデータ登録処理
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $data Room data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultRolesRoom(Model $model, $data) {
		$model->loadModels([
			'Role' => 'Roles.Role',
			'RolesRoom' => 'Rooms.RolesRoom',
		]);
		$db = $model->getDataSource();

		//多数のデータを一括で登録するためINSERT INTO ... SELECTを使う。
		//--クエリの生成
		$tableName = $model->tablePrefix . $model->RolesRoom->table;
		$values = array(
			'room_id' => $db->value($data['Room']['id'], 'string'),
			'role_key' => $model->RolesRoom->escapeField('role_key'),
			'created' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'created_user' => $db->value(Current::read('User.id'), 'string'),
			'modified' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'modified_user' => $db->value(Current::read('User.id'), 'string'),
		);
		$joins = array(
			$model->tablePrefix . $model->RolesRoom->table . ' AS ' . $model->RolesRoom->alias => null,
		);
		$wheres = array(
			$model->RolesRoom->escapeField('room_id') . ' = ' .
					$db->value($data['Room']['parent_id'], 'string'),
		);

		//--クエリの実行
		$sql = $this->__insertSql(
			$tableName, array_keys($values), array_values($values), $joins, $wheres
		);
		$model->RolesRoom->query($sql);
		$result = $model->RolesRoom->getAffectedRows() > 0;
		if (! $result) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * RolesRoomsUserのデフォルトデータ登録処理
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $data Room data
 * @param bool $isRoomCreate ルーム作成時かどうか。trueの場合、ルーム作成時に呼ばれ、falseの場合、ユーザ作成時に呼ばれる
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultRolesRoomsUser(Model $model, $data, $isRoomCreate) {
		$model->loadModels([
			'Role' => 'Roles.Role',
			'RolesRoom' => 'Rooms.RolesRoom',
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
			'User' => 'Users.User',
			'UserRoleSetting' => 'UserRoles.UserRoleSetting',
		]);
		$db = $model->getDataSource();

		if (Hash::check($data, 'RolesRoomsUser.user_id')) {
			$userId = Hash::get($data, 'RolesRoomsUser.user_id');
		} else {
			$userId = Current::read('User.id');
		}
		if ($isRoomCreate) {
			//ルーム作成者をRolesRoomsUsersのルーム管理者で登録する
			$roleKey = Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR;
		} else {
			$roleKey = $data['Room']['default_role_key'];
		}
		$rolesRoom = $model->RolesRoom->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'room_id' => $data['Room']['id'],
				'role_key' => $roleKey,
			)
		));
		$rolesRoomsUser = array(
			'id' => null,
			'roles_room_id' => $rolesRoom['RolesRoom']['id'],
			'room_id' => $data['Room']['id'],
			'user_id' => $userId
		);
		$model->RolesRoomsUser->create(null);
		if (! $model->RolesRoomsUser->save($rolesRoomsUser)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		if (! $data['Room']['default_participation'] || ! $isRoomCreate) {
			return true;
		}

		//多数のデータを一括で登録するためINSERT INTO ... SELECTを使う。
		//--デフォルトのロールを取得
		$rolesRoom = $model->RolesRoom->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'room_id' => $data['Room']['id'],
				'role_key' => $data['Room']['default_role_key'],
			)
		));
		//--クエリの生成
		$tableName = $model->tablePrefix . $model->RolesRoomsUser->table;
		$values = array(
			'roles_room_id' => $db->value($rolesRoom['RolesRoom']['id'], 'string'),
			'user_id' => $model->User->escapeField('id'),
			'room_id' => $db->value($data['Room']['id'], 'string'),
			'created' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'created_user' => $db->value(Current::read('User.id'), 'string'),
			'modified' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'modified_user' => $db->value(Current::read('User.id'), 'string'),
		);
		$joins = array(
			$model->tablePrefix . $model->User->table . ' AS ' . $model->User->alias => null,
		);
		$wheres = array(
			$model->User->escapeField('id') . ' != ' . $db->value($userId, 'string'),
		);

		//--クエリの実行
		$sql = $this->__insertSql(
			$tableName, array_keys($values), array_values($values), $joins, $wheres
		);
		$model->RolesRoomsUser->query($sql);
		$result = $model->RolesRoomsUser->getAffectedRows() > 0;
		if (! $result) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * RolesPluginsRoomのデフォルトデータ登録処理
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $data Room data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultRolesPluginsRoom(Model $model, $data) {
		$model->loadModels([
			'RolesRoom' => 'Rooms.RolesRoom',
			'PluginsRoom' => 'PluginManager.PluginsRoom',
			//'PluginsSpace' => 'PluginManager.PluginsSpace',
		]);
		$db = $model->getDataSource();

		//多数のデータを一括で登録するためINSERT INTO ... SELECTを使う。
		//--クエリの生成
		$tableName = $model->tablePrefix . $model->PluginsRoom->table;
		$values = array(
			'room_id' => $db->value($data['Room']['id'], 'string'),
			'plugin_key' => $model->PluginsRoom->escapeField('plugin_key'),
			'created' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'created_user' => $db->value(Current::read('User.id'), 'string'),
			'modified' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'modified_user' => $db->value(Current::read('User.id'), 'string'),
		);
		$joins = array(
			$model->tablePrefix . $model->PluginsRoom->table . ' AS ' . $model->PluginsRoom->alias => null,
		);
		$wheres = array(
			$model->PluginsRoom->escapeField('room_id') . ' = ' .
						$db->value($data['Room']['parent_id'], 'string'),
		);

		//--クエリの実行
		$sql = $this->__insertSql(
			$tableName, array_keys($values), array_values($values), $joins, $wheres
		);
		$model->PluginsRoom->query($sql);
		$result = $model->PluginsRoom->getAffectedRows() > 0;
		if (! $result) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * RoomRolePermissionのデフォルトデータ登録処理
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $data Room data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultRoomRolePermission(Model $model, $data) {
		$model->loadModels([
			'Role' => 'Roles.Role',
			'DefaultRolePermission' => 'Roles.DefaultRolePermission',
			'RolesRoom' => 'Rooms.RolesRoom',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
		]);
		$db = $model->getDataSource();

		//多数のデータを一括で登録するためINSERT INTO ... SELECTを使う。
		//--クエリの生成
		$tableName = $model->tablePrefix . $model->RoomRolePermission->table;
		$values = array(
			'roles_room_id' => $model->RolesRoom->escapeField('id'),
			'permission' => $model->DefaultRolePermission->escapeField('permission'),
			'value' => $model->DefaultRolePermission->escapeField('value'),
			'created' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'created_user' => $db->value(Current::read('User.id'), 'string'),
			'modified' => $db->value(date('Y-m-d H:i:s'), 'string'),
			'modified_user' => $db->value(Current::read('User.id'), 'string'),
		);

		$joins = array();
		$joins[$model->tablePrefix . $model->Role->table . ' AS ' . $model->Role->alias] = null;
		$key = $model->tablePrefix . $model->RolesRoom->table . ' AS ' . $model->RolesRoom->alias;
		$joins[$key] = array(
			$model->Role->escapeField('key') . ' = ' . $model->RolesRoom->escapeField('role_key')
		);
		$key = $model->tablePrefix . $model->DefaultRolePermission->table . ' AS ' .
					$model->DefaultRolePermission->alias;
		$joins[$key] = array(
			$model->Role->escapeField('key') . ' = ' . $model->DefaultRolePermission->escapeField('role_key')
		);

		$wheres = array();
		$wheres[] = $model->Role->escapeField('type') . ' = ' .
					$db->value(Role::ROLE_TYPE_ROOM, 'string');
		$wheres[] = $model->Role->escapeField('language_id') . ' = ' .
					$db->value(Current::read('Language.id'), 'string');
		$wheres[] = $model->RolesRoom->escapeField('room_id') . ' = ' .
					$db->value($data['Room']['id'], 'string');
		$wheres[] = $model->DefaultRolePermission->escapeField('type') . ' = ' .
					$db->value(DefaultRolePermission::TYPE_ROOM_ROLE, 'string');

		//--クエリの実行
		$sql = $this->__insertSql(
			$tableName, array_keys($values), array_values($values), $joins, $wheres
		);
		$model->RoomRolePermission->query($sql);
		$result = $model->RoomRolePermission->getAffectedRows() > 0;
		if (! $result) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		return true;
	}

/**
 * Pageのデフォルトデータ登録処理
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $data Room data
 * @return array ページ
 * @throws InternalErrorException
 */
	public function saveDefaultPage(Model $model, $data) {
		$model->loadModels([
			'Page' => 'Pages.Page',
			'Room' => 'Rooms.Room',
		]);

		$slug = OriginalKeyBehavior::generateKey('Page', $model->useDbConfig);
		$page = Hash::merge($data, array(
			'Page' => array(
				'slug' => $slug,
				'permalink' => $slug,
				'room_id' => $data['Room']['id'],
				'root_id' => $model->getParentPageId($data),
				'parent_id' => $model->getParentPageId($data)
			),
			'LanguagesPage' => array(
				'language_id' => Current::read('Language.id'),
				'name' => __d('rooms', 'Top')
			),
		));

		$model->Page->create(false);
		$page = $model->Page->savePage($page, array('atomic' => false));
		if (! $page) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (! $model->Room->updateAll(
			array($model->Room->alias . '.page_id_top' => $page['Page']['id']),
			array($model->Room->alias . '.id' => $data['Room']['id'])
		)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return $page;
	}

/**
 * 親ページIDを取得する
 *
 * @param Model $model 呼び出し前のモデル
 * @param array $page ページデータ
 * @return string
 */
	public function getParentPageId(Model $model, $page) {
		if (Hash::get($page, 'Room.parent_id') &&
				! in_array((string)Hash::get($page, 'Room.parent_id'), Room::$spaceRooms, true)) {
			$model->loadModels(['Room' => 'Rooms.Room']);
			$parentRoom = $model->Room->find('first', array(
				'recursive' => -1,
				'conditions' => array('id' => Hash::get($page, 'Room.parent_id'))
			));

			return Hash::get($parentRoom, 'Room.page_id_top');
		}

		$spaceId = Hash::get($page, 'Room.space_id');
		if ($spaceId === Space::PUBLIC_SPACE_ID) {
			return Page::PUBLIC_ROOT_PAGE_ID;
		} elseif ($spaceId === Space::PRIVATE_SPACE_ID) {
			return Page::PRIVATE_ROOT_PAGE_ID;
		} elseif ($spaceId === Space::ROOM_SPACE_ID) {
			return Page::ROOM_ROOT_PAGE_ID;
		}

		return false;
	}

/**
 * 承認有無を切り替えた際の登録処理
 * 特に承認なし⇒承認ありに変更した場合、
 * BlockRolePermissionのcontent_publishableとcontent_comment_publishableを削除する
 *
 * @param Model $model 呼び出し元のモデル
 * @param array $data Room data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function changeNeedApproval(Model $model, $data) {
		$model->loadModels([
			'Block' => 'Blocks.Block',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
			'Room' => 'Rooms.Room',
		]);

		if (! Hash::get($data, 'Room.need_approval') ||
				! Hash::get($data, 'Room.id')) {
			return true;
		}

		$result = $model->Room->find('first', array(
			'recursive' => -1,
			'fields' => array('need_approval'),
			'conditions' => array('id' => Hash::get($data, 'Room.id')),
		));
		if (Hash::get($result, 'Room.need_approval') === Hash::get($data, 'Room.need_approval')) {
			return true;
		}
		$blocks = $model->Block->find('list', array(
			'recursive' => -1,
			'fields' => array('id', 'key'),
			'conditions' => array('room_id' => Hash::get($data, 'Room.id')),
		));

		$blockKeys = array_unique(array_values($blocks));
		$conditions = array(
			$model->BlockRolePermission->alias . '.block_key' => $blockKeys,
			$model->BlockRolePermission->alias . '.permission' => array(
				'content_publishable', 'content_comment_publishable'
			),
		);
		if (! $model->BlockRolePermission->deleteAll($conditions, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * INSERT INTO ... SELETEのSQL生成
 *
 * @param string $tableName Table name
 * @param array $fields Insert query fields
 * @param array $values Select query fields
 * @param array $joins Join table. Null on from, other than inner join.
 * @param array $where Query where
 * @return string Query sql
 */
	private function __insertSql($tableName, $fields, $values, $joins, $where) {
		$sql = 'INSERT INTO ' . $tableName . '(' . implode(', ', $fields) . ') ' .
				'SELECT ' . implode(', ', $values) . ' ';
		foreach ($joins as $table => $onWhere) {
			if (! isset($onWhere)) {
				$sql .= 'FROM ' . $table . ' ';
			} else {
				$sql .= 'INNER JOIN ' . $table . ' ON (' . implode(' AND ', $onWhere) . ') ';
			}
		}
		$sql .= 'WHERE ' . implode(' AND ', $where);

		return $sql;
	}

/**
 * 1ユーザに対するRolesRoomsUserのデフォルトデータ取得処理
 *
 * @param Model $model 呼び出し元のモデル
 * @return array
 */
	public function getDefaultRolesRoomsUser(Model $model) {
		$model->loadModels([
			'Room' => 'Rooms.Room',
			'RolesRoom' => 'Rooms.RolesRoom',
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
		]);

		$rooms = $model->Room->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'OR' => array(
					'default_participation' => true,
					'root_id' => null
				)
			),
		));
		if (! Configure::read('NetCommons.installed')) {
			$rooms = Hash::insert(
				$rooms, '{n}.Room.default_role_key', Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR
			);
		}

		$roomIds = Hash::extract($rooms, '{n}.Room.id');

		$rolesRooms = $model->RolesRoom->find('list', array(
			'recursive' => -1,
			'fields' => array('role_key', 'id', 'room_id'),
			'conditions' => array(
				'room_id' => $roomIds,
			)
		));

		$rolesRoomsUsers = array();
		foreach ($rooms as $room) {
			$roomId = $room['Room']['id'];
			$rolesRoomsUsers[$roomId] = $model->RolesRoomsUser->create([
				'id' => null,
				'roles_room_id' => Hash::get($rolesRooms, $roomId . '.' . $room['Room']['default_role_key']),
				'user_id' => null,
				'room_id' => $roomId,
			]);
		}
		$rolesRoomsUsers = Hash::combine(
			$rolesRoomsUsers, '{n}.RolesRoomsUser.room_id', '{n}.RolesRoomsUser'
		);

		return $rolesRoomsUsers;
	}

}
