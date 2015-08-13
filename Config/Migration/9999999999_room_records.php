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
			array('id' => '1', 'roles_room_id' => '1', 'permission' => 'block_editable', 'value' => '1'),
			array('id' => '2', 'roles_room_id' => '1', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '3', 'roles_room_id' => '1', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '4', 'roles_room_id' => '1', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('id' => '5', 'roles_room_id' => '1', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '6', 'roles_room_id' => '1', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '7', 'roles_room_id' => '1', 'permission' => 'content_publishable', 'value' => '1'),
			array('id' => '8', 'roles_room_id' => '1', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '9', 'roles_room_id' => '1', 'permission' => 'page_editable', 'value' => '1'),
			//--編集長
			array('id' => '10', 'roles_room_id' => '2', 'permission' => 'block_editable', 'value' => '1'),
			array('id' => '11', 'roles_room_id' => '2', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '12', 'roles_room_id' => '2', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '13', 'roles_room_id' => '2', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('id' => '14', 'roles_room_id' => '2', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '15', 'roles_room_id' => '2', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '16', 'roles_room_id' => '2', 'permission' => 'content_publishable', 'value' => '1'),
			array('id' => '17', 'roles_room_id' => '2', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '18', 'roles_room_id' => '2', 'permission' => 'page_editable', 'value' => '1'),
			//--編集者
			array('id' => '19', 'roles_room_id' => '3', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '20', 'roles_room_id' => '3', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '21', 'roles_room_id' => '3', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '22', 'roles_room_id' => '3', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '23', 'roles_room_id' => '3', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '24', 'roles_room_id' => '3', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '25', 'roles_room_id' => '3', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '26', 'roles_room_id' => '3', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '27', 'roles_room_id' => '3', 'permission' => 'page_editable', 'value' => '0'),
			//--一般
			array('id' => '28', 'roles_room_id' => '4', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '29', 'roles_room_id' => '4', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('id' => '30', 'roles_room_id' => '4', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('id' => '31', 'roles_room_id' => '4', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '32', 'roles_room_id' => '4', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '33', 'roles_room_id' => '4', 'permission' => 'content_editable', 'value' => '0'),
			array('id' => '34', 'roles_room_id' => '4', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '35', 'roles_room_id' => '4', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '36', 'roles_room_id' => '4', 'permission' => 'page_editable', 'value' => '0'),
			//--ゲスト
			array('id' => '37', 'roles_room_id' => '5', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '38', 'roles_room_id' => '5', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('id' => '39', 'roles_room_id' => '5', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('id' => '40', 'roles_room_id' => '5', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '41', 'roles_room_id' => '5', 'permission' => 'content_creatable', 'value' => '0'),
			array('id' => '42', 'roles_room_id' => '5', 'permission' => 'content_editable', 'value' => '0'),
			array('id' => '43', 'roles_room_id' => '5', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '44', 'roles_room_id' => '5', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '45', 'roles_room_id' => '5', 'permission' => 'page_editable', 'value' => '0'),
			//プライベートスペース
			//--ルーム管理者
			array('id' => '46', 'roles_room_id' => '6', 'permission' => 'block_editable', 'value' => '1'),
			array('id' => '47', 'roles_room_id' => '6', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '48', 'roles_room_id' => '6', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '49', 'roles_room_id' => '6', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('id' => '50', 'roles_room_id' => '6', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '51', 'roles_room_id' => '6', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '52', 'roles_room_id' => '6', 'permission' => 'content_publishable', 'value' => '1'),
			array('id' => '53', 'roles_room_id' => '6', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '54', 'roles_room_id' => '6', 'permission' => 'page_editable', 'value' => '1'),
			//グループスペース
			//--ルーム管理者
			array('id' => '55', 'roles_room_id' => '7', 'permission' => 'block_editable', 'value' => '1'),
			array('id' => '56', 'roles_room_id' => '7', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '57', 'roles_room_id' => '7', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '58', 'roles_room_id' => '7', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('id' => '59', 'roles_room_id' => '7', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '60', 'roles_room_id' => '7', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '61', 'roles_room_id' => '7', 'permission' => 'content_publishable', 'value' => '1'),
			array('id' => '62', 'roles_room_id' => '7', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '63', 'roles_room_id' => '7', 'permission' => 'page_editable', 'value' => '1'),
			//--編集長
			array('id' => '64', 'roles_room_id' => '8', 'permission' => 'block_editable', 'value' => '1'),
			array('id' => '65', 'roles_room_id' => '8', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '66', 'roles_room_id' => '8', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '67', 'roles_room_id' => '8', 'permission' => 'content_comment_publishable', 'value' => '1'),
			array('id' => '68', 'roles_room_id' => '8', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '69', 'roles_room_id' => '8', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '70', 'roles_room_id' => '8', 'permission' => 'content_publishable', 'value' => '1'),
			array('id' => '71', 'roles_room_id' => '8', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '72', 'roles_room_id' => '8', 'permission' => 'page_editable', 'value' => '1'),
			//--編集者
			array('id' => '73', 'roles_room_id' => '9', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '74', 'roles_room_id' => '9', 'permission' => 'content_comment_creatable', 'value' => '1'),
			array('id' => '75', 'roles_room_id' => '9', 'permission' => 'content_comment_editable', 'value' => '1'),
			array('id' => '76', 'roles_room_id' => '9', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '77', 'roles_room_id' => '9', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '78', 'roles_room_id' => '9', 'permission' => 'content_editable', 'value' => '1'),
			array('id' => '79', 'roles_room_id' => '9', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '80', 'roles_room_id' => '9', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '81', 'roles_room_id' => '9', 'permission' => 'page_editable', 'value' => '0'),
			//--一般
			array('id' => '82', 'roles_room_id' => '10', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '83', 'roles_room_id' => '10', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('id' => '84', 'roles_room_id' => '10', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('id' => '85', 'roles_room_id' => '10', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '86', 'roles_room_id' => '10', 'permission' => 'content_creatable', 'value' => '1'),
			array('id' => '87', 'roles_room_id' => '10', 'permission' => 'content_editable', 'value' => '0'),
			array('id' => '88', 'roles_room_id' => '10', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '89', 'roles_room_id' => '10', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '90', 'roles_room_id' => '10', 'permission' => 'page_editable', 'value' => '0'),
			//--ゲスト
			array('id' => '91', 'roles_room_id' => '11', 'permission' => 'block_editable', 'value' => '0'),
			array('id' => '92', 'roles_room_id' => '11', 'permission' => 'content_comment_creatable', 'value' => '0'),
			array('id' => '93', 'roles_room_id' => '11', 'permission' => 'content_comment_editable', 'value' => '0'),
			array('id' => '94', 'roles_room_id' => '11', 'permission' => 'content_comment_publishable', 'value' => '0'),
			array('id' => '95', 'roles_room_id' => '11', 'permission' => 'content_creatable', 'value' => '0'),
			array('id' => '96', 'roles_room_id' => '11', 'permission' => 'content_editable', 'value' => '0'),
			array('id' => '97', 'roles_room_id' => '11', 'permission' => 'content_publishable', 'value' => '0'),
			array('id' => '98', 'roles_room_id' => '11', 'permission' => 'content_readable', 'value' => '1'),
			array('id' => '99', 'roles_room_id' => '11', 'permission' => 'page_editable', 'value' => '0'),
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
