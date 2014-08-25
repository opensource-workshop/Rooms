<?php
/**
 * PartsRoomsUser Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PartsRoomsUser', 'Rooms.Model');

/**
 * Summary for PartsRoomsUser Test Case
 */
class PartsRoomsUserTest extends CakeTestCase {

/**
 * 存在するユーザ
 *
 * @var int
 */
	const EXISTING_USER_IN_ROOM = 1;

/**
 * 存在するルーム
 *
 * @var int
 */
	const EXISTING_ROOM = 1;

/**
 * 存在しないユーザ
 *
 * @var int
 */
	const NOT_EXISTING_USER = 10000;

/**
 * 存在しないルーム
 *
 * @var int
 */
	const NOT_EXISTING_ROOM = 10000;

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.parts_rooms_user',
		'plugin.rooms.room',
		'plugin.rooms.room_part',
		'plugin.rooms.group',
		'plugin.rooms.language',
		'plugin.rooms.groups_language',
		'plugin.rooms.user',
		'plugin.rooms.groups_user',
		'plugin.rooms.space',
		'plugin.rooms.box',
		'plugin.rooms.block',
		'plugin.rooms.blocks_language',
		'plugin.rooms.page',
		'plugin.rooms.part',
		'plugin.rooms.languages_part'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PartsRoomsUser = ClassRegistry::init('Rooms.PartsRoomsUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PartsRoomsUser);
		parent::tearDown();
		CakeSession::delete('Auth.User.id');
	}

/**
 * tear getPart
 *
 * @return void
 */
	public function testGetPart() {
		//ログインしていない ルームは存在している。
		CakeSession::delete('Auth.User.id');
		$rtn = $this->PartsRoomsUser->getPart(self::EXISTING_ROOM);
		$this->assertEquals($rtn, array());

		//存在しているルームにログインしている。
		CakeSession::write('Auth.User.id', self::EXISTING_USER_IN_ROOM);
		$rtn = $this->PartsRoomsUser->getPart(self::EXISTING_ROOM);
		$this->assertTrue(is_array($rtn['PartsRoomsUser']));
		$this->assertTrue(is_array($rtn['Room']));
		$this->assertTrue(is_array($rtn['Part']));
		$this->assertTrue(is_array($rtn['RoomPart']));

		//ルームが存在しない
		CakeSession::write('Auth.User.id', self::EXISTING_USER_IN_ROOM);
		$rtn = $this->PartsRoomsUser->getPart(self::NOT_EXISTING_ROOM);
		$this->assertEquals($rtn, array());

		//ユーザが存在しない
		CakeSession::write('Auth.User.id', self::NOT_EXISTING_USER);
		$rtn = $this->PartsRoomsUser->getPart(self::EXISTING_ROOM);
		$this->assertEquals($rtn, array());

		//ルームもユーザも存在しない
		CakeSession::write('Auth.User.id', self::NOT_EXISTING_USER);
		$rtn = $this->PartsRoomsUser->getPart(self::NOT_EXISTING_ROOM);
		$this->assertEquals($rtn, array());
	}

}
