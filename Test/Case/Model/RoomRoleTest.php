<?php
/**
 * RoomRole Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomRole', 'Rooms.Model');

/**
 * RoomRole Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model
 */
class RoomRoleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.room_role',
		//'plugin.rooms.user',
		//'plugin.rooms.role',
		//'plugin.rooms.language',
		//'plugin.rooms.plugin',
		//'plugin.rooms.plugins_role',
		//'plugin.rooms.room',
		//'plugin.rooms.roles_room'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RoomRole = ClassRegistry::init('Rooms.RoomRole');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RoomRole);

		parent::tearDown();
	}

}
