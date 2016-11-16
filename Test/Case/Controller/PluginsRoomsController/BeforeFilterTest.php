<?php
/**
 * PluginsRoomsController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsControllerTestCase', 'Rooms.TestSuite');

/**
 * PluginsRoomsController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\PluginsRoomsController
 */
class PluginsRoomsControllerBeforeFilterTest extends RoomsControllerTestCase {

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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'plugins_rooms';

/**
 * index()アクションのテスト
 *
 * @return void
 */
	public function testBeforeFilter() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', '2', '2'), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertEquals($this->vars['activeRoomId'], '2');
		$this->assertEquals($this->vars['activeRoomId'], $this->controller->PluginsForm->roomId);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
