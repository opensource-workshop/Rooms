<?php
/**
 * Unitテスト用Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PluginsRoomFixture', 'PluginManager.Test/Fixture');

/**
 * Unitテスト用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class PluginsRoom4testFixture extends PluginsRoomFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'PluginsRoom';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'plugins_rooms';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'room_id' => '1',
			'plugin_key' => 'test'
		),
		array(
			'id' => '2',
			'room_id' => '1',
			'plugin_key' => 'test2'
		),
		array(
			'id' => '3',
			'room_id' => '2',
			'plugin_key' => 'test'
		),
		array(
			'id' => '4',
			'room_id' => '2',
			'plugin_key' => 'test2'
		),
		array(
			'id' => '5',
			'room_id' => '5',
			'plugin_key' => 'test3'
		),
		array(
			'id' => '6',
			'room_id' => '5',
			'plugin_key' => 'tests'
		),
		array(
			'id' => '7',
			'room_id' => '3',
			'plugin_key' => 'tests'
		),
	);

}
