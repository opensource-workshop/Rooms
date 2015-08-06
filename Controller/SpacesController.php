<?php
/**
 * Rooms Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppController', 'Rooms.Controller');

/**
 * Rooms Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class SpacesController extends RoomsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Roles.DefaultRolePermission',
		'Roles.Role',
//		'Rooms.RoomsLanguage',
//		'Rooms.Room',
//		'Rooms.Space',
		'Rooms.SpacesLanguage',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		'M17n.SwitchLanguage',
		'Rooms.RoomsRolesForm' => array(
			'permissions' => array(
				'html_not_limited',
				'upload_picture_not_limited',
				'upload_attachment_not_limited',
				'upload_video_not_limited'
			)
		),
		'Rooms.SpaceTabs',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit($spaceId = null) {
		//スペースデータチェック
		if (! $this->SpaceTabs->exist($spaceId)) {
			$this->throwBadRequest();
			return;
		}
		$this->set('activeSpaceId', $spaceId);

		if ($this->request->isPost()) {
			//登録処理

		} else {
			//表示処理
			//--Spaceデータ取得
			$this->request->data = $this->SpaceTabs->get($spaceId);
			$this->request->data['SpacesLanguage'] = $this->SpacesLanguage->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'space_id' => $spaceId,
				),
			));
//			//--DefaultRolePermissionデータ取得
//			$results = $this->RoomsRolesForm->NetCommonsRoomRole->getRoomRolePermissions(null, array(
//				'html_not_limited',
//				'upload_picture_not_limited',
//				'upload_attachment_not_limited',
//				'upload_video_not_limited'
//			), $this->request->data['Space']['plugin']);
//			$this->set($results);
//			$this->RoomsRolesForm->tookPermmision = true;
//
//			$this->request->data['DefaultRolePermission'] = $results['DefaultRolePermission'];

		}
		$this->RoomsRolesForm->settings['type'] = $this->request->data['Space']['plugin'];
	}

}
