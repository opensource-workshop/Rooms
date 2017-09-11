<?php
/**
 * RoomAddController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsControllerTestCase', 'Rooms.TestSuite');

/**
 * RoomAddController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\RoomAddController
 */
class RoomAddControllerBeforeFilterTest extends RoomsControllerTestCase {

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
	protected $_controller = 'room_add';

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
 * beforeFilter()のbasicアクションテスト
 *
 * @return void
 */
	public function testBasic() {
		//テスト実行
		$this->_testGetAction(
			array('action' => 'basic', '2', '2'),
			array('method' => 'assertNotEmpty'), null, 'view'
		);

		//チェック
		$this->__assertHelpers();
	}

/**
 * beforeFilter()のbasicアクションテスト
 *
 * @return void
 */
	public function testNotBasic() {
		$this->generateNc(Inflector::camelize($this->_controller), array(
			'components' => array('Session' => array('read'))
		));

		//ログイン
		TestAuthGeneral::login($this);

		$this->controller->Session
			->expects($this->at(0))->method('read')
			->with('RoomAdd.Room.id')
			->will($this->returnValue(null));

		$this->controller->Session
			->expects($this->at(1))->method('read')
			->with('RoomAdd.Room.id')
			->will($this->returnValue(null));

		$this->controller->Session
			->expects($this->at(2))->method('read')
			->with('RoomAdd.Room.id')
			->will($this->returnValue(null));

		//テスト実行
		$this->_testGetAction(
			array('action' => 'rooms_roles_users', '2', '2'),
			null, null, 'view'
		);

		//チェック
		$header = $this->controller->response->header();
		$this->assertTextContains('/rooms/rooms/index/2', $header['Location']);
	}

/**
 * beforeFilter()のテスト
 *
 * @return void
 */
	private function __assertHelpers() {
		$expected = array(
			'navibar' => array(
				'rooms' => array(
					'url' => array(
						'controller' => 'room_add',
						'action' => 'basic',
						'key' => '2',
						'key2' => '2',
					),
					'label' => array(
						0 => 'rooms',
						1 => 'General setting',
					),
				),
				'rooms_roles_users' => array(
					'url' => array(
						'controller' => 'room_add',
						'action' => 'rooms_roles_users',
						'key' => '2',
						'key2' => '2',
					),
					'label' => array(
						0 => 'rooms',
						1 => 'Edit the members to join',
					),
				),
				'plugins_rooms' => array(
					'url' => array(
						'controller' => 'room_add',
						'action' => 'plugins_rooms',
						'key' => '2',
						'key2' => '2',
					),
					'label' => array(
						0 => 'rooms',
						1 => 'Select the plugins to join',
					),
				),
			),
			'cancelUrl' => array(
				'controller' => 'room_add',
				'action' => 'cancel',
				'key' => '2',
				'key2' => '2',
			),
		);
		$this->assertEquals($expected, $this->controller->helpers['NetCommons.Wizard']);
	}

}
