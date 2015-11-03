<?php
/**
 * RoomsController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsController', 'Rooms.Controller');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller
 */
class RoomsControllerTest extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		//'plugin.m17n.language',
		//'plugin.net_commons.site_setting',
		//'plugin.pages.page',
		//'plugin.plugin_manager.plugins_room',
		//'plugin.plugin_manager.plugin',
		//'plugin.rooms.room',
		'plugin.rooms.rooms_language',
		//'plugin.users.user',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * index
 *
 * @return void
 */
	public function testIndex() {
		//$spaceId = '2';
		//$this->testAction('/rooms/rooms/index/' . $spaceId, array('method' => 'get'));
		//$this->assertTextNotContains('error', $this->view);
	}
}
