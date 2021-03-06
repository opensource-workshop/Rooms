<?php
/**
 * View/Elements/subtitleのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/subtitleのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Elements\Subtitle
 */
class RoomsViewElementsSubtitleTest extends NetCommonsControllerTestCase {

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

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Rooms', 'TestRooms');
		//テストコントローラ生成
		$this->generateNc('TestRooms.TestViewElementsSubtitle');
	}

/**
 * View/Elements/subtitleのテスト
 *
 * @return void
 */
	public function testSubtitle() {
		//テスト実行
		$this->_testGetAction('/test_rooms/test_view_elements_subtitle/subtitle',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/subtitle', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '/' . preg_quote('<h2>', '/') . '.+?' . preg_quote('</h2>', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

}
