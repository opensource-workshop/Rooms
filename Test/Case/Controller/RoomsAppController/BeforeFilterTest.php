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

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('UserRole', 'UserRoles.Model');

/**
 * RoomsAppController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\RoomsAppController
 */
class RoomsAppControllerBeforeFilterTest extends NetCommonsControllerTestCase {

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
 * index及びview用DataProvider
 *
 * ### 戻り値
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
		if ($exception) {
			$this->setExpectedException($exception);
		}
		$this->_testNcAction('/test_rooms/test_rooms_app_controller_index/index/' . $spaceId, array(
			'method' => 'get'
		));

		//チェック
		if ($exception) {
			//何もしない
		} elseif ($login) {
			$header = $this->controller->response->header();
			debub($header['Location']);
			//$pattern = '/' . preg_quote('/user_attributes/user_attributes/index', '/') . '/';
			//$this->assertRegExp($pattern, $header['Location']);
		} else {
			$pattern = '/' . preg_quote('Controller/TestRoomsAppController/index', '/') . '/';
			$this->assertRegExp($pattern, $this->view);
		}
	}

/**
 * ログインありのview()のテスト
 *
 * @return void
 */
	public function testView() {
		//ログイン
		TestAuthGeneral::login($this);

		//TODO:テストデータ

		//テスト実行
		$this->_testNcAction('/test_rooms/test_rooms_app_controller_index/index/2', array(
			'method' => 'get'
		));

		//チェック
		//TODO:assert追加
		debug($this->view);
	}

}
