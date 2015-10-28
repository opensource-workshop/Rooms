<?php
/**
 * RoomsUsers Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppController', 'Rooms.Controller');

/**
 * RoomsUsers Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class RoomsRolesUsersController extends RoomsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		//'Rooms.RoomsLanguage',
		'Rooms.RolesRoomsUser',
		//'Rooms.Space',
		//'Rooms.SpacesLanguage',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		'Rooms.RoomsUtility',
		'Rooms.SpacesUtility',
		'UserAttributes.UserAttributeLayout',
		'Users.UserSearch',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		//'Users.UserValue',
		'UserRoles.UserRoleForm',
		'Users.UserSearch',
	);

/**
 * edit
 *
 * @param int $roomId rooms.id
 * @return void
 */
	public function edit($roomId = null) {
		//登録処理の場合、URLよりPOSTパラメータでチェックする
		if ($this->request->isPost()) {
			$roomId = $this->data['Room']['id'];
		}
		//ルームデータチェック＆セット
		if (! $this->RoomsUtility->validRoom($roomId)) {
			return;
		}
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($this->viewVars['room']['Room']['space_id'])) {
			return;
		}

		if ($this->request->isPost()) {
			//登録処理
			$data = $this->data;

			//--不要パラメータ除去
			unset($data['save']);

			$this->request->data = $data;
		} else {
			$this->UserSearch->search();

			$displayFields = $this->User->getDispayFields();
			$displayFields = Hash::merge(array('room_role_key'), $displayFields);
			$this->set('displayFields', $displayFields);
		}
	}
}
