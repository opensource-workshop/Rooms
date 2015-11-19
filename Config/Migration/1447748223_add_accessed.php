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
 * ルームのアクセス情報の表示のための修正
 * * roles_rooms_usersテーブルにアクセス数(access_count)、アクセス日時(accessed)のフィールド追加
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
					'access_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'after' => 'room_id'),
					'accessed' => array('type' => 'datetime', 'null' => true, 'default' => null, 'after' => 'access_count'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'roles_rooms_users' => array('access_count', 'accessed'),
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
