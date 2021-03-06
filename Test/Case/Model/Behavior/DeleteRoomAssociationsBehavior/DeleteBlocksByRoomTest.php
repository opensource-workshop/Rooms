<?php
/**
 * DeleteRoomAssociationsBehavior::deleteBlocksByRoom()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * DeleteRoomAssociationsBehavior::deleteBlocksByRoom()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Behavior\DeleteRoomAssociationsBehavior
 */
class DeleteRoomAssociationsBehaviorDeleteBlocksByRoomTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.block4delete',
		'plugin.rooms.blocks_language4delete',
		'plugin.rooms.delete_test_block_id',
		'plugin.rooms.delete_test_block_key',
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
		$this->TestModel->DeleteTestBlockId = ClassRegistry::init('TestRooms.DeleteTestBlockId');
		$this->TestModel->DeleteTestBlockKey = ClassRegistry::init('TestRooms.DeleteTestBlockKey');
	}

/**
 * deleteBlocksByRoom()テストのDataProvider
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
 * deleteBlocksByRoom()のテスト
 *
 * @param int $roomId ルームID
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteBlocksByRoom($roomId) {
		//事前チェック
		$this->__assertTable('DeleteTestBlockId', 3, array('id', 'block_id'));
		$this->__assertTable('DeleteTestBlockKey', 3, array('id', 'block_key'));

		//テスト実施
		$result = $this->TestModel->deleteBlocksByRoom($roomId);
		$this->assertTrue($result);

		//チェック
			$this->__assertTable('DeleteTestBlockId', 1, array('id', 'block_id'), array(
			array('DeleteTestBlockId' => array('id' => '2', 'block_id' => '2')),
		));
		$this->__assertTable('DeleteTestBlockKey', 1, array('id', 'block_key'), array(
			array('DeleteTestBlockKey' => array('id' => '1', 'block_key' => 'block_1')),
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
