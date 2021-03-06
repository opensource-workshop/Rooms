<?php
/**
 * RoomsAppController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsControllerTestCase', 'Rooms.TestSuite');
App::uses('UserRole', 'UserRoles.Model');

/**
 * RoomsAppController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\RoomsAppController
 */
class RoomsAppControllerBeforeFilterTest extends RoomsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
		$this->generateNc('TestRooms.TestRoomsAppControllerIndex');
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
 * index用DataProvider
 *
 * ### 戻り値
 *  - spaceId スペースID
 *  - login ログインの有無
 *  - exception ExceptionErrorの有無
 *
 * @return array
 */
	public function dataProviderIndex() {
		$results = array();

		//テストデータ
		// * ログインなし
		$results[0] = array('spaceId' => '2', 'login' => false, 'exception' => 'ForbiddenException');
		// * ログインあり、BadRequestエラー
		$results[1] = array('spaceId' => '99', 'login' => true, 'exception' => 'BadRequestException');
		// * ログインあり、正常
		$results[2] = array('spaceId' => '2', 'login' => true, 'exception' => false);

		return $results;
	}

/**
 * index()のテスト
 *
 * @param int $spaceId スペースID
 * @param bool $login ログインの有無
 * @param false|string $exception ExceptionErrorの文字列。falseの場合、Exceptionなし
 * @dataProvider dataProviderIndex
 * @return void
 */
	public function testIndex($spaceId, $login, $exception) {
		//ログイン
		if ($login) {
			TestAuthGeneral::login($this);
		}

		//テスト実行
		$this->_testGetAction('/test_rooms/test_rooms_app_controller_index/index/' . $spaceId, null, $exception);

		//チェック
		if (! $exception) {
			$pattern = '/' . preg_quote('Controller/TestRoomsAppController/index', '/') . '/';
			$this->assertRegExp($pattern, $this->view);
			$this->assertEquals($spaceId, $this->vars['activeSpaceId']);
		}
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
		// * ログインなし
		$results[0] = array(
			'spaceId' => '2', 'roomId' => '2', 'parentRoomId' => '1',
			'login' => false, 'exception' => 'ForbiddenException'
		);
		// * ログインあり、spaceId不正、BadRequestエラー
		$results[1] = array(
			'spaceId' => '99', 'roomId' => '2', 'parentRoomId' => '1',
			'login' => true, 'exception' => 'BadRequestException'
		);
		// * ログインあり、roomId不正、BadRequestエラー
		$results[2] = array(
			'spaceId' => '2', 'roomId' => '99', 'parentRoomId' => null,
			'login' => true, 'exception' => 'BadRequestException'
		);
		// * ログインあり、正常
		$results[3] = array(
			'spaceId' => '2', 'roomId' => '2', 'parentRoomId' => '1',
			'login' => true, 'exception' => false
		);
		// * ログインあり、正常(サブルーム)
		$results[4] = array(
			'spaceId' => '2', 'roomId' => '5', 'parentRoomId' => '2',
			'login' => true, 'exception' => false
		);

		return $results;
	}

/**
 * edit()のテスト
 *
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $parentRoomId 親ルームID
 * @param bool $login ログインの有無
 * @param false|string $exception ExceptionErrorの文字列。falseの場合、Exceptionなし
 * @dataProvider dataProviderEditGet
 * @return void
 */
	public function testEditGet($spaceId, $roomId, $parentRoomId, $login, $exception) {
		//ログイン
		if ($login) {
			TestAuthGeneral::login($this);
		}

		//テスト実行
		$this->_testGetAction('/test_rooms/test_rooms_app_controller_index/edit/' . $spaceId . '/' . $roomId, null, $exception);

		//チェック
		if (! $exception) {
			$pattern = '/' . preg_quote('Controller/TestRoomsAppController/edit', '/') . '/';
			$this->assertRegExp($pattern, $this->view);
			$this->assertEquals($spaceId, $this->vars['activeSpaceId']);
			$this->assertEquals($roomId, $this->vars['activeRoomId']);

			if ($parentRoomId !== '1') {
				$this->__assertRoom($this->vars['room'], $spaceId, $roomId, $parentRoomId, array('9'));
				//サイト全体は含めいないように修正
				$this->assertFalse(isset($this->vars['parentRooms'][0]));
				//$this->__assertRoom($this->vars['parentRooms'][0], '1', '1', null, array('2', '3', '4'));
				$this->__assertRoom(
					$this->vars['parentRooms'][1], $spaceId, $parentRoomId, '1', array('5', '6')
				);
			} else {
				$this->__assertRoom($this->vars['room'], $spaceId, $roomId, $parentRoomId, array('5', '6'));
				//サイト全体は含めいないように修正
				$this->assertFalse(isset($this->vars['parentRooms'][0]));
				//$this->__assertRoom($this->vars['parentRooms'][0], '1', $parentRoomId, null, array('2', '3', '4'));
			}
		}
	}

/**
 * edit用DataProvider
 *
 * ### 戻り値
 *  - method アクションタイプ(POST or PUT or DELETE)
 *  - spaceId スペースID
 *  - roomId ルームID
 *  - parentRoomId 親ルームID
 *  - login ログインの有無
 *  - exception ExceptionErrorの文字列。falseの場合、Exceptionなし
 *
 * @return array
 */
	public function dataProviderEditPost() {
		$results = array();

		//テストデータ
		// * POST
		$results[] = array(
			'method' => 'post', 'spaceId' => '2', 'roomId' => '2', 'parentRoomId' => '1',
			'login' => true, 'exception' => false
		);
		//PUT
		$results[] = array(
			'method' => 'put', 'spaceId' => '2', 'roomId' => '2', 'parentRoomId' => '1',
			'login' => true, 'exception' => false
		);
		//DELETE
		$results[] = array(
			'method' => 'put', 'spaceId' => '2', 'roomId' => '2', 'parentRoomId' => '1',
			'login' => true, 'exception' => false
		);

		return $results;
	}

/**
 * edit()のテスト
 *
 * @param string $method リクエストタイプ
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $parentRoomId 親ルームID
 * @param bool $login ログインの有無
 * @param false|string $exception ExceptionErrorの文字列。falseの場合、Exceptionなし
 * @dataProvider dataProviderEditPost
 * @return void
 */
	public function testEditPost($method, $spaceId, $roomId, $parentRoomId, $login, $exception) {
		//ログイン
		if ($login) {
			TestAuthGeneral::login($this);
		}

		//テスト実行
		$url = '/test_rooms/test_rooms_app_controller_index/edit/' . $spaceId . '/' . $roomId;
		if ($method === 'post') {
			$data = array(
				'Room' => array('id' => null, 'parent_id' => $roomId)
			);
		} else {
			$data = array(
				'Room' => array('id' => $roomId, 'parent_id' => $parentRoomId)
			);
		}
		$this->_testPostAction($method, $data, $url, $exception);

		//チェック
		if (! $exception) {
			$pattern = '/' . preg_quote('Controller/TestRoomsAppController/edit', '/') . '/';
			$this->assertRegExp($pattern, $this->view);
			$this->assertEquals($spaceId, $this->vars['activeSpaceId']);
			$this->assertEquals($roomId, $this->vars['activeRoomId']);

			if ($parentRoomId !== '1') {
				$this->__assertRoom($this->vars['room'], $spaceId, $roomId, $parentRoomId, array());
				$this->__assertRoom(
					$this->vars['parentRooms'][0], $spaceId, $parentRoomId, null, array('5', '6')
				);
				$this->__assertRoom($this->vars['parentRooms'][1], $spaceId, $roomId, $parentRoomId, array());
			} else {
				$this->__assertRoom($this->vars['room'], $spaceId, $roomId, $parentRoomId, array('5', '6'));
				//サイト全体は含めいないように修正
				$this->assertFalse(isset($this->vars['parentRooms'][0]));
				//$this->__assertRoom($this->vars['parentRooms'][0], '1', $parentRoomId, null, array('2', '3', '4'));
			}
		}
	}

/**
 * roomのチェック
 *
 * @param array $result ルーム配列
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param int $parentRoomId 親ルームID
 * @param array $childRoom 子ルームID
 * @return void
 */
	private function __assertRoom($result, $spaceId, $roomId, $parentRoomId, $childRoom) {
		$this->assertEquals($roomId, Hash::get($result, 'Room.id'));
		$this->assertEquals($spaceId, Hash::get($result, 'Room.space_id'));
		$this->assertEquals($spaceId, Hash::get($result, 'Space.id'));
		$this->assertEquals($parentRoomId, Hash::get($result, 'ParentRoom.id'));
		$this->assertEquals($childRoom, Hash::extract($result, 'ChildRoom.{n}.id'));
		$this->assertEquals($roomId, Hash::get($result, 'RoomsLanguage.0.room_id'));
		$this->assertEquals($roomId, Hash::get($result, 'RoomsLanguage.1.room_id'));
		$this->assertNotEmpty(Hash::extract($result, 'RoomsLanguage.0.name'));
		$this->assertNotEmpty(Hash::extract($result, 'RoomsLanguage.1.name'));
	}

}
