<?php
/**
 * RolesRoomsUser::deleteRolesRoomsUsers()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsDeleteTest', 'NetCommons.TestSuite');
App::uses('RolesRoomsUserFixture', 'Rooms.Test/Fixture');

/**
 * RolesRoomsUser::deleteRolesRoomsUsers()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\RolesRoomsUser
 */
class RolesRoomsUserDeleteRolesRoomsUsersTest extends NetCommonsDeleteTest {

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
	protected $_modelName = 'RolesRoomsUser';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'deleteRolesRoomsUsers';

/**
 * Delete用DataProvider
 *
 * ### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return array テストデータ
 */
	public function dataProviderDelete() {
		$data = array();
		$data['RolesRoomsUser'][0] = (new RolesRoomsUserFixture())->records[1];
		$data['RolesRoomsUser'][1] = (new RolesRoomsUserFixture())->records[2];
		$association = array();

		$results = array();
		$results[0] = array($data, $association);

		return $results;
	}

/**
 * Deleteのテスト
 *
 * @param array|string $data 削除データ
 * @param array $associationModels 削除確認の関連モデル array(model => conditions)
 * @dataProvider dataProviderDelete
 * @return void
 */
	public function testDelete($data, $associationModels = null) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$ids = Hash::extract($data['RolesRoomsUser'], '{n}.id');
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('id' => $ids),
		));
		$this->assertNotEquals(0, $count);

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);

		//チェック
		$count = $this->$model->find('count', array(
			'recursive' => -1,
			'conditions' => array('id' => $ids),
		));
		$this->assertEquals(0, $count);
	}

/**
 * ExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderDeleteOnExceptionError() {
		$data = array();
		$data['RolesRoomsUser'][0] = (new RolesRoomsUserFixture())->records[1];
		$data['RolesRoomsUser'][1] = (new RolesRoomsUserFixture())->records[2];

		return array(
			array($data, 'Rooms.RolesRoomsUser', 'deleteAll'),
		);
	}

}