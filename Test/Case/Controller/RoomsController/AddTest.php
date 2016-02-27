<?php
/**
 * RoomsController::add()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsController::add()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\RoomsController
 */
class RoomsControllerAddTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.languages_page',
		'plugin.rooms.default_role_permission4test',
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
 * edit用DataProvider
 *
 * ### 戻り値
 *  - spaceId スペースID
 *  - roomId ルームID
 *  - login ログインの有無
 *  - exception ExceptionErrorの有無
 *
 * @return array
 */
	public function dataProviderEditGet() {
		$results = array();

		//テストデータ
		$results[0] = array(
			'spaceId' => '2', 'roomId' => '1', 'rootId' => '1', 'parentId' => '1', 'pageId' => '1'
		);
		$results[1] = array(
			'spaceId' => '4', 'roomId' => '6', 'rootId' => '3', 'parentId' => '6', 'pageId' => '5'
		);
		$results[2] = array(
			'spaceId' => '4', 'roomId' => '3', 'rootId' => '3', 'parentId' => '3', 'pageId' => null
		);

		return $results;
	}

/**
 * add()アクションのテスト(GETのテスト)
 *
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $rootId ルートID
 * @param int $parentId 親ルームID
 * @param int $pageId ページID
 * @dataProvider dataProviderEditGet
 * @return void
 */
	public function testAddGet($spaceId, $roomId, $rootId, $parentId, $pageId) {
		//テスト実行
		$this->_testGetAction(array('action' => 'add', $spaceId, $roomId), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assetAdd($this->view, $spaceId, $roomId, $rootId, $parentId, $pageId);
	}

/**
 * add()アクションのチェック
 *
 * @param string $result 結果
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $rootId ルートID
 * @param int $parentId 親ルームID
 * @param int $pageId ページID
 * @return void
 */
	private function __assetAdd($result, $spaceId, $roomId, $rootId, $parentId, $pageId) {
		$pattern = '/<form action=".*?' . preg_quote('/rooms/rooms/add/' . $spaceId . '/' . $roomId, '/') . '"/';
		$this->assertRegExp($pattern, $result);

		$this->assertInput('input', '_method', 'POST', $result);
		$this->assertInput('input', 'data[Room][id]', null, $result);
		$this->assertInput('input', 'data[Room][space_id]', $spaceId, $result);
		$this->assertInput('input', 'data[Room][root_id]', $rootId, $result);
		$this->assertInput('input', 'data[Room][parent_id]', $parentId, $result);
		$this->assertInput('input', 'data[Page][parent_id]', $pageId, $result);

		$this->assertInput('input', 'data[RoomsLanguage][0][name]', null, $result);

		$pattern = '/<button type="button".*?".*?onclick=".*?' . preg_quote('/rooms/rooms/index/' . $spaceId, '/') . '\'" name="cancel">/';
		$this->assertRegExp($pattern, $result);

		$pattern = '/<button name="save"/';
		$this->assertRegExp($pattern, $result);
	}

/**
 * add()アクションのチェック
 *
 * @param string $result 結果
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $rootId ルートID
 * @param int $parentId 親ルームID
 * @param int $pageId ページID
 * @return void
 */
	private function __data() {
		$roomId = '';
		$data = array(
			'Room' => array(
				'id' => $roomId,
				'space_id' => '2',
				'root_id' => '1',
				'parent_id' => '1',
				'default_participation' => '1',
				'default_role_key' => 'visitor',
				'need_approval' => '1',
				'active' => '1',
			),
			'Page' => array('parent_id' => '1'),
			'RoomsLanguage' => array(
				0 => array('id' => '', 'room_id' => $roomId, 'language_id' => '1', 'name' => 'Test room'),
				1 => array('id' => '', 'room_id' => $roomId, 'language_id' => '2', 'name' => 'Test room'),
			),
			'RoomRolePermission' => array(
				'content_publishable' => array(
					'room_administrator' => array('id' => ''),
					'chief_editor' => array('id' => '', 'value' => '1'),
					'editor' => array('id' => '', 'value' => '1'),
				),
				'html_not_limited' => array(
					'room_administrator' => array('id' => '', 'value' => '1'),
					'chief_editor' => array('id' => '', 'value' => '1'),
					'editor' => array('id' => '', 'value' => '1'),
					'general_user' => array('id' => '', 'value' => '1'),
				),
			),
		);
		return $data;
	}

/**
 * add()アクションのテスト(POSTのテスト)
 *
 * @return void
 */
	public function testAddPost() {
		//テスト実行
		$data = $this->__data();
		$this->_testPostAction('post', $data, array('action' => 'add', '2', '1'), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$pattern = '/' . preg_quote('/rooms/rooms_roles_users/edit/2/9', '/') . '/';
		$this->assertRegExp($pattern, $header['Location']);
	}

/**
 * add()アクションのテスト(POSTのテスト)
 *
 * @return void
 */
	public function testAddPostValidationError() {
		//テスト実行
		$data = $this->__data();
		$data = Hash::insert($data, 'RoomsLanguage.{n}.name', '');
		$this->_testPostAction('post', $data, array('action' => 'add', '2', '1'), null, 'view');

		//チェック
		$this->__assetAdd($this->view, '2', '1', '1', '1', '1');

		$pattern = '<div class="help-block">' .
						sprintf(__d('net_commons', 'Please input %s.'), __d('rooms', 'Room name')) .
					'</div>';
		$this->assertTextContains($pattern, $this->view);
	}

}
