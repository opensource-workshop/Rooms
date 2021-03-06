<?php
/**
 * RoomsComponent::setRoomsForPaginator()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsComponent::setRoomsForPaginator()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\Component\RoomsComponent
 */
class RoomsComponentSetRoomsForPaginatorTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.rooms_language4test',
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
 * setRoomsForPaginator()のテスト
 *
 * @return void
 */
	public function testSetRoomsForPaginator() {
		//テストコントローラ生成
		$this->generateNc('TestRooms.TestRoomsComponent');

		//ログイン
		TestAuthGeneral::login($this);

		//テストアクション実行
		$this->_testGetAction('/test_rooms/test_rooms_component/index',
				array('method' => 'assertNotEmpty'), null, 'view');
		$pattern = '/' . preg_quote('Controller/Component/TestRoomsComponent', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//テストデータ生成
		$spaceId = '2';

		//テスト実行
		$this->controller->Rooms->setRoomsForPaginator($spaceId);

		//チェック
		$this->assertCount(3, $this->controller->viewVars['rooms']);
		$this->__assertRoom($this->controller->viewVars['rooms'], $spaceId, '2', '1', array('5', '6'));
		$this->__assertRoom($this->controller->viewVars['rooms'], $spaceId, '5', '2', array());
		$this->__assertRoom($this->controller->viewVars['rooms'], $spaceId, '6', '2', array());

		$this->assertCount(3, $this->controller->viewVars['roomTreeList']);
		$this->assertEquals($this->controller->viewVars['roomTreeList'], array(
			'2' => '2',
			'5' => chr(9) . '5',
			'6' => chr(9) . '6',
		));
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
		$this->assertEquals($roomId, Hash::get($result, $roomId . '.Room.id'));
		$this->assertEquals($spaceId, Hash::get($result, $roomId . '.Room.space_id'));
		$this->assertEquals($spaceId, Hash::get($result, $roomId . '.Space.id'));
		$this->assertEquals($parentRoomId, Hash::get($result, $roomId . '.ParentRoom.id'));
		$this->assertEquals($childRoom, Hash::extract($result, $roomId . '.ChildRoom.{n}.id'));
		$this->assertEquals($roomId, Hash::get($result, $roomId . '.RoomsLanguage.0.room_id'));
		$this->assertEquals($roomId, Hash::get($result, $roomId . '.RoomsLanguage.1.room_id'));
		$this->assertNotEmpty(Hash::extract($result, $roomId . '.RoomsLanguage.0.name'));
		$this->assertNotEmpty(Hash::extract($result, $roomId . '.RoomsLanguage.1.name'));
	}

}
