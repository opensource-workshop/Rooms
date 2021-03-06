<?php
/**
 * RoomBehavior::getRolesRooms()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * RoomBehavior::getRolesRooms()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Behavior\RoomBehavior
 */
class RoomBehaviorGetRolesRoomsTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_room4test',
		'plugin.rooms.roles_rooms_user4test',
		'plugin.rooms.room4test',
		'plugin.rooms.rooms_language4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'rooms';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Rooms', 'TestRooms');
		$this->TestModel = ClassRegistry::init('TestRooms.TestRoomBehaviorModel');
	}

/**
 * getRolesRooms()のテスト
 *
 * @return void
 */
	public function testGetRolesRooms() {
		//テストデータ
		$roomId = '5';
		$roleKey = 'room_administrator';
		$conditions = array(
			'Room.id' => $roomId,
			'RolesRoom.role_key' => $roleKey,
		);

		//テスト実施
		$result = $this->TestModel->getRolesRoomsInDraft($conditions);

		//チェック
		$this->assertEquals(array('RolesRoom', 'Room'), array_keys($result[0]));
		$this->assertEquals('6', Hash::get($result, '0.RolesRoom.id'));
		$this->assertEquals($roomId, Hash::get($result, '0.RolesRoom.room_id'));
		$this->assertEquals($roleKey, Hash::get($result, '0.RolesRoom.role_key'));
		$this->assertEquals($roomId, Hash::get($result, '0.Room.id'));
		$this->assertNotNull(Hash::get($result, '0.Room.page_id_top'));
	}

}
