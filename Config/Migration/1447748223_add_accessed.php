<?php
/**
 * Migration file
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Migration file
 *
 * ルームのアクセス日時の表示のための修正
 * * roles_rooms_usersテーブルにアクセス日時(accessed)のフィールド追加
 *
 * @package NetCommons\Rooms\Config\Migration
 */
class AddAccessed extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_accessed';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'roles_rooms_users' => array(
					'accessed' => array('type' => 'datetime', 'null' => true, 'default' => null, 'after' => 'room_id'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'roles_rooms_users' => array('accessed'),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
