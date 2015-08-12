<?php
/**
 * RoomRolePermission Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomRolePermission', 'Rooms.Model');

/**
 * RoomRolePermission Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model
 */
class RoomRolePermissionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.room_role_permission',
		//'plugin.rooms.roles_room',
		//'plugin.rooms.user',
		//'plugin.rooms.role',
		//'plugin.rooms.language',
		//'plugin.rooms.plugin',
		//'plugin.rooms.plugins_role',
		//'plugin.rooms.room'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RoomRolePermission = ClassRegistry::init('Rooms.RoomRolePermission');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RoomRolePermission);

		parent::tearDown();
	}

/**
 * test dummy method
 *
 * @return void
 */
	public function test() {
	}

}
