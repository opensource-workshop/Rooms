<?php
/**
 * RoomsFormHelper::settingTabs()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * RoomsFormHelper::settingTabs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Helper\RoomsFormHelper
 */
class RoomsFormHelperSettingTabsTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
	}

/**
 * settingTabs用DataProvider
 *
 * ### 戻り値
 *  - controller コントローラ
 *
 * @return array テストデータ
 */
	public function dataProviderActionEdit() {
		$results = array();
		$results[0] = array('rooms');
		$results[1] = array('rooms_roles_users');
		$results[2] = array('plugins_rooms');

		return $results;
	}

/**
 * settingTabs()のテスト
 * [各コントローラ、editアクション]
 *
 * @param string $controller コントローラ
 * @dataProvider dataProviderActionEdit
 * @return void
 */
	public function testSettingTabsByActionEdit($controller) {
		//テストデータ生成
		$spaceId = '2';
		$roomId = '5';
		$parentId = '2';

		$viewVars = array(
			'activeSpaceId' => $spaceId,
			'activeRoomId' => $roomId,
		);
		$requestData = array(
			'Room' => array('id' => $roomId, 'parent_id' => $parentId)
		);

		//Helperロード
		$this->loadHelper('Rooms.RoomsForm', $viewVars, $requestData, array('controller' => $controller, 'action' => 'edit'));

		//テスト実施
		$result = $this->RoomsForm->settingTabs();

		//チェック
		if ($controller === 'rooms') {
			$this->__assertHelper($result, $spaceId, $roomId, 'edit', 'active', '', '');
		} elseif ($controller === 'rooms_roles_users') {
			$this->__assertHelper($result, $spaceId, $roomId, 'edit', '', 'active', '');
		} else {
			$this->__assertHelper($result, $spaceId, $roomId, 'edit', '', '', 'active');
		}
	}

/**
 * settingTabs()のテスト
 * [roomsコントローラ、editアクション、パブリックスペース]
 *
 * @return void
 */
	public function testSettingTabsByPublicSpace() {
		//テストデータ生成
		$spaceId = '4';
		$roomId = '2';
		$parentId = null;
		$controller = 'rooms';

		$viewVars = array(
			'activeSpaceId' => $spaceId,
			'activeRoomId' => $roomId,
		);
		$requestData = array(
			'Room' => array('id' => $roomId, 'parent_id' => $parentId)
		);

		//Helperロード
		$this->loadHelper('Rooms.RoomsForm', $viewVars, $requestData, array('controller' => $controller, 'action' => 'edit'));

		//テスト実施
		$result = $this->RoomsForm->settingTabs();

		//チェック
		$this->__assertHelper($result, $spaceId, $roomId, 'edit', 'active', '', '');
	}

/**
 * settingTabs()のテスト
 * [roomsコントローラ、editアクション、コミュニティスペース]
 *
 * @return void
 */
	public function testSettingTabsByRoomSpace() {
		//テストデータ生成
		$spaceId = '4';
		$roomId = '4';
		$parentId = null;
		$controller = 'rooms';

		$viewVars = array(
			'activeSpaceId' => $spaceId,
			'activeRoomId' => $roomId,
		);
		$requestData = array(
			'Room' => array('id' => $roomId, 'parent_id' => $parentId)
		);

		//Helperロード
		$this->loadHelper('Rooms.RoomsForm', $viewVars, $requestData, array('controller' => $controller, 'action' => 'edit'));

		//テスト実施
		$result = $this->RoomsForm->settingTabs();

		//チェック
		$this->__assertHelper($result, $spaceId, $roomId, 'edit', 'active', null, null);
	}

/**
 * settingTabs()のチェック
 *
 * @param string $result 結果
 * @param int $spaceId スペースID
 * @param int $roomId ルームID
 * @param string $action アクション
 * @param string $roomsAct ルーム設定タブのアクティブかどうか
 * @param string $roomsRolesUsersAct ユーザ選択タブのアクティブかどうか
 * @param string $pluginsRoomsAct プラグイン選択タブのアクティブかどうか
 * @return void
 */
	private function __assertHelper($result, $spaceId, $roomId, $action, $roomsAct, $roomsRolesUsersAct, $pluginsRoomsAct) {
		if ($action === 'edit') {
			$roomId = $roomId . '/';
		}

		$pattern = '<li class="' . $roomsAct . '">' .
						'<a href="/rooms/rooms/edit/' . $spaceId . '/' . $roomId . '">' .
							__d('rooms', 'General setting') .
						'</a>' .
					'</li>';
		$this->assertTextContains($pattern, $result);

		$pattern = '<li class="' . $roomsRolesUsersAct . '">' .
						'<a href="/rooms/rooms_roles_users/edit/' . $spaceId . '/' . $roomId . '">' .
							__d('rooms', 'Edit the members to join') .
						'</a>' .
					'</li>';
		if (isset($roomsRolesUsersAct)) {
			$this->assertTextContains($pattern, $result);
		} else {
			$this->assertTextNotContains($pattern, $result);
		}

		$pattern = '<li class="' . $pluginsRoomsAct . '">' .
						'<a href="/rooms/plugins_rooms/edit/' . $spaceId . '/' . $roomId . '">' .
							__d('rooms', 'Select the plugins to join') .
						'</a>' .
					'</li>';
		if (isset($pluginsRoomsAct)) {
			$this->assertTextContains($pattern, $result);
		} else {
			$this->assertTextNotContains($pattern, $result);
		}
	}

}
