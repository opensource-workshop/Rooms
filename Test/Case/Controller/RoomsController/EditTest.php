<?php
/**
 * RoomsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\RoomsController
 */
class RoomsControllerEditTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.languages_page',
		'plugin.rooms.default_role_permission4test',
		'plugin.rooms.page4test',
		'plugin.rooms.plugins_room4test',
		'plugin.rooms.plugin4test',
		'plugin.rooms.plugins_role4test',
		'plugin.rooms.roles_room4test',
		'plugin.rooms.roles_rooms_user4test',
		'plugin.rooms.room4test',
		'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission4test',
		'plugin.rooms.rooms_language4test',
		'plugin.rooms.space',
		'plugin.user_roles.user_role_setting',
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
	protected $_controller = 'rooms';

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
 * add用DataProvider
 *
 * ### 戻り値
 *  - spaceId スペースID
 *  - roomId ルームID
 *  - rootId ルートID
 *  - parentId 親ルームID
 *  - pageId ページID
 *
 * @return array
 */
	public function dataProviderEditGet() {
		$results = array();

		//テストデータ
		$results[0] = array(
			'spaceId' => '2', 'roomId' => '1', 'rootId' => null, 'parentId' => null, 'pageId' => '1', 'participationFixed' => true,
			'expected' => array()
		);
		$results[1] = array(
			'spaceId' => '4', 'roomId' => '6', 'rootId' => '3', 'parentId' => '3', 'pageId' => '5', 'participationFixed' => false,
			'expected' => array(
				'Room' => array(
					'default_role_key' => 'general_user',
					'active' => '0',
					'default_participation' => '0',
				),
				'RoomRolePermission' => array(
					'content_publishable' => array(
						'room_administrator' => array('id' => ''),
						'chief_editor' => array('id' => ''),
						'editor' => array('id' => ''),
					),
				),
			)
		);
		$results[2] = array(
			'spaceId' => '4', 'roomId' => '3', 'rootId' => null, 'parentId' => null, 'pageId' => null, 'participationFixed' => false,
			'expected' => array(
				'Room' => array(
					'default_role_key' => 'general_user',
				),
				'RoomRolePermission' => array(
					'content_publishable' => array(
						'room_administrator' => array('id' => ''),
						'chief_editor' => array('id' => ''),
						'editor' => array('id' => ''),
					),
				),
			)
		);

		return $results;
	}

/**
 * edit()アクションのテスト(GETのテスト)
 *
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $rootId ルートID
 * @param int $parentId 親ルームID
 * @param int $pageId ページID
 * @param bool $participationFixed デフォルト参加固定フラグ
 * @param array $expected マージする期待値
 * @dataProvider dataProviderEditGet
 * @return void
 */
	public function testEdit($spaceId, $roomId, $rootId, $parentId, $pageId, $participationFixed, $expected) {
		//テスト実行
		$this->_testGetAction(array('action' => 'edit', $spaceId, $roomId), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assetEdit($spaceId, $roomId, $rootId, $parentId, $pageId, $participationFixed, $expected);
		$this->assertNotEmpty(Hash::get($this->controller->request->data, 'RoomsLanguage.0.name'));
		$this->assertNotEmpty(Hash::get($this->controller->request->data, 'RoomsLanguage.1.name'));
	}

/**
 * edit()アクションのチェック
 *
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $rootId ルートID
 * @param int $parentId 親ルームID
 * @param int $pageId ページID
 * @param bool $participationFixed デフォルト参加固定フラグ
 * @param array $expected マージする期待値
 * @return void
 */
	private function __assetEdit($spaceId, $roomId, $rootId, $parentId, $pageId, $participationFixed, $expected = array()) {
		$this->assertEqual($roomId, $this->controller->RoomsRolesForm->settings['room_id']);
		$this->assertEqual('room_role', $this->controller->RoomsRolesForm->settings['type']);
		$this->assertEqual($participationFixed, $this->controller->viewVars['participationFixed']);

		$data = $this->__data($spaceId, $roomId, $rootId, $parentId, $pageId);
		$data = Hash::merge($data, $expected);

		$this->__assetRequestData($data, 'Room.id');
		$this->__assetRequestData($data, 'Room.space_id');
		$this->__assetRequestData($data, 'Room.root_id');
		$this->__assetRequestData($data, 'Room.parent_id');
		$this->__assetRequestData($data, 'Room.default_participation');
		$this->__assetRequestData($data, 'Room.default_role_key');
		$this->__assetRequestData($data, 'Room.need_approval');
		$this->__assetRequestData($data, 'Room.active');
		$this->__assetRequestData($data, 'Page.id');
		$this->__assetRequestData($data, 'Page.parent_id');
		$this->assertNotEmpty(Hash::get($this->controller->request->data, 'RoomsLanguage.0.id'));
		$this->__assetRequestData($data, 'RoomsLanguage.0.room_id');
		$this->__assetRequestData($data, 'RoomsLanguage.0.language_id');
		$this->assertNotEmpty(Hash::get($this->controller->request->data, 'RoomsLanguage.1.id'));
		$this->__assetRequestData($data, 'RoomsLanguage.1.room_id');
		$this->__assetRequestData($data, 'RoomsLanguage.1.language_id');
		$this->__assetRequestData($data, 'RoomRolePermission.content_publishable.room_administrator.id');
		$this->__assetRequestData($data, 'RoomRolePermission.content_publishable.chief_editor.id');
		$this->__assetRequestData($data, 'RoomRolePermission.content_publishable.chief_editor.value');
		$this->__assetRequestData($data, 'RoomRolePermission.content_publishable.editor.id');
		$this->__assetRequestData($data, 'RoomRolePermission.content_publishable.editor.value');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.room_administrator.id');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.room_administrator.value');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.chief_editor.id');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.chief_editor.value');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.editor.id');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.editor.value');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.general_user.id');
		$this->__assetRequestData($data, 'RoomRolePermission.html_not_limited.general_user.value');

		$this->assertInput('form', null, '/rooms/rooms/edit/' . $spaceId . '/' . $roomId, $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Room][id]', $roomId, $this->view);
		$this->assertInput('input', 'data[Room][space_id]', $spaceId, $this->view);
		$this->assertInput('input', 'data[Room][root_id]', $rootId, $this->view);
		$this->assertInput('input', 'data[Room][parent_id]', $parentId, $this->view);
		$this->assertInput('input', 'data[Page][parent_id]', null, $this->view);

		$this->assertInput('input', 'data[RoomsLanguage][0][name]', null, $this->view);

		$pattern = '/<button type="button".*?".*?onclick=".*?' . preg_quote('/rooms/rooms/index/' . $spaceId, '/') . '\'" name="cancel">/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '/<button name="save"/';
		$this->assertRegExp($pattern, $this->view);

		if ($roomId === '6') {
			$this->assertTextContains('dangerZone', $this->view);
		} else {
			$this->assertTextNotContains('dangerZone', $this->view);
		}
	}

/**
 * request->dataのチェック
 *
 * @param array $data データ
 * @param string $keyPath Hashのキー
 * @return void
 */
	private function __assetRequestData($data, $keyPath) {
		if (in_array($keyPath, ['Room.default_participation', 'Room.need_approval', 'Room.active'], true) ||
				preg_match('/^RoomRolePermission\..+?\..+?\.value$/', $keyPath)) {
			if (Hash::get($data, $keyPath) === '0') {
				$expected = false;
			} else {
				$expected = true;
			}
		} else {
			$expected = Hash::get($data, $keyPath);
		}
		$this->assertEquals($expected, Hash::get($this->controller->request->data, $keyPath));
	}

/**
 * リクエストデータ作成
 *
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $rootId ルートID
 * @param int $parentId 親ルームID
 * @param int $pageId ページID
 * @param string $name ルーム名
 * @return array リクエストデータ
 */
	private function __data($spaceId, $roomId, $rootId, $parentId, $pageId, $name = '') {
		$data = array(
			'Room' => array(
				'id' => $roomId,
				'space_id' => $spaceId,
				'root_id' => $rootId,
				'parent_id' => $parentId,
				'default_participation' => '1',
				'default_role_key' => 'visitor',
				'need_approval' => '1',
				'active' => '1',
			),
			'Page' => array(
				'id' => $pageId,
				'parent_id' => null
			),
			'RoomsLanguage' => array(
				0 => array(
					'id' => '1',
					'room_id' => $roomId,
					'language_id' => '2',
					'name' => $name
				),
				1 => array(
					'id' => '2',
					'room_id' => $roomId,
					'language_id' => '1',
					'name' => $name
				),
			),
			'RoomRolePermission' => array(
				'content_publishable' => array(
					'room_administrator' => array(
						'id' => '7'
					),
					'chief_editor' => array(
						'id' => '18',
						'value' => '1'
					),
					'editor' => array(
						'id' => '29',
						'value' => '0'
					),
				),
				'html_not_limited' => array(
					'room_administrator' => array(
						'id' => '',
						'value' => '0'
					),
					'chief_editor' => array(
						'id' => '',
						'value' => '0'
					),
					'editor' => array(
						'id' => '',
						'value' => '0'
					),
					'general_user' => array(
						'id' => '',
						'value' => '0'
					),
				),
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
		//テスト実行
		$data = $this->__data('2', '1', null, null, '1', 'Test room');
		$this->_testPostAction('put', $data, array('action' => 'edit', '2', '1'), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$pattern = '/' . preg_quote('/rooms/rooms_roles_users/edit/2/1', '/') . '/';
		$this->assertRegExp($pattern, $header['Location']);
	}

/**
 * edit()アクションのValidationErrorテスト(POSTのテスト)
 *
 * @return void
 */
	public function testEditPostValidationError() {
		//テスト実行
		$data = $this->__data('2', '1', null, null, '1', '');
		$this->_testPostAction('put', $data, array('action' => 'edit', '2', '1'), null, 'view');

		//チェック
		$this->__assetEdit('2', '1', null, null, '1', true);
		$this->assertEmpty(Hash::get($this->controller->request->data, 'RoomsLanguage.0.name'));
		$this->assertEmpty(Hash::get($this->controller->request->data, 'RoomsLanguage.1.name'));

		$pattern = '<div class="help-block">' .
						sprintf(__d('net_commons', 'Please input %s.'), __d('rooms', 'Room name')) .
					'</div>';
		$this->assertTextContains($pattern, $this->view);
	}

}