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
		//'Rooms.RoomsLanguage',
		//'Rooms.Room',
		//'Rooms.Space',
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
		'Rooms.SpacesUtility',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit($spaceId = null) {
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($spaceId)) {
			return;
		}
		$this->RoomsRolesForm->settings['type'] = $this->viewVars['space']['Space']['plugin_key'];

		if ($this->request->isPost()) {
			//登録処理

		} else {
			//表示処理
			//--Spaceデータ取得
			$this->request->data = $this->viewVars['space'];
			$spacesLanguage = $this->SpacesLanguage->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'space_id' => $spaceId,
				),
			));
			$this->request->data['SpacesLanguage'] = Hash::extract($spacesLanguage, '{n}.SpacesLanguage');
		}
	}

}
