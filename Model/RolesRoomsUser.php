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
		)
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
			'roles_room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
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
 * @param int $roomId rooms.id
 * @return array
 */
	public function getUsersByRoomId($roomId) {
//		$this->Room = ClassRegistry::init('Rooms.Room');
//		$this->Role = ClassRegistry::init('Roles.Role');
//		$this->UsersLanguage = ClassRegistry::init('Users.UsersLanguage');
//
//		$rolesRoomUsers = $this->find('all', array(
//			'recursive' => -1,
//			'fields' => array(
//				$this->alias . '.*',
//				$this->User->alias . '.*',
//				$this->UsersLanguage->alias . '.*',
//				$this->Role->alias . '.*',
//			),
//			'joins' => array(
//				array(
//					'table' => $this->RolesRoom->table,
//					'alias' => $this->RolesRoom->alias,
//					'type' => 'INNER',
//					'conditions' => array(
//						$this->alias . '.roles_room_id' . ' = ' . $this->RolesRoom->alias . ' .id',
//					),
//				),
//				array(
//					'table' => $this->User->table,
//					'alias' => $this->User->alias,
//					'type' => 'INNER',
//					'conditions' => array(
//						$this->alias . '.user_id' . ' = ' . $this->User->alias . ' .id',
//					),
//				),
//				array(
//					'table' => $this->UsersLanguage->table,
//					'alias' => $this->UsersLanguage->alias,
//					'type' => 'INNER',
//					'conditions' => array(
//						$this->UsersLanguage->alias . '.user_id' . ' = ' . $this->User->alias . ' .id',
//						$this->UsersLanguage->alias . '.language_id' => Configure::read('Config.languageId')
//					),
//				),
//				array(
//					'table' => $this->Role->table,
//					'alias' => $this->Role->alias,
//					'type' => 'INNER',
//					'conditions' => array(
//						$this->Role->alias . '.key' . ' = ' . $this->RolesRoom->alias . ' .role_key',
//						$this->Role->alias . '.language_id' => Configure::read('Config.languageId')
//					),
//				),
//			),
//			'conditions' => array(
//				$this->RolesRoom->alias . '.room_id' => (int)$roomId,
//			),
//		));

		$rolesRoomUsers = array();
		return $rolesRoomUsers;
	}

}
