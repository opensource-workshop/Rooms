<?php
/**
 * RoomRolePermission Model
 *
 * @property RolesRoom $RolesRoom
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppModel', 'Rooms.Model');

/**
 * RoomRolePermission Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Model
 */
class RoomRolePermission extends RoomsAppModel {

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
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * validate of RoomRolePermission
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
//	public function validateRoomRolePermission($data) {
//		$this->set($data);
//		$this->validates();
//		if ($this->validationErrors) {
//			return false;
//		}
//		return true;
//	}

}
