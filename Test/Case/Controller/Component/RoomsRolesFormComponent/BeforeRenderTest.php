<?php
/**
 * RoomsRolesFormComponent::beforeRender()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsRolesFormComponent::beforeRender()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\Component\RoomsRolesFormComponent
 */
class RoomsRolesFormComponentBeforeRenderTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.room_role_permission4test',
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
 * beforeRender()のテスト
 *
 * @return void
 */
	public function testBeforeRender() {
		//テストコントローラ生成
		$this->generateNc('TestRooms.TestRoomsRolesFormComponent');

		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_rooms/test_rooms_roles_form_component/index_before_render',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('Controller/Component/TestRoomsRolesFormComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->__assertBeforeRender();
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
		$pattern = '/' . preg_quote('Controller/Component/TestRoomsRolesFormComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '/' . preg_quote('Controller/Component/TestRoomsRolesFormComponent/index_request_action', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

/**
 * beforeRender()のassert
 *
 * @return void
 */
	private function __assertBeforeRender() {
		$roles = array(
			'room_administrator', 'chief_editor', 'editor', 'general_user', 'visitor'
		);
		// * $this->viewVars['roles']のチェック
		$this->assertEquals(
			$roles, array_keys($this->vars['roles'])
		);
		$this->assertEquals(
			array('1', '2', '3', '4', '5'), Hash::extract($this->vars['roles'], '{s}.id')
		);
		$this->assertEquals(
			$roles, Hash::extract($this->vars['roles'], '{s}.role_key')
		);
		// * $this->request->data['RoomRolePermission']のチェック
		$result = $this->controller->request->data;
		$this->assertEquals(
			$roles, array_keys($result['RoomRolePermission']['content_publishable'])
		);
		$this->assertEquals(
			array('7', '18', '29', '40', '51'), Hash::extract($result, 'RoomRolePermission.content_publishable.{s}.id')
		);
		$this->assertEquals(
			array('1', '2', '3', '4', '5'), Hash::extract($result, 'RoomRolePermission.content_publishable.{s}.roles_room_id')
		);
	}

}
