<?php
/**
 * SaveRoomAssociationsBehavior::saveDefaultRoomRolePermission()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * SaveRoomAssociationsBehavior::saveDefaultRoomRolePermission()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Behavior\SaveRoomAssociationsBehavior
 */
class SaveRoomAssociationsBehaviorSaveDefaultRoomRolePermissionTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.roles.default_role_permission4test',
		'plugin.rooms.roles_room4test',
		'plugin.rooms.room_role_permission4test',
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
 * saveDefaultRoomRolePermission()テストのDataProvider
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
 * saveDefaultRoomRolePermission()のテスト
 *
 * @param array $data Room data
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveDefaultRoomRolePermission($data) {
		//テストデータ作成
		Current::$current = Hash::insert(Current::$current, 'User.id', '2');
		Current::$current = Hash::insert(Current::$current, 'Language.id', '2');
		$roomId = $data['Room']['id'];

		//事前データ作成
		$result = $this->TestModel->saveDefaultRolesRoom($data);
		$this->assertTrue($result);
		$this->__acualRolesRoom($roomId);

		//テスト実施
		$result = $this->TestModel->saveDefaultRoomRolePermission($data);
		$this->assertTrue($result);

		//チェック
		$this->__acualRoomRolePermission('21', array(
			array('RoomRolePermission' => array('id' => '83', 'permission' => 'page_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '84', 'permission' => 'block_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '85', 'permission' => 'content_readable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '86', 'permission' => 'content_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '87', 'permission' => 'content_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '88', 'permission' => 'content_publishable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '89', 'permission' => 'content_comment_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '90', 'permission' => 'content_comment_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '91', 'permission' => 'content_comment_publishable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '92', 'permission' => 'block_permission_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '93', 'permission' => 'html_not_limited', 'value' => false)),
			array('RoomRolePermission' => array('id' => '94', 'permission' => 'mail_content_receivable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '95', 'permission' => 'mail_answer_receivable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '96', 'permission' => 'mail_editable', 'value' => true)),
		));
		$this->__acualRoomRolePermission('22', array(
			array('RoomRolePermission' => array('id' => '97', 'permission' => 'page_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '98', 'permission' => 'block_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '99', 'permission' => 'content_readable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '100', 'permission' => 'content_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '101', 'permission' => 'content_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '102', 'permission' => 'content_publishable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '103', 'permission' => 'content_comment_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '104', 'permission' => 'content_comment_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '105', 'permission' => 'content_comment_publishable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '106', 'permission' => 'block_permission_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '107', 'permission' => 'html_not_limited', 'value' => false)),
			array('RoomRolePermission' => array('id' => '108', 'permission' => 'mail_content_receivable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '109', 'permission' => 'mail_answer_receivable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '110', 'permission' => 'mail_editable', 'value' => true)),
		));
		$this->__acualRoomRolePermission('23', array(
			array('RoomRolePermission' => array('id' => '111', 'permission' => 'page_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '112', 'permission' => 'block_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '113', 'permission' => 'content_readable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '114', 'permission' => 'content_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '115', 'permission' => 'content_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '116', 'permission' => 'content_publishable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '117', 'permission' => 'content_comment_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '118', 'permission' => 'content_comment_editable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '119', 'permission' => 'content_comment_publishable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '120', 'permission' => 'block_permission_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '121', 'permission' => 'html_not_limited', 'value' => false)),
			array('RoomRolePermission' => array('id' => '122', 'permission' => 'mail_content_receivable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '123', 'permission' => 'mail_answer_receivable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '124', 'permission' => 'mail_editable', 'value' => false)),
		));
		$this->__acualRoomRolePermission('24', array(
			array('RoomRolePermission' => array('id' => '125', 'permission' => 'page_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '126', 'permission' => 'block_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '127', 'permission' => 'content_readable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '128', 'permission' => 'content_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '129', 'permission' => 'content_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '130', 'permission' => 'content_publishable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '131', 'permission' => 'content_comment_creatable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '132', 'permission' => 'content_comment_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '133', 'permission' => 'content_comment_publishable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '134', 'permission' => 'block_permission_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '135', 'permission' => 'html_not_limited', 'value' => false)),
			array('RoomRolePermission' => array('id' => '136', 'permission' => 'mail_content_receivable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '137', 'permission' => 'mail_answer_receivable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '138', 'permission' => 'mail_editable', 'value' => false)),
		));
		$this->__acualRoomRolePermission('25', array(
			array('RoomRolePermission' => array('id' => '139', 'permission' => 'page_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '140', 'permission' => 'block_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '141', 'permission' => 'content_readable', 'value' => true)),
			array('RoomRolePermission' => array('id' => '142', 'permission' => 'content_creatable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '143', 'permission' => 'content_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '144', 'permission' => 'content_publishable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '145', 'permission' => 'content_comment_creatable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '146', 'permission' => 'content_comment_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '147', 'permission' => 'content_comment_publishable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '148', 'permission' => 'block_permission_editable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '149', 'permission' => 'html_not_limited', 'value' => false)),
			array('RoomRolePermission' => array('id' => '150', 'permission' => 'mail_content_receivable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '151', 'permission' => 'mail_answer_receivable', 'value' => false)),
			array('RoomRolePermission' => array('id' => '152', 'permission' => 'mail_editable', 'value' => false)),
		));
	}

/**
 * saveDefaultRoomRolePermission()のExceptionErrorテスト
 *
 * @param array $data Room data
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveDefaultRolesRoomOnExceptionError($data) {
		//テストデータ作成
		Current::$current = Hash::insert(Current::$current, 'User.id', '2');
		Current::$current = Hash::insert(Current::$current, 'Language.id', '2');
		$roomId = $data['Room']['id'];

		//事前データ作成
		$result = $this->TestModel->saveDefaultRolesRoom($data);
		$this->assertTrue($result);
		$this->__acualRolesRoom($roomId);

		//テスト実施
		$this->_mockForReturn('TestModel', 'Rooms.RoomRolePermission', 'getAffectedRows', 0);
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->saveDefaultRoomRolePermission($data);
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

/**
 * RoomRolePermissionのチェック
 *
 * @param int $rolesRoomId ロールルームID
 * @param array $expected 期待値
 * @return void
 */
	private function __acualRoomRolePermission($rolesRoomId, $expected) {
		$expected = Hash::insert($expected, '{n}.{s}.roles_room_id', $rolesRoomId);

		$result = $this->TestModel->RoomRolePermission->find('all', array(
			'recursive' => -1,
			'fields' => array_keys($expected[0]['RoomRolePermission']),
			'conditions' => array('roles_room_id' => $rolesRoomId),
		));

		$this->assertEquals($expected, $result);
	}
}
