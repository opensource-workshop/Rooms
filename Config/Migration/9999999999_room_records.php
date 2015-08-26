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
class RoomRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'room_records';

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
		'DefaultRolePermission' => array(
			//HTMLタグの書き込み制限
			array('role_key' => 'room_administrator', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'room_role', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '1', ),
		),
		'RolesRoom' => array(
			//パブリックスペース
			array('id' => '1', 'room_id' => '1', 'role_key' => 'room_administrator'),
			array('id' => '2', 'room_id' => '1', 'role_key' => 'chief_editor'),
			array('id' => '3', 'room_id' => '1', 'role_key' => 'editor'),
			array('id' => '4', 'room_id' => '1', 'role_key' => 'general_user'),
			array('id' => '5', 'room_id' => '1', 'role_key' => 'visitor'),
			//プライベートスペース
			array('id' => '6', 'room_id' => '2', 'role_key' => 'room_administrator'),
			//グループスペース
			array('id' => '7', 'room_id' => '3', 'role_key' => 'room_administrator'),
			array('id' => '8', 'room_id' => '3', 'role_key' => 'chief_editor'),
			array('id' => '9', 'room_id' => '3', 'role_key' => 'editor'),
			array('id' => '10', 'room_id' => '3', 'role_key' => 'general_user'),
			array('id' => '11', 'room_id' => '3', 'role_key' => 'visitor'),
		),
		'RolesRoomsUser' => array(
			//パブリックスペース
			array('id' => '1', 'roles_room_id' => '1', 'user_id' => '1'),
			//プライベートスペース
			array('id' => '2', 'roles_room_id' => '6', 'user_id' => '1'),
			//グループスペース
			array('id' => '3', 'roles_room_id' => '7', 'user_id' => '1'),
		),
		'RoomRolePermission' => array(
			//パブリックスペース
			//--ルーム管理者
			array('roles_room_id' => '1', 'permission' => 'block_editable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'content_editable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'content_publishable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'page_editable', 'value' => '1'),
			array('roles_room_id' => '1', 'permission' => 'html_not_limited', 'value' => '1'),
			//--編集長
			array('roles_room_id' => '2', 'permission' => 'block_editable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'content_editable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'content_publishable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'page_editable', 'value' => '1'),
			array('roles_room_id' => '2', 'permission' => 'html_not_limited', 'value' => '0'),
			//--編集者
			array('roles_room_id' => '3', 'permission' => 'block_editable', 'value' => '0'),
			array('roles_room_id' => '3', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('roles_room_id' => '3', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('roles_room_id' => '3', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('roles_room_id' => '3', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '3', 'permission' => 'content_editable', 'value' => '1'),
			array('roles_room_id' => '3', 'permission' => 'content_publishable', 'value' => '0'),
			array('roles_room_id' => '3', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '3', 'permission' => 'page_editable', 'value' => '0'),
			array('roles_room_id' => '3', 'permission' => 'html_not_limited', 'value' => '0'),
			//--一般
			array('roles_room_id' => '4', 'permission' => 'block_editable', 'value' => '0'),
			array('roles_room_id' => '4', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('roles_room_id' => '4', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('roles_room_id' => '4', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('roles_room_id' => '4', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '4', 'permission' => 'content_editable', 'value' => '0'),
			array('roles_room_id' => '4', 'permission' => 'content_publishable', 'value' => '0'),
			array('roles_room_id' => '4', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '4', 'permission' => 'page_editable', 'value' => '0'),
			array('roles_room_id' => '4', 'permission' => 'html_not_limited', 'value' => '0'),
			//--ゲスト
			array('roles_room_id' => '5', 'permission' => 'block_editable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'content_creatable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'content_editable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'content_publishable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '5', 'permission' => 'page_editable', 'value' => '0'),
			array('roles_room_id' => '5', 'permission' => 'html_not_limited', 'value' => '0'),
			//プライベートスペース
			//--ルーム管理者
			array('roles_room_id' => '6', 'permission' => 'block_editable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'content_editable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'content_publishable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'page_editable', 'value' => '1'),
			array('roles_room_id' => '6', 'permission' => 'html_not_limited', 'value' => '1'),
			//グループスペース
			//--ルーム管理者
			array('roles_room_id' => '7', 'permission' => 'block_editable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'content_editable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'content_publishable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'page_editable', 'value' => '1'),
			array('roles_room_id' => '7', 'permission' => 'html_not_limited', 'value' => '0'),
			//--編集長
			array('roles_room_id' => '8', 'permission' => 'block_editable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'content_editable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'content_publishable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'page_editable', 'value' => '1'),
			array('roles_room_id' => '8', 'permission' => 'html_not_limited', 'value' => '0'),
			//--編集者
			array('roles_room_id' => '9', 'permission' => 'block_editable', 'value' => '0'),
			array('roles_room_id' => '9', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('roles_room_id' => '9', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('roles_room_id' => '9', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('roles_room_id' => '9', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '9', 'permission' => 'content_editable', 'value' => '1'),
			array('roles_room_id' => '9', 'permission' => 'content_publishable', 'value' => '0'),
			array('roles_room_id' => '9', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '9', 'permission' => 'page_editable', 'value' => '0'),
			array('roles_room_id' => '9', 'permission' => 'html_not_limited', 'value' => '0'),
			//--一般
			array('roles_room_id' => '10', 'permission' => 'block_editable', 'value' => '0'),
			array('roles_room_id' => '10', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('roles_room_id' => '10', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('roles_room_id' => '10', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('roles_room_id' => '10', 'permission' => 'content_creatable', 'value' => '1'),
			array('roles_room_id' => '10', 'permission' => 'content_editable', 'value' => '0'),
			array('roles_room_id' => '10', 'permission' => 'content_publishable', 'value' => '0'),
			array('roles_room_id' => '10', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '10', 'permission' => 'page_editable', 'value' => '0'),
			array('roles_room_id' => '10', 'permission' => 'html_not_limited', 'value' => '0'),
			//--ゲスト
			array('roles_room_id' => '11', 'permission' => 'block_editable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'content_creatable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'content_editable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'content_publishable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'content_readable', 'value' => '1'),
			array('roles_room_id' => '11', 'permission' => 'page_editable', 'value' => '0'),
			array('roles_room_id' => '11', 'permission' => 'html_not_limited', 'value' => '0'),
		),
		'RoomRole' => array(
			array('id' => '1', 'role_key' => 'room_administrator', 'level' => '2147483647', 'weight' => '1'),
			array('id' => '2', 'role_key' => 'chief_editor', 'level' => '8000', 'weight' => '2'),
			array('id' => '3', 'role_key' => 'editor', 'level' => '7000', 'weight' => '3'),
			array('id' => '4', 'role_key' => 'general_user', 'level' => '6000', 'weight' => '4'),
			array('id' => '5', 'role_key' => 'visitor', 'level' => '1000', 'weight' => '5'),
		),
		'Room' => array(
			//パブリックスペース
			array(
				'id' => '1',
				'space_id' => '2',
				'page_id_top' => '1',
				'parent_id' => null,
				'lft' => '1',
				'rght' => '2',
				'active' => '1',
				'default_role_key' => 'visitor',
				'need_approval' => '1',
				'default_participation' => '1',
				'page_layout_permitted' => '1',
			),
			//プライベート
			array(
				'id' => '2',
				'space_id' => '3',
				'page_id_top' => null,
				'parent_id' => null,
				'lft' => '3',
				'rght' => '4',
				'active' => '1',
				'default_role_key' => 'room_administrator',
				'need_approval' => '0',
				'default_participation' => '0',
				'page_layout_permitted' => '0',
			),
			//グループスペース
			array(
				'id' => '3',
				'space_id' => '4',
				'page_id_top' => null,
				'parent_id' => null,
				'lft' => '5',
				'rght' => '6',
				'active' => '1',
				'default_role_key' => 'general_user',
				'need_approval' => '1',
				'default_participation' => '1',
				'page_layout_permitted' => '1',
			),
		),
		'RoomsLanguage' => array(
			//パブリックスペース
			//--日本語
			array('language_id' => '2', 'room_id' => '1', 'name' => 'パブリックスペース'),
			//--英語
			array('language_id' => '1', 'room_id' => '1', 'name' => 'Public space'),
			//プライベートスペース
			//--日本語
			array('language_id' => '2', 'room_id' => '2', 'name' => 'プライベートスペース'),
			//--英語
			array('language_id' => '1', 'room_id' => '2', 'name' => 'Private space'),
			//グループスペース
			//--日本語
			array('language_id' => '2', 'room_id' => '3', 'name' => 'グループスペース'),
			//--英語
			array('language_id' => '1', 'room_id' => '3', 'name' => 'Group space'),
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