<?php
/**
 * RolesRoomsUser::saveRolesRoomsUsersForRooms()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('RolesRoomsUserFixture', 'Rooms.Test/Fixture');

/**
 * RolesRoomsUser::saveRolesRoomsUsersForRooms()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\RolesRoomsUser
 */
class RolesRoomsUserSaveRolesRoomsUsersForRoomsTest extends NetCommonsSaveTest {

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
	protected $_methodName = 'saveRolesRoomsUsersForRooms';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data = array();
		$data['RolesRoomsUser'][0] = (new RolesRoomsUserFixture())->records[1];
		$data['RolesRoomsUser'][1] = (new RolesRoomsUserFixture())->records[2];
		$data = Hash::insert($data, 'RolesRoomsUser.{n}.room_id', '99');

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.RolesRoomsUser.{n}.id', null);

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
		$method = $this->_methodName;

		//チェック用データ取得
		if (Hash::get($data, $this->$model->alias . '.0.id')) {
			$ids = Hash::extract($data[$this->$model->alias], '{n}.id');
			$result = $this->$model->find('all', array(
				'recursive' => -1,
				'conditions' => array('id' => $ids),
			));
			$before[$this->$model->alias] = Hash::extract($result, '{n}.' . $this->$model->alias);
			$before[$this->$model->alias] = Hash::remove($before[$this->$model->alias], '{n}.modified');
			$before[$this->$model->alias] = Hash::remove($before[$this->$model->alias], '{n}.modified_user');
		}

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertTrue($result);

		//登録データ取得
		$result = $this->$model->find('all', array(
			'recursive' => -1,
			'conditions' => array('room_id' => '99'),
		));
		$actual[$this->$model->alias] = Hash::extract($result, '{n}.' . $this->$model->alias);

		if (Hash::get($data, $this->$model->alias . '.0.id')) {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], '{n}.modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], '{n}.modified_user');
			$expected[$this->$model->alias] = Hash::merge(
				$before[$this->$model->alias], $data[$this->$model->alias]
			);
		} else {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], '{n}.created');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], '{n}.created_user');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], '{n}.modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], '{n}.modified_user');

			$expected[$this->$model->alias] = $data[$this->$model->alias];
			$expected = Hash::insert($expected, $this->$model->alias . '.0.id', '12');
			$expected = Hash::insert($expected, $this->$model->alias . '.1.id', '13');
		}

		$this->assertEquals($expected, $actual);
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
		$data = array();
		$data['RolesRoomsUser'][0] = (new RolesRoomsUserFixture())->records[1];
		$data['RolesRoomsUser'][1] = (new RolesRoomsUserFixture())->records[2];

		return array(
			array($data, 'Rooms.RolesRoomsUser', 'save'),
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
		$data = array();
		$data['RolesRoomsUser'][0] = (new RolesRoomsUserFixture())->records[1];
		$data['RolesRoomsUser'][1] = (new RolesRoomsUserFixture())->records[2];

		return array(
			array($data, 'Rooms.RolesRoomsUser', 'validates'),
		);
	}

/**
 * SaveのValidationErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderSaveOnValidationError
 * @return void
 */
	public function testSaveOnValidationError($data, $mockModel, $mockMethod = 'validates') {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$this->_mockForReturnFalse($model, $mockModel, $mockMethod);

		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data);
	}

}
