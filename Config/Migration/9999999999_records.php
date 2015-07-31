<?php
/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Config\Migration
 */
class Records extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * Records keyed by model name.
 *
 * @var array $records
 */
	public $records = array(
		'RolesRoom' => array(
			array('id' => '1', 'room_id' => '1', 'role_key' => 'room_administrator'),
			array('id' => '2', 'room_id' => '1', 'role_key' => 'chief_editor'),
			array('id' => '3', 'room_id' => '1', 'role_key' => 'editor'),
			array('id' => '4', 'room_id' => '1', 'role_key' => 'general_user'),
			array('id' => '5', 'room_id' => '1', 'role_key' => 'visitor'),
		),
		'RolesRoomsUser' => array(
			array('id' => '1', 'roles_room_id' => '1', 'user_id' => '1'),
		),
		'RoomRolePermission' => array(
			//ルーム管理者
			array('id' => '1', 'roles_room_id' => '1', 'permission' => 'block_editable', 'value' => '1'),
			array('id' => '2', 'roles_room_id' => '1', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '3', 'roles_room_id' => '1', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '4', 'roles_room_id' => '1', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('id' => '5', 'roles_room_id' => '1', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '6', 'roles_room_id' => '1', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '7', 'roles_room_id' => '1', 'permission' => 'content_publishable', 'value' => '1'),
			array('id' => '8', 'roles_room_id' => '1', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '9', 'roles_room_id' => '1', 'permission' => 'page_editable', 'value' => '1'),
			//編集長
			array('id' => '10', 'roles_room_id' => '2', 'permission' => 'block_editable', 'value' => '1'),
			array('id' => '11', 'roles_room_id' => '2', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '12', 'roles_room_id' => '2', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '13', 'roles_room_id' => '2', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('id' => '14', 'roles_room_id' => '2', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '15', 'roles_room_id' => '2', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '16', 'roles_room_id' => '2', 'permission' => 'content_publishable', 'value' => '1'),
			array('id' => '17', 'roles_room_id' => '2', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '18', 'roles_room_id' => '2', 'permission' => 'page_editable', 'value' => '1'),
			//編集者
			array('id' => '19', 'roles_room_id' => '3', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '20', 'roles_room_id' => '3', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '21', 'roles_room_id' => '3', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '22', 'roles_room_id' => '3', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '23', 'roles_room_id' => '3', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '24', 'roles_room_id' => '3', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '25', 'roles_room_id' => '3', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '26', 'roles_room_id' => '3', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '27', 'roles_room_id' => '3', 'permission' => 'page_editable', 'value' => '0'),
			//一般
			array('id' => '28', 'roles_room_id' => '4', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '29', 'roles_room_id' => '4', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('id' => '30', 'roles_room_id' => '4', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('id' => '31', 'roles_room_id' => '4', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '32', 'roles_room_id' => '4', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '33', 'roles_room_id' => '4', 'permission' => 'content_editable', 'value' => '0'),
			array('id' => '34', 'roles_room_id' => '4', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '35', 'roles_room_id' => '4', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '36', 'roles_room_id' => '4', 'permission' => 'page_editable', 'value' => '0'),
			//ゲスト
			array('id' => '37', 'roles_room_id' => '5', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '38', 'roles_room_id' => '5', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('id' => '39', 'roles_room_id' => '5', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('id' => '40', 'roles_room_id' => '5', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '41', 'roles_room_id' => '5', 'permission' => 'content_creatable', 'value' => '0'),
			array('id' => '42', 'roles_room_id' => '5', 'permission' => 'content_editable', 'value' => '0'),
			array('id' => '43', 'roles_room_id' => '5', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '44', 'roles_room_id' => '5', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '45', 'roles_room_id' => '5', 'permission' => 'page_editable', 'value' => '0'),
		),
		'RoomRole' => array(
			array('id' => '1', 'role_key' => 'room_administrator', 'level' => '2147483647', 'weight' => '1'),
			array('id' => '2', 'role_key' => 'chief_editor', 'level' => '8000', 'weight' => '2'),
			array('id' => '3', 'role_key' => 'editor', 'level' => '7000', 'weight' => '3'),
			array('id' => '4', 'role_key' => 'general_user', 'level' => '6000', 'weight' => '4'),
			array('id' => '5', 'role_key' => 'visitor', 'level' => '1000', 'weight' => '5'),
		),
		'Room' => array(
			array('id' => '1', 'space_id' => '1'),
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
		if ($direction === 'down') {
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}

		return true;
	}
}
