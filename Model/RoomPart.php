<?php
/**
 * RoomPart Model
 *
 * @property Part $Part
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RoomsAppModel', 'Rooms.Model');

/**
 * Summary for RoomPart Model
 */
class RoomPart extends RoomsAppModel {

/**
 * room admin id
 *
 * @var int
 */
	const ROOM_ADMIN_PART_ID = 1;

/**
 * 許可されている
 *
 * @var int
 */
	const IS_ALLOW = 1;

/**
 * 許可されていない
 *
 * @var int
 */
	const IS_NOT_ALLOW = 0;

/**
 * 可変
 *
 * @var int
 */
	const IS_CHANGEABLE = 2;

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Part' => array(
			'className' => 'Part',
			'foreignKey' => 'part_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
