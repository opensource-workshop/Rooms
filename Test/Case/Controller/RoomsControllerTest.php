<?php
/**
 * RoomsController Test Case
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.Rooms.Test.Controller.Case
 */

App::uses('RoomsController', 'Rooms.Controller');

/**
 * RoomsController Test Case
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.Rooms.Test.Controller.Case
 */
class RoomsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $fixtures = array(
		'app.Session',
		'app.SiteSetting',
		'app.SiteSettingValue',
		'plugin.rooms.language',
		'plugin.rooms.languages_plugin',
		'plugin.rooms.plugin',
		'plugin.rooms.plugins_room',
		'plugin.rooms.room',
	);

/**
 * setUp
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * index
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function testIndex() {
		$this->testAction('/rooms/rooms/index', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->view);
	}
}
