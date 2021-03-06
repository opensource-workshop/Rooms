<?php
/**
 * RoomsHelper::roomAccessed()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('RolesRoomsUser4testFixture', 'Rooms.Test/Fixture');

/**
 * RoomsHelper::roomAccessed()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Helper\RoomsHelper
 */
class RoomsHelperRoomAccessedTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.site_manager.site_setting',
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

		//テストデータ生成
		$viewVars = array();
		$requestData = array();

		//Helperロード
		$this->loadHelper('Rooms.Rooms', $viewVars, $requestData);
	}

/**
 * roomAccessed()のテスト用DataProvider
 *
 * ### 戻り値
 *  - rolesRoomsUser RolesRoomsUserデータ
 *  - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('rolesRoomsUser' => (new RolesRoomsUser4testFixture())->records[5], 'last_accessed', '2015/06/17'),
			array('rolesRoomsUser' => (new RolesRoomsUser4testFixture())->records[5], 'previous_accessed', '2014/06/17'),
			array('rolesRoomsUser' => (new RolesRoomsUser4testFixture())->records[0], 'last_accessed', ''),
		);
	}

/**
 * roomAccessed()のテスト
 *
 * @param array $rolesRoomsUser RolesRoomsUserデータ
 * @param string $field フィールド
 * @param string $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testRoomAccessed($rolesRoomsUser, $field, $expected) {
		//データ生成
		$room = array();
		$room['RolesRoomsUser'] = $rolesRoomsUser;

		//テスト実施
		$result = $this->Rooms->roomAccessed($room, $field);

		//チェック
		$this->assertEquals($expected, $result);
	}

}
