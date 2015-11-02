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
class RoomsController extends RoomsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Pages.Page',
		'Rooms.Room',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'M17n.SwitchLanguage',
		'Paginator',
		'Rooms.RoomsRolesForm' => array(
			'permissions' => array('content_publishable', 'html_not_limited')
		),
		'UserRoles.UserRoleForm',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		//ルームデータセット
		$this->Rooms->setRoomsForPaginator($this->viewVars['activeSpaceId']);
	}

/**
 * addアクション
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		//スペースModel
		$activeSpaceId = $this->viewVars['activeSpaceId'];
		$model = Inflector::camelize($this->viewVars['spaces'][$activeSpaceId]['Space']['plugin_key']);
		$this->$model = ClassRegistry::init($model . '.' . $model);
		$this->set('participationFixed', $this->$model->participationFixed);

		if ($this->request->isPost()) {
			//不要パラメータ除去
			unset($this->request->data['save'], $this->request->data['active_lang_id']);

			//登録処理
			if ($room = $this->Room->saveRoom($this->request->data)) {
				//正常の場合
				$this->redirect('/rooms/rooms_roles_users/edit/' . $activeSpaceId . '/' . $room['Room']['id'] . '/');
				return;
			}
			$this->NetCommons->handleValidationError($this->Room->validationErrors);

		} else {
			//表示処理
			//--初期値セット
			$roomId = $this->viewVars['activeRoomId'];
			$room = $this->viewVars['room'];

			if (isset($room['Room']['page_id_top'])) {
				$pageId = $this->viewVars['room']['Room']['page_id_top'];
			} else {
				$pageId = null;
			}
			if (isset($room['Room']['root_id'])) {
				$rootId = $room['Room']['root_id'];
			} else {
				$rootId = $roomId;
			}
			$this->request->data = Hash::merge($this->request->data,
				$this->$model->createRoom(array(
					'space_id' => $activeSpaceId,
					'root_id' => $rootId,
					'parent_id' => $roomId,
					'default_role_key' => $room['Room']['default_role_key'],
				))
			);
			$this->request->data = Hash::merge($this->request->data,
				$this->Page->create(array(
					'parent_id' => $pageId,
				))
			);
		}

		//RoomsRolesFormのセット
		$this->RoomsRolesForm->settings['room_id'] = null;
		$this->RoomsRolesForm->settings['type'] = DefaultRolePermission::TYPE_ROOM_ROLE;
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//スペースModel
		$activeSpaceId = $this->viewVars['activeSpaceId'];
		$model = Inflector::camelize($this->viewVars['spaces'][$activeSpaceId]['Space']['plugin_key']);
		$this->$model = ClassRegistry::init($model . '.' . $model);
		$this->set('participationFixed', $this->$model->participationFixed);

		if ($this->request->isPut()) {
			//不要パラメータ除去
			unset($this->request->data['save'], $this->request->data['active_lang_id']);

			//登録処理
			if ($room = $this->Room->saveRoom($this->request->data)) {
				//正常の場合
				$this->redirect('/rooms/rooms_roles_users/edit/' . $activeSpaceId . '/' . $room['Room']['id'] . '/');
				return;
			}
			$this->NetCommons->handleValidationError($this->Room->validationErrors);

		} else {
			//表示処理
			$this->request->data = $this->viewVars['room'];
			$this->request->data = Hash::merge($this->request->data,
				$this->Page->find('first', array(
					'recursive' => -1,
					'conditions' => array('id' => $this->viewVars['room']['Room']['page_id_top'])
				))
			);
		}

		$this->RoomsRolesForm->settings['room_id'] = $this->viewVars['activeRoomId'];
		$this->RoomsRolesForm->settings['type'] = DefaultRolePermission::TYPE_ROOM_ROLE;
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}

//		//登録処理の場合、URLよりPOSTパラメータでチェックする
//		$roomId = $this->data['Room']['id'];
//		//ルームデータチェック＆セット
//		if (! $this->RoomsUtility->validRoom($roomId, null)) {
//			return;
//		}
//		//スペースデータチェック＆セット
//		if (! $this->SpacesUtility->validSpace($this->viewVars['room']['Room']['space_id'])) {
//			return;
//		}
//
		//削除処理
		if (! $this->Room->deleteRoom($this->request->data)) {
			$this->throwBadRequest();
			return;
		}
//
//		//$this->Room->deleteRoom($this->data);
		$activeSpaceId = $this->viewVars['activeSpaceId'];
		$this->redirect('/rooms/' . $this->viewVars['space'][$activeSpaceId]['Space']['default_setting_action']);
	}

}
