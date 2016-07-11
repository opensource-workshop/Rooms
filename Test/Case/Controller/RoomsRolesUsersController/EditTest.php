<?php
/**
 * RoomsRolesUsersController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsRolesUsersController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\RoomsRolesUsersController
 */
class RoomsRolesUsersControllerEditTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.data_types.data_type4test',
		'plugin.data_types.data_type_choice4test',
		'plugin.groups.group',
		'plugin.groups.groups_user',
		'plugin.rooms.roles_room4test',
		'plugin.rooms.roles_rooms_user4test',
		'plugin.rooms.room4test',
		'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.rooms_language4test',
		'plugin.rooms.space',
		'plugin.user_attributes.user_attribute4test',
		'plugin.user_attributes.user_attribute_choice4test',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting4test',
		'plugin.user_attributes.user_attributes_role4test',
		'plugin.user_attributes.user_role_setting4test',
		'plugin.users.users_language4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'rooms';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'rooms_roles_users';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);
		parent::tearDown();
	}

/**
 * edit()アクションのGETリクエストテスト
 *
 * @return void
 */
	public function testEditGet() {
		//テストデータ
		$spaceId = '2';
		$roomId = '4';

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', $spaceId, $roomId), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertInput('form', null, '/rooms/rooms_roles_users/edit/' . $spaceId . '/' . $roomId, $this->view);
		$this->__assetEditGet($spaceId, $roomId);
		$this->__assetEditGetUser($roomId, '1', '6');
	}

/**
 * edit()アクションのGETリクエストテスト(クエリあり)
 *
 * @return void
 */
	public function testEditGetWithQuery() {
		//テストデータ
		$spaceId = '2';
		$roomId = '4';

		//テスト実行
		$this->_testGetAction(
			array('action' => 'edit', $spaceId, $roomId, '?' => array('search' => '1')),
			array('method' => 'assertNotEmpty'), null, 'view'
		);

		//チェック
		$this->assertInput('form', null, '/rooms/rooms_roles_users/edit/' . $spaceId . '/' . $roomId . '?search=1', $this->view);
		$this->__assetEditGet($spaceId, $roomId);
		$this->__assetEditGetUser($roomId, '1', '6');
		$this->__assetEditGetUser($roomId, '2', null);
		$this->__assetEditGetUser($roomId, '3', null);
	}

/**
 * edit()アクションのチェック
 *
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @return void
 */
	private function __assetEditGet($spaceId, $roomId) {
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Room][id]', $roomId, $this->view);

		$this->assertTextContains('<button name="search"', $this->view);
		$this->assertInput('select', 'data[Role][key]', '', $this->view);
		$this->assertTextContains('/rooms/rooms_roles_users/edit/' . $spaceId . '/' . $roomId . '/sort:RoomRole.level/direction:asc', $this->view);
	}

/**
 * edit()アクションのチェック(user)
 *
 * @param int $roomId ルームID
 * @param int $userId ユーザID
 * @param int $rolesRoomUserId ロールルームID
 * @return void
 */
	private function __assetEditGetUser($roomId, $userId, $rolesRoomUserId) {
		$this->assertInput('input', 'data[RolesRoomsUser][' . $userId . '][id]', $rolesRoomUserId, $this->view);
		$this->assertInput('input', 'data[RolesRoomsUser][' . $userId . '][user_id]', $userId, $this->view);
		$this->assertInput('input', 'data[RolesRoomsUser][' . $userId . '][room_id]', $roomId, $this->view);
		$this->assertInput('select', 'data[RolesRoom][' . $userId . '][role_key]', '', $this->view);

		$name = 'data[User][id][' . $userId . ']';
		$domId = 'UserId' . $userId;
		$this->assertTextContains('name="' . $name . '" id="' . $domId . '_" value="0"', $this->view);
		$pattern = '<input type="checkbox" name="' . preg_quote($name, '/') . '".+?value="1" id="' . $domId . '"';
		$this->assertRegExp('/' . $pattern . '/', $this->view);
	}

/**
 * リクエストデータ作成
 *
 * @return array リクエストデータ
 */
	private function __dataSave() {
		$data = array(
			'Room' => array('id' => '4'),
			'Role' => array('key' => 'room_administrator'),
			'User' => array('id' => array('1' => '0', '2' => '1', '3' => '1', '4' => '0')),
			'RolesRoomsUser' => array(
				'1' => array('id' => '6', 'user_id' => '1', 'room_id' => '4'),
				'2' => array('id' => null, 'user_id' => '2', 'room_id' => '4'),
				'3' => array('id' => null, 'user_id' => '3', 'room_id' => '4'),
				'4' => array('id' => null, 'user_id' => '4', 'room_id' => '4'),
			),
		);
		return $data;
	}

/**
 * edit()アクションのテスト(POSTのテスト)
 *
 * @return void
 */
	public function testEditPost() {
		//テストデータ
		$spaceId = '2';
		$roomId = '4';

		//テスト実行
		$data = $this->__dataSave();
		$this->_testPostAction('put', $data,
				array('action' => 'edit', $spaceId, $roomId, '?' => array('search' => '1')), null, 'view');

		//チェック
		$this->assertInput('form', null, '/rooms/rooms_roles_users/edit/' . $spaceId . '/' . $roomId . '?search=1', $this->view);
		$this->__assetEditGet($spaceId, $roomId);
		$this->__assetEditGetUser($roomId, '1', '6');
		$this->__assetEditGetUser($roomId, '2', null);
		$this->__assetEditGetUser($roomId, '3', null);
	}

/**
 * edit()アクションのExpectionErrorテスト(POSTのテスト)
 *
 * @return void
 */
	public function testEditPostOnExpectionError() {
		//テストデータ
		$spaceId = '2';
		$roomId = '4';
		$this->_mockForReturnFalse('Rooms.RolesRoomsUser', 'saveRolesRoomsUsersForRooms');

		//テスト実行
		$data = $this->__dataSave();
		$this->_testPostAction('put', $data,
				array('action' => 'edit', $spaceId, $roomId, '?' => array('search' => '1')), null, 'view');
	}

/**
 * リクエストデータ作成
 *
 * @return array リクエストデータ
 */
	private function __dataDelete() {
		$data = array(
			'Room' => array('id' => '4'),
			'Role' => array('key' => 'delete'),
			'User' => array('id' => array('1' => '1', '2' => '0', '3' => '0', '4' => '0')),
			'RolesRoomsUser' => array(
				'1' => array('id' => '6', 'user_id' => '1', 'room_id' => '4'),
				'2' => array('id' => null, 'user_id' => '2', 'room_id' => '4'),
				'3' => array('id' => null, 'user_id' => '3', 'room_id' => '4'),
				'4' => array('id' => null, 'user_id' => '4', 'room_id' => '4'),
			),
		);
		return $data;
	}

/**
 * edit()アクションのテスト(POST(delete)のテスト)
 *
 * @return void
 */
	public function testEditDelete() {
		//テストデータ
		$spaceId = '2';
		$roomId = '4';

		//テスト実行
		$data = $this->__dataDelete();
		$this->_testPostAction('put', $data,
				array('action' => 'edit', $spaceId, $roomId, '?' => array('search' => '1')), null, 'view');

		//チェック
		$this->assertInput('form', null, '/rooms/rooms_roles_users/edit/' . $spaceId . '/' . $roomId . '?search=1', $this->view);
		$this->__assetEditGet($spaceId, $roomId);
		$this->__assetEditGetUser($roomId, '1', null);
		$this->__assetEditGetUser($roomId, '2', null);
		$this->__assetEditGetUser($roomId, '3', null);
	}
}
