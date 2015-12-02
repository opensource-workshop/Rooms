<?php
/**
 * RolesRoomsUser Model
 *
 * @property RolesRoom $RolesRoom
 * @property User $User
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppModel', 'Rooms.Model');

/**
 * RolesRoomsUser Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Model
 */
class RolesRoomsUser extends RoomsAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'RolesRoom' => array(
			'className' => 'Rooms.RolesRoom',
			'foreignKey' => 'roles_room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			//'roles_room_id' => array(
			//	'numeric' => array(
			//		'rule' => array('numeric'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		//'allowEmpty' => false,
			//		//'required' => false,
			//		//'last' => false, // Stop validation after this rule
			//		//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//	),
			//),
			'user_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Return roles_rooms_users
 *
 * @param array $conditions Conditions by Model::find
 * @return array
 */
	public function getRolesRoomsUsers($conditions = array()) {
		$this->Room = ClassRegistry::init('Rooms.Room');

		$conditions = Hash::merge(array(
				'Room.page_id_top NOT' => null,
			), $conditions);

		$rolesRoomsUsers = $this->find('all', array(
			'recursive' => -1,
			'fields' => array(
				$this->alias . '.*',
				$this->RolesRoom->alias . '.*',
				$this->Room->alias . '.*',
			),
			'joins' => array(
				array(
					'table' => $this->RolesRoom->table,
					'alias' => $this->RolesRoom->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->alias . '.roles_room_id' . ' = ' . $this->RolesRoom->alias . ' .id',
					),
				),
				array(
					'table' => $this->Room->table,
					'alias' => $this->Room->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->RolesRoom->alias . '.room_id' . ' = ' . $this->Room->alias . ' .id',
					),
				),
				array(
					'table' => $this->User->table,
					'alias' => $this->User->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->alias . '.user_id' . ' = ' . $this->User->alias . ' .id',
					),
				),
			),
			'conditions' => $conditions,
		));

		return $rolesRoomsUsers;
	}

/**
 * RolesRoomsUserの登録処理
 *
 * @param array $data リクエストデータ
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveRolesRoomsUser($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data['RolesRoomsUser']);
		if (! $this->validates()) {
			return false;
		}

		try {
			//Roomデータの登録
			if (! $rolesRoomsUser = $this->save($data['RolesRoomsUser'], false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return $rolesRoomsUser;
	}

/**
 * RolesRoomsUserの一括登録
 *
 * @param array $data リクエストデータ
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveRolesRoomsUsers($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		if (! $this->validateMany($data['RolesRoomsUser'])) {
			return false;
		}

		try {
			//RolesRoomsUserデータの登録
			if (! $this->saveMany($data['RolesRoomsUser'], ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * アクセス日時の登録処理
 *
 * @param int $roleRoomUserId ロール・ルーム・ユーザID
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveAccessed($roleRoomUserId) {
		//トランザクションBegin
		$this->begin();

		$db = $this->getDataSource();

		try {
			//登録処理
			$update = array(
				$this->alias . '.access_count' => 'access_count + 1',
				$this->alias . '.accessed' => $db->value(date('Y-m-d H:i:s'), 'string'),
			);
			$conditions = array($this->alias . '.id' => (int)$roleRoomUserId);
			if (! $this->updateAll($update, $conditions)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			CakeLog::error($ex);
			$this->rollback();
		}

		$this->setSlaveDataSource();

		return true;
	}

/**
 * RolesRoomsUserの削除処理
 *
 * @param array $data リクエストデータ
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteRolesRoomsUser($data) {
		//トランザクションBegin
		$this->begin();

		try {
			//RolesRoomsUserデータの削除
			if (! $this->delete($data['RolesRoomsUser']['id'], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * RolesRoomsUserの一括削除処理
 *
 * @param array $data リクエストデータ
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteRolesRoomsUsers($data) {
		//トランザクションBegin
		$this->begin();

		try {
			//RolesRoomsUserデータの削除
			$ids = Hash::extract($data['RolesRoomsUser'], '{n}.id');
			if (! $this->deleteAll(array($this->alias . '.id' => $ids), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
