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
 * Save default RolesRoom
 *
 * @param Model $model Model using this behavior
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
		$tableName = $model->RolesRoom->tablePrefix . $model->RolesRoom->table;
		$values = array(
			'room_id' => $db->value($data['Room']['id'], 'string'),
			'role_key' => $model->Role->escapeField('key'),
			'created' => $db->value($this->__now($model, 'created'), 'string'),
			'created_user' => $db->value(AuthComponent::user('id'), 'string'),
			'modified' => $db->value($this->__now($model, 'modified'), 'string'),
			'modified_user' => $db->value(AuthComponent::user('id'), 'string'),
		);
		$joins = array(
			$model->Role->tablePrefix . $model->Role->table . ' AS ' . $model->Role->alias => null,
		);
		$wheres = array(
			$model->Role->escapeField('type') . ' = ' . $db->value(Role::ROLE_TYPE_ROOM, 'string'),
			$model->Role->escapeField('language_id') . ' = ' . $db->value(Current::read('Language.id'), 'string'),
		);

		//--クエリの実行
		$sql = $this->__insertSql($tableName, array_keys($values), array_values($values), $joins, $wheres);
		$model->RolesRoom->query($sql);
		if (! $model->RolesRoom->getAffectedRows() > 0) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * Save default RolesRoomsUsers
 *
 * @param Model $model Model using this behavior
 * @param array $data Room data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultRolesRoomsUsers(Model $model, $data) {
		$model->loadModels([
			'Role' => 'Roles.Role',
			'RolesRoom' => 'Rooms.RolesRoom',
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
			'User' => 'Users.User',
			'UserRoleSetting' => 'UserRoles.UserRoleSetting',
		]);
		$db = $model->getDataSource();

		//登録者のRolesRoomsUsersをルーム管理者で登録する
		$rolesRoom = $model->RolesRoom->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'room_id' => $data['Room']['id'],
				'role_key' => ROLE::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR
			)
		));
		$rolesRoomsUser = array(
			'roles_room_id' => $rolesRoom['RolesRoom']['id'],
			'user_id' => AuthComponent::user('id')
		);
		if (! $model->RolesRoomsUser->save($rolesRoomsUser)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		if (! $data['Room']['default_participation']) {
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
		$tableName = $model->RolesRoomsUser->tablePrefix . $model->RolesRoomsUser->table;
		$values = array(
			'roles_room_id' => $db->value($rolesRoom['RolesRoom']['id'], 'string'),
			'user_id' => $model->User->escapeField('id'),
			'created' => $db->value($this->__now($model, 'created'), 'string'),
			'created_user' => $db->value(AuthComponent::user('id'), 'string'),
			'modified' => $db->value($this->__now($model, 'modified'), 'string'),
			'modified_user' => $db->value(AuthComponent::user('id'), 'string'),
		);
		$joins = array(
			$model->User->tablePrefix . $model->User->table . ' AS ' . $model->User->alias => null,
		);
		$wheres = array(
			$model->User->escapeField('id') . ' != ' . $db->value(AuthComponent::user('id'), 'string'),
		);

		//--クエリの実行
		$sql = $this->__insertSql($tableName, array_keys($values), array_values($values), $joins, $wheres);
		$model->RolesRoomsUser->query($sql);
		if (! $model->RolesRoomsUser->getAffectedRows() > 0) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * Save default PluginsRoom
 *
 * @param Model $model Model using this behavior
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
		$tableName = $model->PluginsRoom->tablePrefix . $model->PluginsRoom->table;
		$values = array(
			'room_id' => $db->value($data['Room']['id'], 'string'),
			'plugin_key' => $model->PluginsRoom->escapeField('plugin_key'),
			'created' => $db->value($this->__now($model, 'created'), 'string'),
			'created_user' => $db->value(AuthComponent::user('id'), 'string'),
			'modified' => $db->value($this->__now($model, 'modified'), 'string'),
			'modified_user' => $db->value(AuthComponent::user('id'), 'string'),
		);
		$joins = array(
			$model->PluginsRoom->tablePrefix . $model->PluginsRoom->table . ' AS ' . $model->PluginsRoom->alias => null,
		);
		$wheres = array(
			$model->PluginsRoom->escapeField('room_id') . ' = ' . $db->value($data['Room']['parent_id'], 'string'),
		);

		//--クエリの実行
		$sql = $this->__insertSql($tableName, array_keys($values), array_values($values), $joins, $wheres);
		$model->PluginsRoom->query($sql);
		if (! $model->PluginsRoom->getAffectedRows() > 0) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * Save default RoomRolePermissions
 *
 * @param Model $model Model using this behavior
 * @param array $data Room data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultRoomRolePermissions(Model $model, $data) {
		$model->loadModels([
			'Role' => 'Roles.Role',
			'DefaultRolePermission' => 'Roles.DefaultRolePermission',
			'RolesRoom' => 'Rooms.RolesRoom',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
		]);
		$db = $model->getDataSource();

		//多数のデータを一括で登録するためINSERT INTO ... SELECTを使う。
		//--クエリの生成
		$tableName = $model->RoomRolePermission->tablePrefix . $model->RoomRolePermission->table;
		$values = array(
			'roles_room_id' => $model->RolesRoom->escapeField('id'),
			'permission' => $model->DefaultRolePermission->escapeField('permission'),
			'value' => $model->DefaultRolePermission->escapeField('value'),
			'created' => $db->value($this->__now($model, 'created'), 'string'),
			'created_user' => $db->value(AuthComponent::user('id'), 'string'),
			'modified' => $db->value($this->__now($model, 'modified'), 'string'),
			'modified_user' => $db->value(AuthComponent::user('id'), 'string'),
		);
		$joins = array(
			$model->Role->tablePrefix . $model->Role->table . ' AS ' . $model->Role->alias => null,
			$model->RolesRoom->tablePrefix . $model->RolesRoom->table . ' AS ' . $model->RolesRoom->alias => array(
				$model->Role->escapeField('key') . ' = ' . $model->RolesRoom->escapeField('role_key')
			),
			$model->DefaultRolePermission->tablePrefix . $model->DefaultRolePermission->table . ' AS ' . $model->DefaultRolePermission->alias => array(
				$model->Role->escapeField('key') . ' = ' . $model->DefaultRolePermission->escapeField('role_key')
			),
		);
		$wheres = array(
			$model->Role->escapeField('type') . ' = ' . $db->value(Role::ROLE_TYPE_ROOM, 'string'),
			$model->Role->escapeField('language_id') . ' = ' . $db->value(Current::read('Language.id'), 'string'),
			$model->RolesRoom->escapeField('room_id') . ' = ' . $db->value($data['Room']['id'], 'string'),
			$model->DefaultRolePermission->escapeField('type') . ' = ' . $db->value(DefaultRolePermission::TYPE_ROOM_ROLE, 'string'),
		);

		//--クエリの実行
		$sql = $this->__insertSql($tableName, array_keys($values), array_values($values), $joins, $wheres);
		$model->RoomRolePermission->query($sql);
		if (! $model->RoomRolePermission->getAffectedRows() > 0) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}
		return true;
	}

/**
 * Save default RoomRolePermissions
 *
 * @param Model $model Model using this behavior
 * @param array $data Room data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultPage(Model $model, $data) {
		$model->loadModels([
			'Page' => 'Pages.Page',
		]);

		$slug = OriginalKeyBehavior::generateKey('Page', $model->useDbConfig);
		$page = Hash::merge($data, array(
			'Page' => array(
				'slug' => $slug,
				'permalink' => $slug,
				'room_id' => $data['Room']['id'],
				'parent_id' => $data['Page']['parent_id']
			),
			'LanguagesPage' => array(
				'language_id' => Current::read('Language.id'),
				'name' => __d('rooms', 'Top')
			),
		));

		if (! $page = $model->Page->savePage($page, array('atomic' => false))) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (! $model->Room->updateAll(
			array($model->Room->alias . '.page_id_top' => $page['Page']['id']),
			array($model->Room->alias . '.id' => $data['Room']['id'])
		)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * Convert model RoomRolePermissions
 *
 * @param Model $model Model using this behavior
 * @param array $data Room data
 * @return array Model array
 */
	public function convertRoomRolePermissions(Model $model, $data) {
		//var_dump($data);
		//$model->loadModels([
		//	'UserRoleSetting' => 'UserRoles.UserRoleSetting',
		//	'UserAttributesRole' => 'UserRoles.UserAttributesRole',
		//	'PluginsRole' => 'PluginManager.PluginsRole',
		//]);
		//
		//$pluginsRoles = $model->PluginsRole->find('all', array(
		//	'recursive' => -1,
		//	'conditions' => array(
		//		'plugin_key' => 'user_manager',
		//	)
		//));
		//
		//$userRoleSettings = $model->UserRoleSetting->find('all', array('recursive' => -1));
		//
		//foreach ($userRoleSettings as $userRoleSetting) {
		//	$params = array(
		//		'role_key' => $userRoleSetting['UserRoleSetting']['role_key'],
		//		'default_role_key' => $userRoleSetting['UserRoleSetting']['default_role_key'],
		//		'user_attribute_key' => $data['UserAttributeSetting']['user_attribute_key'],
		//		'only_administrator' => (bool)$data['UserAttributeSetting']['only_administrator'],
		//		'is_systemized' => (bool)$data['UserAttributeSetting']['is_systemized']
		//	);
		//
		//	$params['is_usable_user_manager'] =
		//			(bool)Hash::extract($pluginsRoles, '{n}.PluginsRole[role_key=' . $params['role_key'] . ']');
		//
		//	$userAttributeRole = $model->UserAttributesRole->defaultUserAttributeRolePermissions($params);
		//	if (! $model->UserAttributesRole->save($userAttributeRole, array('validate' => false))) {
		//		throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		//	}
		//}

		return true;
	}

/**
 * Get now()
 *
 * @param Model $model Model using this behavior
 * @param string $field Room data
 * @return string now()
 */
	private function __now(Model $model, $field) {
		$db = $model->getDataSource();

		$colType = array_merge(array('formatter' => 'date'), $db->columns[$model->getColumnType($field)]);
		$time = time();
		if (array_key_exists('format', $colType)) {
			$time = call_user_func($colType['formatter'], $colType['format']);
		}

		return $time;
	}

/**
 * Create query sql
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

}
