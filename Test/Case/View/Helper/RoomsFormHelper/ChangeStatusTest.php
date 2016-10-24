<?php
/**
 * RoomsFormHelper::changeStatus()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('RoomFixture', 'Rooms.Test/Fixture');
App::uses('SpaceFixture', 'Rooms.Test/Fixture');

/**
 * RoomsFormHelper::changeStatus()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case\View\Helper\RoomsFormHelper
 */
class RoomsFormHelperChangeStatusTest extends NetCommonsHelperTestCase {

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
		$this->loadHelper('Rooms.RoomsForm', $viewVars, $requestData);

		// NetCommonsForm::create('Room', ・・・でapp/Model/Roomが参照される前に、Rooms.Roomをloadさせる。
		// https://github.com/cakephp/cakephp/blob/7c2d6ae1977c9c135de95177c488b1a8875fc9d6/lib/Cake/View/Helper/FormHelper.php#L171
		// からの
		// https://github.com/cakephp/cakephp/blob/97c6850005ed1e50ddcc6a7137138be2c575b654/lib/Cake/Utility/ClassRegistry.php#L144
		// 通常は、Contorller側で、Rooms.Roomを操作しているはずなので、とりあえずTest実行時のみの対応としとく。
		ClassRegistry::init('Rooms.Room');
	}

/**
 * changeStatus()のテスト(公開中の場合)
 *
 * @return void
 */
	public function testChangeStatusActive() {
		//データ生成
		$room['Space'] = (new SpaceFixture())->records[0];
		$room['Room'] = (new RoomFixture())->records[2];
		$room['Room']['active'] = '1';

		//テスト実施
		$result = $this->RoomsForm->changeStatus($room);

		//チェック
		$this->assertInput('form', null, '/rooms/active/1/5', $result);
		$this->assertInput('input', '_method', 'PUT', $result);
		$this->assertInput('input', 'data[Room][id]', '5', $result);
		$this->assertInput('input', 'data[Room][active]', '0', $result);
		$this->assertTextContains(__d('rooms', 'Open'), $result);
	}

/**
 * changeStatus()のテスト(準備中の場合)
 *
 * @return void
 */
	public function testChangeStatusInactive() {
		//データ生成
		$room['Space'] = (new SpaceFixture())->records[0];
		$room['Room'] = (new RoomFixture())->records[2];
		$room['Room']['active'] = '0';

		//テスト実施
		$result = $this->RoomsForm->changeStatus($room);

		//チェック
		$this->assertInput('form', null, '/rooms/active/1/5', $result);
		$this->assertInput('input', '_method', 'PUT', $result);
		$this->assertInput('input', 'data[Room][id]', '5', $result);
		$this->assertInput('input', 'data[Room][active]', '1', $result);
		$this->assertTextContains(__d('rooms', 'Under maintenance'), $result);
	}

}
