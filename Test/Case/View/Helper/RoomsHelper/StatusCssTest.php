<?php
/**
 * RoomsHelper::statusCss()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');

/**
 * RoomsHelper::statusCss()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Helper\RoomsHelper
 */
class RoomsHelperStatusCssTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		$viewVars = array();
		$requestData = array();

		//Helperロード
		$this->loadHelper('Rooms.Rooms', $viewVars, $requestData);
	}

/**
 * statusCss()のテスト(アクティブの場合)
 *
 * @return void
 */
	public function testStatusCssActive() {
		//データ生成
		$room = array('Room' => array('active' => '1'));
		$prefix = '';

		//テスト実施
		$result = $this->Rooms->statusCss($room, $prefix);

		//チェック
		$this->assertEquals('', $result);
	}

/**
 * statusCss()のテスト(準備中の場合)
 *
 * @return void
 */
	public function testStatusCssInactive() {
		//データ生成
		$room = array('Room' => array('active' => '0'));
		$prefix = '';

		//テスト実施
		$result = $this->Rooms->statusCss($room, $prefix);

		//チェック
		$this->assertEquals('danger', $result);
	}

}
