<?php
/**
 * SaveRoomAssociationsBehavior::saveDefaultRolesPluginsRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * SaveRoomAssociationsBehavior::saveDefaultRolesPluginsRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Behavior\SaveRoomAssociationsBehavior
 */
class SaveRoomAssociationsBehaviorSaveDefaultRolesPluginsRoomTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.plugins_role4test',
		'plugin.rooms.plugin4test',
		'plugin.rooms.plugins_room4test',
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
		$this->TestModel = ClassRegistry::init('TestRooms.TestSaveRoomAssociationsBehaviorModel');
	}

/**
 * saveDefaultRolesPluginsRoom()テストのDataProvider
 *
 * ### 戻り値
 *  - data Room data
 *
 * @return array データ
 */
	public function dataProvider() {
		return array(
			array('data' => array('Room' => array('id' => '99', 'space_id' => '2', 'parent_id' => '2')))
		);
	}

/**
 * saveDefaultRolesPluginsRoom()のテスト
 *
 * @param array $data Room data
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveDefaultRolesPluginsRoom($data) {
		//テストデータ作成
		Current::$current = Hash::insert(Current::$current, 'User.id', '1');
		Current::$current = Hash::insert(Current::$current, 'Language.id', '2');
		$roomId = $data['Room']['id'];

		//テスト実施
		$result = $this->TestModel->saveDefaultRolesPluginsRoom($data);
		$this->assertTrue($result);

		//チェック
		$this->__acualPluginsRoom($roomId);
	}

/**
 * saveDefaultRolesPluginsRoom()のExceptionErrorテスト
 *
 * @param array $data Room data
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveDefaultRolesPluginsRoomOnExceptionError($data) {
		$this->_mockForReturn('TestModel', 'PluginManager.PluginsRoom', 'getAffectedRows', 0);

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->saveDefaultRolesPluginsRoom($data);
	}

/**
 * PluginsRoomのチェック
 *
 * @param int $roomId ルームID
 * @return void
 */
	private function __acualPluginsRoom($roomId) {
		$expected = array(
			array('PluginsRoom' => array('id' => '8', 'room_id' => $roomId, 'plugin_key' => 'test')),
			array('PluginsRoom' => array('id' => '9', 'room_id' => $roomId, 'plugin_key' => 'test2')),
		);

		$result = $this->TestModel->PluginsRoom->find('all', array(
			'recursive' => -1,
			'fields' => array_keys($expected[0]['PluginsRoom']),
			'conditions' => array('room_id' => $roomId),
		));
		$this->assertEquals($expected, $result);
	}

}
