<?php
/**
 * Space::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('SpaceFixture', 'Rooms.Test/Fixture');

/**
 * Space::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Model\Space
 */
class SpaceValidateTest extends NetCommonsValidateTest {

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
	protected $_modelName = 'Space';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'validate';

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
		$data['Space'] = (new SpaceFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'parent_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'lft', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'rght', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			//array('data' => $data, 'field' => 'type', 'value' => null,
			//	'message' => __d('net_commons', 'Invalid request.')),
			//array('data' => $data, 'field' => 'type', 'value' => 'a',
			//	'message' => __d('net_commons', 'Invalid request.')),
			//array('data' => $data, 'field' => 'type', 'value' => '99',
			//	'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
