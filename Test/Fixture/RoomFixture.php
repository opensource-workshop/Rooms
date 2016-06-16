<?php
/**
 * RoomFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * RoomFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RoomFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース
		array(
			'id' => '1',
			'space_id' => '2',
			'page_id_top' => '1',
			'root_id' => null,
			'parent_id' => null,
			'lft' => '1',
			'rght' => '6',
			'active' => true,
			'default_role_key' => 'visitor',
			'need_approval' => true,
			'default_participation' => true,
			'page_layout_permitted' => true,
			'theme' => null,
		),
		//別ルーム(room_id=4)
		array(
			'id' => '4',
			'space_id' => '2',
			'page_id_top' => '3',
			'root_id' => '1',
			'parent_id' => '1',
			'lft' => '2',
			'rght' => '3',
			'active' => true,
			'default_role_key' => 'visitor',
			'need_approval' => true,
			'default_participation' => true,
			'page_layout_permitted' => true,
			'theme' => null,
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '5',
			'space_id' => '2',
			'page_id_top' => '4',
			'root_id' => '1',
			'parent_id' => '1',
			'lft' => '4',
			'rght' => '5',
			'active' => true,
			'default_role_key' => 'visitor',
			'need_approval' => true,
			'default_participation' => true,
			'page_layout_permitted' => true,
			'theme' => null,
		),
		//プライベート
		array(
			'id' => '2',
			'space_id' => '3',
			'page_id_top' => null,
			'root_id' => null,
			'parent_id' => null,
			'lft' => '7',
			'rght' => '8',
			'active' => true,
			'default_role_key' => 'room_administrator',
			'need_approval' => false,
			'default_participation' => false,
			'page_layout_permitted' => false,
			'theme' => null,
		),
		//コミュニティスペース
		array(
			'id' => '3',
			'space_id' => '4',
			'page_id_top' => null,
			'root_id' => null,
			'parent_id' => null,
			'lft' => '9',
			'rght' => '12',
			'active' => true,
			'default_role_key' => 'general_user',
			'need_approval' => true,
			'default_participation' => true,
			'page_layout_permitted' => true,
			'theme' => null,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Rooms') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new RoomsSchema())->tables['rooms'];
		parent::init();
	}

}
