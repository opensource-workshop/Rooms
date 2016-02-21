<?php
/**
 * RoomsLanguageFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RolesRoomFixture', 'Rooms.Test/Fixture');

/**
 * RolesRoom4testFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RolesRoom4testFixture extends RolesRoomFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'RolesRoom';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'roles_rooms';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'room_id' => '1',
			'role_key' => 'room_administrator',
		),
		array(
			'id' => '2',
			'room_id' => '1',
			'role_key' => 'chief_editor',
		),
		array(
			'id' => '3',
			'room_id' => '1',
			'role_key' => 'editor',
		),
		array(
			'id' => '4',
			'room_id' => '1',
			'role_key' => 'general_user',
		),
		array(
			'id' => '5',
			'room_id' => '1',
			'role_key' => 'visitor',
		),
		//別ルーム(room_id=4)
		array(
			'id' => '6',
			'room_id' => '4',
			'role_key' => 'room_administrator',
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '7',
			'room_id' => '5',
			'role_key' => 'room_administrator',
		),
		//別ルーム(room_id=6, 準備中)
		array(
			'id' => '8',
			'room_id' => '6',
			'role_key' => 'room_administrator',
		),
		//別ルーム(room_id=7, プライベートルーム)
		array(
			'id' => '9',
			'room_id' => '7',
			'role_key' => 'room_administrator',
		),
	);

}
