<?php
/**
 * Room::saveActive()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Room::saveActive()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Room
 */
class RoomSaveActiveTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.room4test',
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
	protected $_methodName = 'saveActive';

/**
 * roomsRender()のテスト用DataProvider
 *
 * ### 戻り値
 *  - roomId ルームID
 *  - active アクティブ値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('roomId' => '7', 'active' => '1'),
			array('roomId' => '5', 'active' => '0'),
		);
	}

/**
 * saveActive()のテスト
 *
 * @param string $roomId ルームID
 * @param string $active アクティブ値
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveActive($roomId, $active) {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$data = array(
			'Room' => array('id' => $roomId, 'active' => $active)
		);

		//テスト前のチェック
		$expected = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $roomId),
		));
		$this->assertEquals(!(bool)$active, Hash::get($expected, 'Room.active'));
		$expected = Hash::insert($expected, 'Room.active', (bool)$active);
		$expected = Hash::remove($expected, 'Room.modified');

		//テスト実施
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertTrue($result);
		$actual = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $roomId),
		));
		$this->assertDatetime($actual['Room']['modified']);
		$actual = Hash::remove($actual, 'Room.modified');

		$this->assertEquals($expected, $actual);
	}

/**
 * saveActive()のExceptionErrorテスト
 *
 * @return void
 */
	public function testSaveActiveOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$this->_mockForReturnFalse($model, 'Rooms.Room', 'saveField');
		$this->setExpectedException('InternalErrorException');

		//データ生成
		$roomId = '7';
		$data = array(
			'Room' => array('id' => $roomId, 'active' => true)
		);

		//テスト実施
		$this->$model->$methodName($data);
	}

}
