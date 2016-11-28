<?php
/**
 * 削除用Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockFixture', 'Blocks.Test/Fixture');

/**
 * 削除用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class Block4deleteFixture extends BlockFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Block';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'blocks';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//削除されないデータ
		array(
			'id' => '2',
			'room_id' => '2',
			'plugin_key' => 'test',
			'key' => 'block_1',
			'public_type' => '1',
		),
		//削除対象のデータ
		array(
			'id' => '4',
			'room_id' => '5',
			'plugin_key' => 'test',
			'key' => 'delete_block_1',
			'public_type' => '1',
		),
		array(
			'id' => '6',
			'room_id' => '5',
			'plugin_key' => 'test',
			'key' => 'delete_block_2',
			'public_type' => '1',
		),
	);

}
