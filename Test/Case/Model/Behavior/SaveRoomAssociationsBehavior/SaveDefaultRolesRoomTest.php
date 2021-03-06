<?php
/**
 * SaveRoomAssociationsBehavior::saveDefaultRolesRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * SaveRoomAssociationsBehavior::saveDefaultRolesRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Behavior\SaveRoomAssociationsBehavior
 */
class SaveRoomAssociationsBehaviorSaveDefaultRolesRoomTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_room4test',
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
 * saveDefaultRolesRoom()テストのDataProvider
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
 * saveDefaultRolesRoom()のテスト
 *
 * @param array $data Room data
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveDefaultRolesRoom($data) {
		//テストデータ作成
		Current::$current = Hash::insert(Current::$current, 'User.id', '1');
		Current::$current = Hash::insert(Current::$current, 'Language.id', '2');
		$roomId = $data['Room']['id'];

		//テスト実施
		$result = $this->TestModel->saveDefaultRolesRoom($data);
		$this->assertTrue($result);

		//チェック
		$this->__acualRolesRoom($roomId);
	}

/**
 * saveDefaultRolesRoom()のExceptionErrorテスト
 *
 * @param array $data Room data
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveDefaultRolesRoomOnExceptionError($data) {
		$this->_mockForReturn('TestModel', 'Rooms.RolesRoom', 'getAffectedRows', 0);

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->saveDefaultRolesRoom($data);
	}

/**
 * RolesRoomのチェック
 *
 * @param int $roomId ルームID
 * @return void
 */
	private function __acualRolesRoom($roomId) {
		$expected = array(
			array('RolesRoom' => array('id' => '21', 'room_id' => $roomId, 'role_key' => 'room_administrator')),
			array('RolesRoom' => array('id' => '22', 'room_id' => $roomId, 'role_key' => 'chief_editor')),
			array('RolesRoom' => array('id' => '23', 'room_id' => $roomId, 'role_key' => 'editor')),
			array('RolesRoom' => array('id' => '24', 'room_id' => $roomId, 'role_key' => 'general_user')),
			array('RolesRoom' => array('id' => '25', 'room_id' => $roomId, 'role_key' => 'visitor')),
		);

		$result = $this->TestModel->RolesRoom->find('all', array(
			'recursive' => -1,
			'fields' => array_keys($expected[0]['RolesRoom']),
			'conditions' => array('room_id' => $roomId),
		));

		$this->assertEquals($expected, $result);
	}

}
