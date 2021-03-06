<?php
/**
 * RoomRolePermissionFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * RoomRolePermissionFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RoomRolePermissionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'roles_room_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'ルーム毎のロールID'),
		'permission' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'パーミッション  e.g.) content_creatable', 'charset' => 'utf8'),
		'value' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		////パブリックスペース
		////--ルーム管理者
		//array('roles_room_id' => '1', 'permission' => 'block_editable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'content_comment_creatable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'content_comment_editable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'content_comment_publishable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'content_creatable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'content_editable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'content_publishable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'content_readable', 'value' => '1'),
		//array('roles_room_id' => '1', 'permission' => 'page_editable', 'value' => '1'),
		array('roles_room_id' => '1', 'permission' => 'html_not_limited', 'value' => '1'),
		////array('roles_room_id' => '1', 'permission' => 'mail_content_receivable', 'value' => '1'),
		////--編集長
		//array('roles_room_id' => '2', 'permission' => 'block_editable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'content_comment_creatable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'content_comment_editable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'content_comment_publishable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'content_creatable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'content_editable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'content_publishable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'content_readable', 'value' => '1'),
		//array('roles_room_id' => '2', 'permission' => 'page_editable', 'value' => '1'),
		//※WYSIWYGでエラーになるため、0->1にする(後で、WYSWIYGが修正されれば、削除する)
		array('roles_room_id' => '2', 'permission' => 'html_not_limited', 'value' => '1'),
		////array('roles_room_id' => '2', 'permission' => 'mail_content_receivable', 'value' => '1'),
		////--編集者
		//array('roles_room_id' => '3', 'permission' => 'block_editable', 'value' => '0'),
		//array('roles_room_id' => '3', 'permission' => 'content_comment_creatable', 'value' => '1'),
		//array('roles_room_id' => '3', 'permission' => 'content_comment_editable', 'value' => '1'),
		//array('roles_room_id' => '3', 'permission' => 'content_comment_publishable', 'value' => '0'),
		//array('roles_room_id' => '3', 'permission' => 'content_creatable', 'value' => '1'),
		//array('roles_room_id' => '3', 'permission' => 'content_editable', 'value' => '1'),
		//array('roles_room_id' => '3', 'permission' => 'content_publishable', 'value' => '0'),
		//array('roles_room_id' => '3', 'permission' => 'content_readable', 'value' => '1'),
		//array('roles_room_id' => '3', 'permission' => 'page_editable', 'value' => '0'),
		//※WYSIWYGでエラーになるため、0->1にする(後で、WYSWIYGが修正されれば、削除する)
		array('roles_room_id' => '3', 'permission' => 'html_not_limited', 'value' => '1'),
		////array('roles_room_id' => '3', 'permission' => 'mail_content_receivable', 'value' => '1'),
		////--一般
		//array('roles_room_id' => '4', 'permission' => 'block_editable', 'value' => '0'),
		//array('roles_room_id' => '4', 'permission' => 'content_comment_creatable', 'value' => '1'),
		//array('roles_room_id' => '4', 'permission' => 'content_comment_editable', 'value' => '0'),
		//array('roles_room_id' => '4', 'permission' => 'content_comment_publishable', 'value' => '0'),
		//array('roles_room_id' => '4', 'permission' => 'content_creatable', 'value' => '1'),
		//array('roles_room_id' => '4', 'permission' => 'content_editable', 'value' => '0'),
		//array('roles_room_id' => '4', 'permission' => 'content_publishable', 'value' => '0'),
		//array('roles_room_id' => '4', 'permission' => 'content_readable', 'value' => '1'),
		//array('roles_room_id' => '4', 'permission' => 'page_editable', 'value' => '0'),
		//※WYSIWYGでエラーになるため、0->1にする(後で、WYSWIYGが修正されれば、削除する)
		array('roles_room_id' => '4', 'permission' => 'html_not_limited', 'value' => '1'),
		////array('roles_room_id' => '4', 'permission' => 'mail_content_receivable', 'value' => '1'),
		////--ゲスト
		//array('roles_room_id' => '5', 'permission' => 'block_editable', 'value' => '0'),
		//array('roles_room_id' => '5', 'permission' => 'content_comment_creatable', 'value' => '0'),
		//array('roles_room_id' => '5', 'permission' => 'content_comment_editable', 'value' => '0'),
		//array('roles_room_id' => '5', 'permission' => 'content_comment_publishable', 'value' => '0'),
		//array('roles_room_id' => '5', 'permission' => 'content_creatable', 'value' => '0'),
		//array('roles_room_id' => '5', 'permission' => 'content_editable', 'value' => '0'),
		//array('roles_room_id' => '5', 'permission' => 'content_publishable', 'value' => '0'),
		//array('roles_room_id' => '5', 'permission' => 'content_readable', 'value' => '1'),
		//array('roles_room_id' => '5', 'permission' => 'page_editable', 'value' => '0'),
		//※WYSIWYGでエラーになるため、0->1にする(後で、WYSWIYGが修正されれば、削除する)
		array('roles_room_id' => '5', 'permission' => 'html_not_limited', 'value' => '1'),
		////array('roles_room_id' => '5', 'permission' => 'mail_content_receivable', 'value' => '0'),
	);

}
