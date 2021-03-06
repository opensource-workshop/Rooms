<?php
/**
 * Page4testFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PageFixture', 'Blocks.Test/Fixture');

/**
 * Page4testFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class Page4testFixture extends PageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Page';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'pages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'room_id' => '2',
			'parent_id' => null,
			'lft' => 1,
			'rght' => 2,
			'permalink' => '',
			'slug' => null,
			'is_container_fluid' => 1,
			'created_user' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		//page.permalink=test
		array(
			'id' => '2',
			'room_id' => '2',
			'parent_id' => 1,
			'lft' => 3,
			'rght' => 4,
			'permalink' => 'test',
			'slug' => 'test',
			'is_container_fluid' => 1,
			'created_user' => null,
			'created' => '2014-05-12 05:04:42',
			'modified_user' => null,
			'modified' => '2014-05-12 05:04:42'
		),
		//別ルーム(room_id=5)
		array(
			'id' => '3',
			'room_id' => '5',
			'parent_id' => null,
			'lft' => 5,
			'rght' => 6,
			'permalink' => 'test2',
			'slug' => 'test2',
			'is_container_fluid' => 1,
		),
		//別ルーム(room_id=6、ブロックなし)
		array(
			'id' => '4',
			'room_id' => '6',
			'parent_id' => null,
			'lft' => 7,
			'rght' => 8,
			'permalink' => 'test3',
			'slug' => 'test3',
			'is_container_fluid' => 1,
		),
		//別ルーム(room_id=7、準備中)
		array(
			'id' => '5',
			'room_id' => '7',
			'parent_id' => null,
			'lft' => 9,
			'rght' => 10,
			'permalink' => 'test4',
			'slug' => 'test4',
			'is_container_fluid' => 1,
		),
	);

}
