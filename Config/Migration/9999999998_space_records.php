<?php
/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Config\Migration
 */
class SpaceRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'space_records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * Records keyed by model name.
 *
 * @var array $records
 */
	public $records = array(
		'Space' => array(
			array(
				'id' => '1',
				'parent_id' => null,
				'lft' => '1',
				'rght' => '8',
				'type' => '1',
				'plugin_key' => null,
				'default_setting_action' => null
			),
			array(
				'id' => '2',
				'parent_id' => '1',
				'lft' => '2',
				'rght' => '3',
				'type' => '2',
				'plugin_key' => 'public_space',
				'default_setting_action' => 'rooms/index/2'
			),
			array(
				'id' => '3',
				'parent_id' => '1',
				'lft' => '4',
				'rght' => '5',
				'type' => '3',
				'plugin_key' => 'private_space',
				'default_setting_action' => ''
			),
			array(
				'id' => '4',
				'parent_id' => '1',
				'lft' => '6',
				'rght' => '7',
				'type' => '4',
				'plugin_key' => 'room_space',
				'default_setting_action' => 'rooms/index/4'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}

		return true;
	}
}
