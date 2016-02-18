<?php
/**
 * RoomsLanguageFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsLanguageFixture', 'Rooms.Test/Fixture');

/**
 * RoomsLanguageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RoomsLanguage4testFixture extends RoomsLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'RoomsLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'rooms_languages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペース
		//--日本語
		array('id' => '1', 'language_id' => '2', 'room_id' => '1', 'name' => 'パブリックスペース'),
		//--英語
		array('id' => '2', 'language_id' => '1', 'room_id' => '1', 'name' => 'Public space'),
		//プライベートスペース
		//--日本語
		array('id' => '3', 'language_id' => '2', 'room_id' => '2', 'name' => 'プライベートスペース'),
		//--英語
		array('id' => '4', 'language_id' => '1', 'room_id' => '2', 'name' => 'Private space'),
		//グループスペース
		//--日本語
		array('id' => '5', 'language_id' => '2', 'room_id' => '3', 'name' => 'グループスペース'),
		//--英語
		array('id' => '6', 'language_id' => '1', 'room_id' => '3', 'name' => 'Group space'),
		//パブリックスペース
		//--日本語
		array('id' => '7', 'language_id' => '2', 'room_id' => '4', 'name' => 'サブルーム１'),
		//--英語
		array('id' => '8', 'language_id' => '1', 'room_id' => '4', 'name' => 'Sub room 1'),
		//--日本語
		array('id' => '9', 'language_id' => '2', 'room_id' => '5', 'name' => 'サブルーム２'),
		//--英語
		array('id' => '10', 'language_id' => '1', 'room_id' => '5', 'name' => 'Sub room 2'),
	);

}
