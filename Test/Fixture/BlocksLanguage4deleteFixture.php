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

App::uses('BlocksLanguageFixture', 'Blocks.Test/Fixture');

/**
 * 削除用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class BlocksLanguage4deleteFixture extends BlocksLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'BlocksLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'blocks_languages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//削除されないデータ
		array(
			'id' => '2',
			'language_id' => '2',
			'block_id' => '2',
			'name' => 'Block name',
			'is_origin' => true,
			'is_translation' => false,
		),
		//削除対象のデータ
		array(
			'id' => '4',
			'language_id' => '2',
			'block_id' => '2',
			'name' => 'Block name 1',
			'is_origin' => true,
			'is_translation' => false,
		),
		array(
			'id' => '6',
			'language_id' => '2',
			'block_id' => '2',
			'name' => 'Block name 2',
			'is_origin' => true,
			'is_translation' => false,
		),
	);

}
