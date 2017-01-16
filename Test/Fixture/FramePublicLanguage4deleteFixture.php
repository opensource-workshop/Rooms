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

App::uses('FramePublicLanguageFixture', 'Frames.Test/Fixture');

/**
 * 削除用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class FramePublicLanguage4deleteFixture extends FramePublicLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'FramePublicLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'frame_public_languages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//削除されないデータ
		array(
			'frame_id' => '2',
			'language_id' => '0',
			'is_public' => '1',
		),
		//削除対象のデータ
		array(
			'frame_id' => '4',
			'language_id' => '0',
			'is_public' => '1',
		),
		array(
			'frame_id' => '6',
			'language_id' => '0',
			'is_public' => '1',
		),
	);

}
