<?php
/**
 * PartsRoomsUser Model
 *
 * @property Room $Room
 * @property User $User
 * @property Part $Part
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RoomsAppModel', 'Rooms.Model');

/**
 * Summary for PartsRoomsUser Model
 */
class PartsRoomsUser extends RoomsAppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Part' => array(
			'className' => 'Part',
			'foreignKey' => 'part_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RoomPart' => array(
			'className' => 'RoomPart',
			'foreignKey' => 'part_id',
			'conditions' => 'RoomPart.part_id=Part.id',
			'fields' => '',
			'order' => ''
		)
	);

/**
 *  get user's data
 *
 * @param int $room_id rooms.id
 * @return array
 */
	public function getPart($room_id) {
		return $this->find('first', array(
			'conditions' => array(
				$this->name.'.user_id' => CakeSession::read('Auth.User.id'),
				'and' => array(
					$this->name.'.room_id' => $room_id
				)
			)
		));
	}
}
