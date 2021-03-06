<?php
/**
 * DeleteRoomAssociationsBehavior::deleteFramesByRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * DeleteRoomAssociationsBehavior::deleteFramesByRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Behavior\DeleteRoomAssociationsBehavior
 */
class DeleteRoomAssociationsBehaviorDeleteFramesByRoomTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.frame4delete',
		'plugin.rooms.frame_public_language4delete',
		'plugin.rooms.frames_language4delete',
		'plugin.rooms.delete_test_frame_id',
		'plugin.rooms.delete_test_frame_key',
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
		$this->TestModel = ClassRegistry::init('TestRooms.TestDeleteRoomAssociationsBehaviorModel');
		$this->TestModel->DeleteTestFrameId = ClassRegistry::init('TestRooms.DeleteTestFrameId');
		$this->TestModel->DeleteTestFrameKey = ClassRegistry::init('TestRooms.DeleteTestFrameKey');
	}

/**
 * deleteFramesByRoom()テストのDataProvider
 *
 * ### 戻り値
 *  - roomId ルームID
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['roomId'] = '5';

		return $result;
	}

/**
 * deleteFramesByRoom()のテスト
 *
 * @param int $roomId ルームID
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteFramesByRoom($roomId) {
		//事前チェック
		$this->__assertTable('DeleteTestFrameId', 3, array('id', 'frame_id'));
		$this->__assertTable('DeleteTestFrameKey', 3, array('id', 'frame_key'));

		//テスト実施
		$result = $this->TestModel->deleteFramesByRoom($roomId);
		$this->assertTrue($result);

		//チェック
		$this->__assertTable('DeleteTestFrameId', 1, array('id', 'frame_id'), array(
			array('DeleteTestFrameId' => array('id' => '2', 'frame_id' => '2')),
		));
		$this->__assertTable('DeleteTestFrameKey', 1, array('id', 'frame_key'), array(
			array('DeleteTestFrameKey' => array('id' => '1', 'frame_key' => 'frame_1')),
		));
	}

/**
 * テーブルのチェック
 *
 * @param string $model Model名
 * @param int $count データ件数
 * @param array $fields フィールド名
 * @param array $expected 期待値
 * @return void
 */
	private function __assertTable($model, $count, $fields, $expected = null) {
		$result = $this->TestModel->$model->find('all', array(
			'recursive' => -1,
			'fields' => $fields,
		));
		$this->assertCount($count, $result);

		if (isset($expected)) {
			$this->assertEquals($expected, $result);
		}
	}

}
