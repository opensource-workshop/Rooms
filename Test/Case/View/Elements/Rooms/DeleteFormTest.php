<?php
/**
 * View/Elements/Rooms/delete_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Rooms/delete_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Elements\Rooms\DeleteForm
 */
class RoomsViewElementsRoomsDeleteFormTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestRooms.TestViewElementsRoomsDeleteForm');
	}

/**
 * View/Elements/Rooms/delete_formのテスト
 *
 * @return void
 */
	public function testDeleteForm() {
		//テスト実行
		$this->_testGetAction('/test_rooms/test_view_elements_rooms_delete_form/delete_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Rooms/delete_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('form', null, 'rooms/rooms/delete/2/7', $this->view);
		$this->assertInput('input', '_method', 'DELETE', $this->view);
		$this->assertInput('input', 'data[Room][id]', '7', $this->view);
		$this->assertInput('button', 'delete', null, $this->view);
	}

}
