<?php
/**
 * RoomsHelper::roomsNavi()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * RoomsHelper::roomsNavi()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Helper\RoomsHelper
 */
class RoomsHelperRoomsNaviTest extends NetCommonsHelperTestCase {

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
		$this->Room = ClassRegistry::init('Rooms.Room');

		RoomBehavior::$spaces = null;
	}

/**
 * roomsNavi()のテスト
 *
 * @return void
 */
	public function testRoomsNavi() {
		//テストデータ生成
		$activeSpaceId = '2';
		$roomId = '5';

		$viewVars['spaces'] = $this->Room->getSpaces();
		$viewVars['parentRooms'] = $this->Room->getPath($roomId, null, 1);
		unset($viewVars['parentRooms'][0]);

		$requestData = array();

		$params = array('action' => 'index');

		//Helperロード
		$this->loadHelper('Rooms.Rooms', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->Rooms->roomsNavi($activeSpaceId);

		//チェック
		$pattern = '/.+? \/ .+?/';
		$this->assertRegExp($pattern, $result);
	}

/**
 * roomsNavi()のテスト(SpaceName)
 *
 * @return void
 */
	public function testRoomsNaviSpaceName() {
		//テストデータ生成
		$activeSpaceId = '4';

		$viewVars['spaces'] = $this->Room->getSpaces();

		$requestData = array();

		$params = array('action' => 'index');

		//Helperロード
		$this->loadHelper('Rooms.Rooms', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->Rooms->roomsNavi($activeSpaceId);

		//チェック
		$pattern = '/.+?/';
		$this->assertRegExp($pattern, $result);
	}

/**
 * roomsNavi()のテスト(ルーム追加)
 *
 * @return void
 */
	public function testRoomsNaviAddRoom() {
		//テストデータ生成
		$activeSpaceId = '4';
		$roomId = '3';

		$viewVars['spaces'] = $this->Room->getSpaces();
		$viewVars['room'] = $this->Room->findById($roomId);
		$viewVars['parentRooms'] = null;

		$requestData = array();

		$params = array('controller' => 'room_add');

		//Helperロード
		$this->loadHelper('Rooms.Rooms', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->Rooms->roomsNavi($activeSpaceId);

		//チェック
		$pattern = '/' . '.+? \/ ' . __d('rooms', 'Add new room') . '/';
		$this->assertRegExp($pattern, $result);
	}

/**
 * roomsNavi()のテスト(サブルーム追加)
 *
 * @return void
 */
	public function testRoomsNaviAddSubRoom() {
		//テストデータ生成
		$activeSpaceId = '2';
		$roomId = '5';

		$viewVars['spaces'] = $this->Room->getSpaces();
		$viewVars['room'] = $this->Room->findById($roomId);
		$viewVars['parentRooms'] = $this->Room->getPath($roomId, null, 1);
		unset($viewVars['parentRooms'][0]);

		$requestData = array();

		$params = array('controller' => 'room_add');

		//Helperロード
		$this->loadHelper('Rooms.Rooms', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->Rooms->roomsNavi($activeSpaceId);

		//チェック
		$pattern = '/' . '.+? \/ ' . __d('rooms', 'Add new subroom') . '/';
		$this->assertRegExp($pattern, $result);
	}

}
