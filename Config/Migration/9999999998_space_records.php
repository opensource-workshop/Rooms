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
class SpaceRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'space_records';

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
		'Space' => array(
			array(
				'id' => '1',
				'parent_id' => null,
				'lft' => '1',
				'rght' => '8',
				'type' => '1',
				'plugin_key' => null,
				'default_setting_action' => null
			),
			array(
				'id' => '2',
				'parent_id' => '1',
				'lft' => '2',
				'rght' => '3',
				'type' => '2',
				'plugin_key' => 'public_space',
				'default_setting_action' => 'rooms/index/2'
			),
			array(
				'id' => '3',
				'parent_id' => '1',
				'lft' => '4',
				'rght' => '5',
				'type' => '3',
				'plugin_key' => 'private_space',
				'default_setting_action' => 'rooms/edit/2'
			),
			array(
				'id' => '4',
				'parent_id' => '1',
				'lft' => '6',
				'rght' => '7',
				'type' => '4',
				'plugin_key' => 'room_space',
				'default_setting_action' => 'rooms/index/4'
			),
		),
		'DefaultRolePermission' => array(
			//HTMLタグの書き込み制限
			//(パブリックスペース)
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'html_not_limited', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'chief_editor', 'type' => 'public_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'public_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'public_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'public_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(プライベートスペース)
			array('role_key' => 'room_administrator', 'type' => 'private_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'private_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'private_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'private_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'private_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(グループルームスペース)
			array('role_key' => 'room_administrator', 'type' => 'room_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'room_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'room_space', 'permission' => 'html_not_limited', 'value' => '0', 'fixed' => '1', ),

			//画像ファイルのアップロード制限
			//(パブリックスペース)
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'chief_editor', 'type' => 'public_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'public_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'public_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'public_space', 'permission' => 'upload_picture_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(プライベートスペース)
			array('role_key' => 'room_administrator', 'type' => 'private_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'private_space', 'permission' => 'upload_picture_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'private_space', 'permission' => 'upload_picture_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'private_space', 'permission' => 'upload_picture_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'private_space', 'permission' => 'upload_picture_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(グループルームスペース)
			array('role_key' => 'room_administrator', 'type' => 'room_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'room_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'room_space', 'permission' => 'upload_picture_not_limited', 'value' => '0', 'fixed' => '1', ),

			//添付ファイルのアップロード制限
			//(パブリックスペース)
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'chief_editor', 'type' => 'public_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'public_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'public_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'public_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(プライベートスペース)
			array('role_key' => 'room_administrator', 'type' => 'private_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'private_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'private_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'private_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'private_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(グループルームスペース)
			array('role_key' => 'room_administrator', 'type' => 'room_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'room_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'room_space', 'permission' => 'upload_attachment_not_limited', 'value' => '0', 'fixed' => '1', ),

			//動画ファイルのアップロード制限
			//(パブリックスペース)
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '1', ),
			array('role_key' => 'chief_editor', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(プライベートスペース)
			array('role_key' => 'room_administrator', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(グループルームスペース)
			array('role_key' => 'room_administrator', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '1', ),
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
