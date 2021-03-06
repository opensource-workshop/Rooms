<?php
/**
 * RolesRoomsUser::saveAccessed()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * RolesRoomsUser::saveAccessed()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\RolesRoomsUser
 */
class RolesRoomsUserSaveAccessedTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_rooms_user4test',
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
	protected $_methodName = 'saveAccessed';

/**
 * saveAccessed()のテスト
 *
 * @return void
 */
	public function testSaveAccessed() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$checked = array('id', 'access_count', 'last_accessed', 'previous_accessed');

		//データ生成
		$roleRoomUserId = '6';

		//実施前のチェック
		$expected = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => $checked,
			'conditions' => array('id' => $roleRoomUserId)
		));
		$expected[$this->$model->alias]['access_count'] = '1';
		$expected[$this->$model->alias]['previous_accessed'] = $expected[$this->$model->alias]['last_accessed'];
		$expected[$this->$model->alias]['last_accessed'] = date('Y-m-d H');

		//テスト実施
		$result = $this->$model->$methodName($roleRoomUserId);
		$this->assertTrue($result);

		//チェック
		$actual = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => $checked,
			'conditions' => array('id' => $roleRoomUserId)
		));
		$this->assertDatetime($actual[$this->$model->alias]['last_accessed']);
		$actual[$this->$model->alias]['last_accessed'] = substr($actual[$this->$model->alias]['last_accessed'], 0, -6);

		$this->assertEqual($expected, $actual);
	}

/**
 * saveAccessed()のExceptionErrorテスト
 * 但し、throwにはならない
 *
 * @return void
 */
	public function testSaveAccesseOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$checked = array('id', 'access_count', 'last_accessed', 'previous_accessed');

		//データ生成
		$this->_mockForReturnFalse($model, 'Rooms.RolesRoomsUser', 'updateAll');
		$roleRoomUserId = '6';

		//実施前のチェック
		$expected = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => $checked,
			'conditions' => array('id' => $roleRoomUserId)
		));

		//テスト実施
		$result = $this->$model->$methodName($roleRoomUserId);
		$this->assertTrue($result);

		//チェック
		$actual = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => $checked,
			'conditions' => array('id' => $roleRoomUserId)
		));

		$this->assertEqual($expected, $actual);
	}

}
