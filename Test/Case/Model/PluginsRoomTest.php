<?php
/**
 * PluginsRoom Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.PluginRoomManager.Test.Model.Case
 */

App::uses('PluginsRoom', 'Rooms.Model');

/**
 * PluginsRoom Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.PluginRoomManager.Test.Model.Case
 */
class PluginsRoomTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'plugin.rooms.language',
		'plugin.rooms.languages_plugin',
		'plugin.rooms.plugin',
		'plugin.rooms.plugins_room',
		'plugin.rooms.room',
	);

/**
 * setUp method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function setUp() {
		parent::setUp();
		$this->PluginsRoom = ClassRegistry::init('Rooms.PluginsRoom');
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function tearDown() {
		unset($this->PluginsRoom);
		parent::tearDown();
	}

/**
 * testIndex
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

/**
 * testGetPlugins
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testGetPlugins() {
		$roomId = 1;
		$langId = 2;
		$plugins = $this->PluginsRoom->getPlugins($roomId, $langId);

		$this->assertTrue(is_array($plugins));
	}

/**
 * testGetPluginsError
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testGetPluginsRoomIdError() {
		$checks = array(
			array('roomId' => null, 'langId' => 2),
			array('roomId' => 0, 'langId' => 2),
			array('roomId' => 'aaaa', 'langId' => 2),
		);
		foreach ($checks as $check) {
			$roomId = $check['roomId'];
			$langId = $check['langId'];
			$plugins = $this->PluginsRoom->getPlugins($roomId, $langId);

			$this->assertFalse($plugins, print_r($check, true));
		}
	}

/**
 * testGetPluginsIrregular
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function testGetPluginsLangIdError() {
		$checks = array(
			array('roomId' => 1, 'langId' => null),
			array('roomId' => 1, 'langId' => 0),
			array('roomId' => 1, 'langId' => 'aaaa'),
		);
		foreach ($checks as $check) {
			$roomId = $check['roomId'];
			$langId = $check['langId'];
			$plugins = $this->PluginsRoom->getPlugins($roomId, $langId);

			$this->assertFalse(isset($plugins['LanguagesPlugin']), print_r($check, true));
		}
	}

}
