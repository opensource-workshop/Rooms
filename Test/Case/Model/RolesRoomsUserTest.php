<?php
/**
 * RolesRoomsUser Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RolesRoomsUser', 'Rooms.Model');

/**
 * RolesRoomsUser Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model
 */
class RolesRoomsUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_rooms_user',
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
		$this->RolesRoomsUser = ClassRegistry::init('Rooms.RolesRoomsUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RolesRoomsUser);

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
