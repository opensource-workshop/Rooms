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

/**
 * RoomsController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller
 */
class RoomsControllerTest extends ControllerTestCase {

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
		$this->testAction('/rooms/rooms/index', array('method' => 'get'));
		$this->assertTextNotContains('error', $this->view);
	}
}
