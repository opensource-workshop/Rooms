<?php
/**
 * DeleteRoomAssociationsBehavior::queryDeleteAll()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * DeleteRoomAssociationsBehavior::queryDeleteAll()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Behavior\DeleteRoomAssociationsBehavior
 */
class DeleteRoomAssociationsBehaviorQueryDeleteAllTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.delete_test_block_id',
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
	}

/**
 * queryDeleteAll()テストのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value 値
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['field'] = 'block_id';
		$result[0]['value'] = array();

		$result[1] = array();
		$result[1]['field'] = 'block_id';
		$result[1]['value'] = array('4', '5', '6');

		$result[2] = array();
		$result[2]['field'] = 'block_id';
		$result[2]['value'] = '4';

		return $result;
	}

/**
 * queryDeleteAll()のテスト
 *
 * @param int $field フィールド名
 * @param mixed $value 値
 * @dataProvider dataProvider
 * @return void
 */
	public function testQueryDeleteAll($field, $value) {
		//テスト実施
		$result = $this->TestModel->queryDeleteAll($field, $value);
		$this->assertTrue($result);
	}

}
