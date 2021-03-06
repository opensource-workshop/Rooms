<?php
/**
 * RoomsHelper::spaceTabs()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('RoomBehavior', 'Rooms.Model/Behavior');

/**
 * RoomsHelper::spaceTabs()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Helper\RoomsHelper
 */
class RoomsHelperSpaceTabsTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.rooms_language4test',
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
		$this->Room = ClassRegistry::init('Rooms.Room');

		//テストデータ生成
		RoomBehavior::$spaces = null;
		$viewVars['spaces'] = $this->Room->getSpaces();
		$requestData = array();

		//Helperロード
		$this->loadHelper('Rooms.Rooms', $viewVars, $requestData);
	}

/**
 * spaceTabs()のテスト用DataProvider
 *
 * ### 戻り値
 *  - urls $urls引数
 *  - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * urls指定なし
			array(
				'urls' => null,
				'expected' => array('2' => '/rooms/rooms/index/2', '4' => '/rooms/rooms/index/4')
			),
			// * urls文字列
			array(
				'urls' => '/rooms/rooms/view/%s',
				'expected' => array('2' => '/rooms/rooms/view/2', '4' => '/rooms/rooms/view/4')
			),
			// * urls配列
			array(
				'urls' => array(
					'2' => array('url' => '/rooms/rooms/edit/2'),
					'4' => array('url' => '/rooms/rooms/edit/4'),
				),
				'expected' => array('2' => '/rooms/rooms/edit/2', '4' => '/rooms/rooms/edit/4')
			),
		);
	}

/**
 * spaceTabs()のテスト
 *
 * @param null|string|array $urls $urls引数
 * @param array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testSpaceTabs($urls, $expected) {
		//データ生成
		$activeSpaceId = '2';
		$tabType = 'tabs';

		//テスト実施
		$result = $this->Rooms->spaceTabs($activeSpaceId, $tabType, $urls);

		//チェック
		$pattern = '/' . preg_quote('<ul class="nav nav-tabs" role="tablist">', '/') . '/';
		$this->assertRegExp($pattern, $result);

		$pattern = '/' . preg_quote('<li class="active"><a href="' . $expected['2'] . '">', '/') . '.+?' . preg_quote('</a></li>', '/') . '/';
		$this->assertRegExp($pattern, $result);

		$pattern = '/' . preg_quote('<li><a href="' . $expected['4'] . '">', '/') . '.+?' . preg_quote('</a></li>', '/') . '/';
		$this->assertRegExp($pattern, $result);
	}

}
