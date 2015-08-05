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
				'page_layout_permitted' => null,
				'plugin' => null,
				'default_setting_action' => null
			),
			array(
				'id' => '2',
				'parent_id' => '1',
				'lft' => '2',
				'rght' => '3',
				'type' => '2',
				'page_layout_permitted' => '1',
				'plugin' => 'public_space',
				'default_setting_action' => 'rooms/index/2'
			),
			array(
				'id' => '3',
				'parent_id' => '1',
				'lft' => '4',
				'rght' => '5',
				'type' => '3',
				'page_layout_permitted' => '0',
				'plugin' => 'private_space',
				'default_setting_action' => 'spaces/edit/3'
			),
			array(
				'id' => '4',
				'parent_id' => '1',
				'lft' => '6',
				'rght' => '7',
				'type' => '4',
				'page_layout_permitted' => '1',
				'plugin' => 'room_space',
				'default_setting_action' => 'rooms/index/4'
			),
		),
		'SpacesLanguage' => array(
			//日本語
			array('language_id' => '2', 'space_id' => '1', 'name' => 'サイト全体'),
			array('language_id' => '2', 'space_id' => '2', 'name' => 'パブリックスペース'),
			array('language_id' => '2', 'space_id' => '3', 'name' => 'プライベートスペース'),
			array('language_id' => '2', 'space_id' => '4', 'name' => 'グループルームスペース'),
			//英語
			array('language_id' => '1', 'space_id' => '1', 'name' => 'Whole site'),
			array('language_id' => '1', 'space_id' => '2', 'name' => 'Public space'),
			array('language_id' => '1', 'space_id' => '3', 'name' => 'Private space'),
			array('language_id' => '1', 'space_id' => '4', 'name' => 'Room space'),
		),
		'DefaultRolePermission' => array(
			//HTMLタグの書き込み制限
			//(パブリックスペース)
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'html_not_limited', 'value' => '1', 'fixed' => '0', ),
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
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'upload_picture_not_limited', 'value' => '1', 'fixed' => '0', ),
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
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'upload_attachment_not_limited', 'value' => '1', 'fixed' => '0', ),
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
			array('role_key' => 'room_administrator', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'public_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(プライベートスペース)
			array('role_key' => 'room_administrator', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'general_user', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '0', ),
			array('role_key' => 'visitor', 'type' => 'private_space', 'permission' => 'upload_video_not_limited', 'value' => '0', 'fixed' => '1', ),
			//(グループルームスペース)
			array('role_key' => 'room_administrator', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'chief_editor', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
			array('role_key' => 'editor', 'type' => 'room_space', 'permission' => 'upload_video_not_limited', 'value' => '1', 'fixed' => '0', ),
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
