<?php
/**
 * Room::saveTheme()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Room::saveTheme()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Room
 */
class RoomSaveThemeTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'saveTheme';

/**
 * saveTheme()のテスト
 *
 * @return void
 */
	public function testSaveTheme() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$roomId = '4';
		$theme = 'Test';
		$data = array(
			'Room' => array('id' => $roomId, 'theme' => $theme)
		);

		//テスト前のチェック
		$expected = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $roomId),
		));
		$this->assertNull(Hash::get($expected, 'Room.theme'));
		$expected = Hash::insert($expected, 'Room.theme', $theme);
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
 * saveTheme()のExceptionErrorテスト
 *
 * @return void
 */
	public function testSaveActiveOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$this->_mockForReturnFalse($model, 'Rooms.Room', 'saveField');
		$this->setExpectedException('InternalErrorException');

		//データ生成
		$roomId = '4';
		$theme = 'Test';
		$data = array(
			'Room' => array('id' => $roomId, 'theme' => $theme)
		);

		//テスト実施
		$this->$model->$methodName($data);
	}

}
