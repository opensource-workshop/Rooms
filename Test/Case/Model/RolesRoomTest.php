<?php
/**
 * RolesRoom Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RolesRoom', 'Rooms.Model');

/**
 * RolesRoom Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model
 */
class RolesRoomTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_room',
		//'plugin.rooms.room',
		//'plugin.rooms.user',
		//'plugin.rooms.role',
		//'plugin.rooms.language',
		//'plugin.rooms.plugin',
		//'plugin.rooms.plugins_role',
		//'plugin.rooms.block_role_permission',
		//'plugin.rooms.room_role_permission',
		//'plugin.rooms.roles_rooms_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RolesRoom = ClassRegistry::init('Rooms.RolesRoom');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RolesRoom);

		parent::tearDown();
	}

}
