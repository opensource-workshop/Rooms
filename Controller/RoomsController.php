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
		'Rooms.RoomsLanguage',
		'Rooms.Room',
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
			'permissions' => array('content_publishable')
		),
		'Rooms.RoomsUtility',
		'Rooms.SpacesUtility',
		//'Paginator',
	);

/**
 * index
 *
 * @return void
 */
	public function index($spaceId = null) {
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($spaceId)) {
			return;
		}

		//ルームデータ取得
		$rooms = $this->RoomsUtility->getRoomsForPaginator($spaceId);
		$this->set('rooms', $rooms);
	}

/**
 * add
 *
 * @return void
 */
	public function add($spaceId = null, $roomId = null) {
		$this->view = 'edit';

		//登録処理の場合、URLよりPOSTパラメータでチェックする
		if ($this->request->isPost()) {
			$roomId = $this->data['Room']['parent_id'];
		}
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($spaceId)) {
			return;
		}
		//スペースModelの定義
		$model = Inflector::camelize($this->viewVars['space']['Space']['plugin_key']);
		$this->$model = ClassRegistry::init($model . '.' . $model);

		//ルームデータチェック＆セット
		if (! $this->RoomsUtility->validRoom($roomId, Configure::read('Config.languageId'))) {
			return;
		}

		if ($this->request->isPost()) {
			//登録処理
			$data = $this->data;

			//不要パラメータ除去
			unset($data['save'], $data['active_lang_id']);

			//登録処理
			if ($room = $this->Room->saveRoom($data, true)) {
				//正常の場合
				$this->redirect('/rooms/roles_rooms_users/edit/' . $room['Room']['id'] . '/');
				return;
			}
			$this->handleValidationError($this->Room->validationErrors);
			$this->request->data = $data;

		} else {
			//表示処理
			//--初期値セット
			$this->request->data['RoomsLanguage'] = array();
			foreach (array_keys($this->viewVars['languages']) as $langId) {
				$index = count($this->request->data['RoomsLanguage']);

				$roomsLanguage = $this->RoomsLanguage->create(array(
					'id' => null,
					'language_id' => $langId,
					'room_id' => null,
					'name' => '',
				));
				$this->request->data['RoomsLanguage'][$index] = $roomsLanguage['RoomsLanguage'];
			}

			if (isset($this->viewVars['room']['Room']['page_id_top'])) {
				$pageId = $this->viewVars['room']['Room']['page_id_top'];
			} else {
				$pageId = null;
			}

			if (isset($this->viewVars['room']['Room']['root_id'])) {
				$rootId = $this->viewVars['room']['Room']['root_id'];
			} else {
				$rootId = $roomId;
			}

			$this->request->data = Hash::merge($this->request->data,
				$this->Room->create(array(
					'id' => null,
					'space_id' => $spaceId,
					'root_id' => $rootId,
					'parent_id' => $roomId,
					'active' => true,
					'need_approval' => $this->$model->defaultNeedApproval,
					'default_participation' => $this->$model->defaultParticipation,
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

		$this->set('defaultParticipationFixed', $this->$model->defaultParticipationFixed);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit($roomId = null) {
		//登録処理の場合、URLよりPOSTパラメータでチェックする
		if ($this->request->isPost()) {
			$roomId = $this->data['Room']['id'];
		}
		//ルームデータチェック＆セット
		if (! $this->RoomsUtility->validRoom($roomId, null)) {
			return;
		}
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($this->viewVars['room']['Room']['space_id'])) {
			return;
		}

		if ($this->request->isPut()) {
			$data = $this->data;

			//不要パラメータ除去
			unset($data['save'], $data['active_lang_id']);

			//登録処理
			if ($room = $this->Room->saveRoom($data, false)) {
				//正常の場合
				$this->redirect('/rooms/roles_rooms_users/edit/' . $room['Room']['id'] . '/');
				return;
			}
			$this->handleValidationError($this->Room->validationErrors);
			$this->request->data = $data;

		} else {
			$this->request->data = $this->viewVars['room'];

			$page = $this->Page->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'id' => $this->viewVars['room']['Room']['page_id_top'],
				),
			));
			$this->request->data = Hash::merge($this->request->data, $page);
		}

		//スペースModelの定義
		$model = Inflector::camelize($this->viewVars['space']['Space']['plugin_key']);
		$this->$model = ClassRegistry::init($model . '.' . $model);
		$this->set('defaultParticipationFixed', $this->$model->defaultParticipationFixed);

		$this->RoomsRolesForm->settings['room_id'] = $roomId;
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

		//登録処理の場合、URLよりPOSTパラメータでチェックする
		$roomId = $this->data['Room']['id'];
		//ルームデータチェック＆セット
		if (! $this->RoomsUtility->validRoom($roomId, null)) {
			return;
		}
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($this->viewVars['room']['Room']['space_id'])) {
			return;
		}


		//$this->Room->deleteRoom($this->data);
		$this->redirect('/rooms/' . $this->viewVars['space']['Space']['default_setting_action']);
	}

}
