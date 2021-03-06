<?php
/**
 * RoomsRolesFormComponent::startup()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsRolesFormComponent::startup()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\Component\RoomsRolesFormComponent
 */
class RoomsRolesFormComponentStartupTest extends NetCommonsControllerTestCase {

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

		//テストコントローラ生成
		$this->generateNc('TestRooms.TestRoomsRolesFormComponent');

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
 * startup()のテスト
 *
 * @return void
 */
	public function testStartup() {
		//テスト実行
		$this->_testGetAction('/test_rooms/test_rooms_roles_form_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('Controller/Component/TestRoomsRolesFormComponent/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTrue(in_array('Rooms.RoomsRolesForm', $this->controller->helpers));
		$this->assertEquals('DefaultRolePermission', $this->controller->RoomsRolesForm->DefaultRolePermission->alias);
	}

/**
 * requestActionのテスト
 *
 * @return void
 */
	public function testRequestAction() {
		//テスト実行
		$this->_testGetAction('/test_rooms/test_rooms_roles_form_component/index_request_action',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('Controller/Component/TestRoomsRolesFormComponent/index', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '/' . preg_quote('Controller/Component/TestRoomsRolesFormComponent/index_request_action', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

}
