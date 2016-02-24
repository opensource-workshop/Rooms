<?php
/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Room
 */
class RoomSaveTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.roles_room4test',
		'plugin.rooms.roles_rooms_user4test',
		'plugin.rooms.room4test',
		'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission4test',
		'plugin.rooms.rooms_language4test',
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
	protected $_methodName = 'save';

/**
 * Save用Data
 *
 * @param bool $count モックを通る回数
 * @return array テストデータ
 */
	private function __data($count) {
		$model = $this->_modelName;

		$this->$model = $this->getMockForModel('Rooms.Room', array(
			'saveDefaultRolesRoom', 'saveDefaultRolesRoomsUser', 'saveDefaultRolesPluginsRoom',
			'saveDefaultRoomRolePermission', 'saveDefaultPage'
		));
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRolesRoom', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRolesRoomsUser', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRolesPluginsRoom', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultRoomRolePermission', $count);
		$this->_mockForReturnTrue($model, 'Rooms.Room', 'saveDefaultPage', $count);

		$roomId = '';
		$data = array (
			'Room' => array (
				'id' => $roomId,
				'space_id' => '2',
				'root_id' => '1',
				'parent_id' => '1',
				'default_participation' => '1',
				'default_role_key' => 'visitor',
				'need_approval' => '1',
				'active' => '1',
			),
			'Page' => array ('parent_id' => '1'),
			'RoomsLanguage' => array (
				0 => array ('id' => '', 'room_id' => $roomId, 'language_id' => '1', 'name' => 'Test room'),
				1 => array ('id' => '', 'room_id' => $roomId, 'language_id' => '2', 'name' => 'Test room'),
			),
			'RoomRolePermission' => array (
				'content_publishable' => array (
					'room_administrator' => array ('id' => ''),
					'chief_editor' => array ('id' => '', 'value' => '1'),
					'editor' => array ('id' => '', 'value' => '1'),
				),
				'html_not_limited' => array (
					'room_administrator' => array ('id' => '', 'value' => '1'),
					'chief_editor' => array ('id' => '', 'value' => '1'),
					'editor' => array ('id' => '', 'value' => '1'),
					'general_user' => array ('id' => '', 'value' => '1'),
				),
			),
		);

		return $data;
	}

/**
 * Roomのチェック
 *
 * @param int $roomId ルームID
 * @return void
 */
	private function __acualRoom($roomId) {
		$model = $this->_modelName;

		$result = $this->$modle->find('first', array(
			'recursive' => -1,
			'condtions' => array('id' => $roomId),
		));

		debug($result);
	}

/**
 * save()のテスト
 *
 * @param array $data 登録データ
 * @return void
 */
	public function testSave() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テスト実施
		$data = $this->__data(1);
		$result = $this->$model->$methodName($data);

		//チェック
		//TODO:Assertを書く
		$this->__acualRoom('9');
	}

/**
 * save()のテスト(Roomのみ指定)
 *
 * @return void
 */
	public function testSaveOnlyRoom() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$this->_mockForReturnTrue($model, 'Rooms.RoomsLanguage', 'save', 0);
		$this->_mockForReturnTrue($model, 'Rooms.RoomRolePermission', 'saveMany', 0);

		//テスト実施
		$data = $this->__data(1);
		$result = $this->$model->$methodName(array('Room' => $data[$this->$model->alias]));

		//チェック
		$this->__acualRoom('9');
	}

/**
 * save()のExceptionErrorテスト(RoomsLanguage)
 *
 * @return void
 */
	public function testSaveRoomsLanguageOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$data = $this->__data(0);
		$this->_mockForReturnFalse($model, 'Rooms.RoomsLanguage', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->$model->$methodName($data);
	}

/**
 * save()のExceptionErrorテスト(RoomRolePermission)
 *
 * @return void
 */
	public function testSaveRoomRolePermissionOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		$data = $this->__data(1);
		$this->_mockForReturnFalse($model, 'Rooms.RoomRolePermission', 'saveMany');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->$model->$methodName($data);
	}

}
