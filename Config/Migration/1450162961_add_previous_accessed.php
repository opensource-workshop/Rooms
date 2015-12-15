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
 * ルームの前回アクセス日時を追加する修正
 * * 前回アクセス日時(previous_accessed)のフィールド追加
 * * 最終アクセス日時のフィールド名(accessed→last_accessed)を変更
 *
 * @package NetCommons\Rooms\Config\Migration
 */
class AddPreviousAccessed extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_previous_accessed';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'roles_rooms_users' => array(
					'last_accessed' => array('type' => 'datetime', 'null' => true, 'default' => null, 'after' => 'access_count'),
					'previous_accessed' => array('type' => 'datetime', 'null' => true, 'default' => null, 'after' => 'last_accessed'),
				),
			),
			'drop_field' => array(
				'roles_rooms_users' => array('accessed'),
			),
		),
		'down' => array(
			'drop_field' => array(
				'roles_rooms_users' => array('last_accessed', 'previous_accessed'),
			),
			'create_field' => array(
				'roles_rooms_users' => array(
					'accessed' => array('type' => 'datetime', 'null' => true, 'default' => null),
				),
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
