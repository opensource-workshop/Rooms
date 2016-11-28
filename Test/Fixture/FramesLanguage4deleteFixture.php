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

App::uses('FramesLanguageFixture', 'Frames.Test/Fixture');

/**
 * FramesLanguageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class FramesLanguage4deleteFixture extends FramesLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'FramesLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'frames_languages';

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
			'frame_id' => '2',
			'name' => 'Test frame',
			'is_origin' => true,
			'is_translation' => false,
		),
		//削除対象のデータ
		array(
			'id' => '4',
			'language_id' => '2',
			'frame_id' => '4',
			'name' => 'Test frame',
			'is_origin' => true,
			'is_translation' => false,
		),
		array(
			'id' => '6',
			'language_id' => '2',
			'frame_id' => '6',
			'name' => 'Test frame',
			'is_origin' => true,
			'is_translation' => false,
		),
	);

}
