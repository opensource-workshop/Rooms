<?php
/**
 * RoomRolePermission::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('RoomRolePermission4testFixture', 'Rooms.Test/Fixture');

/**
 * RoomRolePermission::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\RoomRolePermission
 */
class RoomRolePermissionValidateTest extends NetCommonsValidateTest {

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
		'plugin.rooms.room_role_permission4test',
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
	protected $_modelName = 'RoomRolePermission';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['RoomRolePermission'] = (new RoomRolePermission4testFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'roles_room_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'permission', 'value' => null,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'permission', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'value', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
