<?php
/**
 * RoomsRolesUsersController::search_conditions()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * RoomsRolesUsersController::search_conditions()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\Controller\RoomsRolesUsersController
 */
class RoomsRolesUsersControllerSearchConditionsTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.groups.group',
		'plugin.rooms.roles_room4test',
		'plugin.rooms.roles_rooms_user4test',
		'plugin.rooms.room4test',
		'plugin.rooms.room_role',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.rooms_language4test',
		'plugin.rooms.space',
		'plugin.user_attributes.user_attribute4edit',
		'plugin.user_attributes.user_attribute_choice4edit',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting4edit',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'rooms';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'rooms_roles_users';

/**
 * search_conditions()アクションのテスト
 *
 * @return void
 */
	public function testSearchConditions() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction(array('action' => 'search_conditions', '2', '5'), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertInput('form', null, '/rooms/rooms_roles_users/search_conditions/2/5', $this->view);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
