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
 * Might change authority
 *
 * @var int
 */
	const CHANGEABLE_PERMISSION = 2;

/**
 * is authority
 *
 * @var int
 */
	const IS_PERMISSION = 1;

/**
 * There is no authority
 *
 */
	const NOT_PERMISSION = 0;

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
