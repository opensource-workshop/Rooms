<?php
/**
 * Room::saveRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('RoomFixture', 'Rooms.Test/Fixture');

/**
 * Room::saveRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Room
 */
class RoomSaveRoomTest extends NetCommonsSaveTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.room',
		'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.rooms_language',
		'plugin.rooms.space',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'rooms';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'Room';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'saveRoom';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['Room'] = (new RoomFixture())->records[1];

		//TODO:テストパタンを書く
		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.Room.id', null);
		$results[1] = Hash::insert($results[1], '0.Room.lft', '6');
		$results[1] = Hash::insert($results[1], '0.Room.rght', '7');
		$results[1] = Hash::remove($results[1], '0.Room.created_user');

		return $results;
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;

		if ($data['Room']['id']) {
			$count = 0;
		} else {
			$count = 1;
		}

		$this->$model = $this->getMockForModel('Rooms.Room', array(
			'saveDefaultRolesRoom', 'saveDefaultRolesRoomsUser', 'saveDefaultRolesPluginsRoom',
			'saveDefaultRoomRolePermission', 'saveDefaultPage'
		));
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRolesRoom', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRolesRoomsUser', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRolesPluginsRoom', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRoomRolePermission', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultPage', $count);

		parent::testSave($data);
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data['Room'] = (new RoomFixture())->records[0];

		return array(
			array($data, 'Rooms.Room', 'save'),
		);
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnValidationError() {
		$data['Room'] = (new RoomFixture())->records[0];

		//TODO:テストパタンを書く
		return array(
			array($data, 'Rooms.Room'),
		);
	}

}
