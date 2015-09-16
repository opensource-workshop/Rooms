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

App::uses('NetCommonsCakeTestFixture', 'NetCommons.TestSuite/Fixture');

/**
 * RoomFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RoomFixture extends NetCommonsCakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'space_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'page_id_top' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'root_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'default_role_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'comment' => '「ルーム内の役割」のデフォルト値'),
		'need_approval' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'default_participation' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'page_layout_permitted' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

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
			'rght' => '2',
			'active' => '1',
			'default_role_key' => 'visitor',
			'need_approval' => '1',
			'default_participation' => '1',
			'page_layout_permitted' => '1',
		),
		//プライベート
		array(
			'id' => '2',
			'space_id' => '3',
			'page_id_top' => null,
			'root_id' => null,
			'parent_id' => null,
			'lft' => '3',
			'rght' => '4',
			'active' => '1',
			'default_role_key' => 'room_administrator',
			'need_approval' => '0',
			'default_participation' => '0',
			'page_layout_permitted' => '0',
		),
		//グループスペース
		array(
			'id' => '3',
			'space_id' => '4',
			'page_id_top' => null,
			'root_id' => null,
			'parent_id' => null,
			'lft' => '5',
			'rght' => '6',
			'active' => '1',
			'default_role_key' => 'general_user',
			'need_approval' => '1',
			'default_participation' => '1',
			'page_layout_permitted' => '1',
		),
	);

}
