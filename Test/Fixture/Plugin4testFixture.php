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

App::uses('PluginFixture', 'PluginManager.Test/Fixture');

/**
 * Unitテスト用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Fixture
 */
class Plugin4testFixture extends PluginFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Plugin';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'plugins';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'language_id' => '2',
			'key' => 'user_manager',
			'name' => 'User Manager',
			'weight' => '1',
			'type' => '2',
			'default_action' => 'user_manager/index',
			'default_setting_action' => '',
		),
		array(
			'language_id' => '2',
			'key' => 'rooms',
			'name' => 'Room manager',
			'weight' => '1',
			'type' => '2',
			'default_action' => 'rooms/index/2',
			'default_setting_action' => '',
		),
		array(
			'language_id' => '2',
			'key' => 'tests',
			'name' => 'Test plugin',
			'weight' => '1',
			'type' => '1',
			'default_action' => 'tests/index',
			'default_setting_action' => 'tests/edit',
		),
		array(
			'language_id' => '2',
			'key' => 'test2s',
			'name' => 'Test plugin 2',
			'weight' => '2',
			'type' => '1',
			'default_action' => 'test2s/index',
			'default_setting_action' => 'test2s/edit',
		),
	);

}
