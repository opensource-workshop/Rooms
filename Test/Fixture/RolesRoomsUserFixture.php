<?php
/**
 * RolesRoomsUserFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * RolesRoomsUserFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RolesRoomsUserFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		// * room_id=2、ユーザID=1
		array(
			'id' => '1',
			'roles_room_id' => '1',
			'user_id' => '1',
			'room_id' => '2',
			'access_count' => '0',
			'last_accessed' => null,
			'previous_accessed' => null,
		),
		// * room_id=2、ユーザID=2
		array(
			'id' => '2',
			'roles_room_id' => '2',
			'user_id' => '2',
			'room_id' => '2',
			'access_count' => '0',
			'last_accessed' => null,
			'previous_accessed' => null,
		),
		// * room_id=2、ユーザID=3
		array(
			'id' => '3',
			'roles_room_id' => '3',
			'user_id' => '3',
			'room_id' => '2',
			'access_count' => '0',
			'last_accessed' => null,
			'previous_accessed' => null,
		),
		// * room_id=2、ユーザID=4
		array(
			'id' => '4',
			'roles_room_id' => '4',
			'user_id' => '4',
			'room_id' => '2',
			'access_count' => '0',
			'last_accessed' => null,
			'previous_accessed' => null,
		),
		// * room_id=2、ユーザID=5
		array(
			'id' => '5',
			'roles_room_id' => '5',
			'user_id' => '5',
			'room_id' => '2',
			'access_count' => '0',
			'last_accessed' => null,
			'previous_accessed' => null,
		),
		// * 別ルーム(room_id=5)
		array(
			'id' => '6',
			'roles_room_id' => '6',
			'user_id' => '1',
			'room_id' => '5',
			'access_count' => '0',
			'last_accessed' => null,
			'previous_accessed' => null,
		),
		// * 別ルーム(room_id=6、ブロックなし)
		array(
			'id' => '7',
			'roles_room_id' => '7',
			'user_id' => '1',
			'room_id' => '6',
			'access_count' => '0',
			'last_accessed' => null,
			'previous_accessed' => null,
		),

		//サイト全体
		// * room_id=1、ユーザID=1
		array(
			'id' => '11',
			'roles_room_id' => '15',
			'user_id' => '1',
			'room_id' => '1',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Rooms') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new RoomsSchema())->tables['roles_rooms_users'];
		parent::init();
	}

}
