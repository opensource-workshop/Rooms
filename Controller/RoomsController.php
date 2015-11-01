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
//		'Rooms.RoomsLanguage',
		'Rooms.Room',
//		'Rooms.Space',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		'M17n.SwitchLanguage',
		'Paginator',
		'Rooms.RoomsRolesForm' => array(
			'permissions' => array('content_publishable', 'html_not_limited')
		),
		'Rooms.RoomsHtml',
//		'Rooms.RoomsUtility',
//		'Rooms.SpacesUtility',
		'UserRoles.UserRoleForm',
	);

/**
 * use helper
 *
 * @var array
 */
//	public $helpers = array(
//		'UserRoles.UserRoleForm',
//	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//スペースデータチェック
		$spaceId = $this->params['pass'][0];
		if (! $this->Room->Space->exists($spaceId)) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('activeSpaceId', $spaceId);
	}

/**
 * index
 *
 * @param int $spaceId spaces.id
 * @return void
 */
	public function index() {
		//ルームデータ取得
		$this->Paginator->settings = $this->Room->getRoomsCondtions($this->viewVars['activeSpaceId']);
		$rooms = $this->Paginator->paginate('Room');
		$rooms = Hash::combine($rooms, '{n}.Room.id', '{n}');
		$this->set('rooms', $rooms);

		//Treeリスト取得
		$roomTreeList = $this->Room->generateTreeList(
				array('Room.id' => array_keys($rooms)), null, null, Room::$treeParser);
		$this->set('roomTreeList', $roomTreeList);
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

		//ルームデータチェック
		if ($this->request->isPost()) {
			//登録処理の場合、URLよりPOSTパラメータでチェックする
			$roomId = $this->data['Room']['parent_id'];
		} else {
			$roomId = $this->params['pass'][1];
		}
		if (! $this->Room->exists($roomId)) {
			$this->throwBadRequest();
			return false;
		}
		$room = $this->Room->findById($roomId);
		$this->set('room', $room);
		$this->set('activeRoomId', $roomId);

		$parentRooms = $this->Room->getPath($roomId, null, 1);
		$this->set('parentRooms', $parentRooms);

//		//ルームデータチェック＆セット
//		if (! $this->RoomsUtility->validRoom($roomId)) {
//			return;
//		}

		if ($this->request->isPost()) {
			//不要パラメータ除去
			unset($this->request->data['save'], $this->request->data['active_lang_id']);

			//登録処理
			if ($room = $this->Room->saveRoom($this->request->data)) {
				//正常の場合
				$this->redirect('/rooms/rooms_roles_users/edit/' . $room['Room']['id'] . '/');
				return;
			}
			$this->NetCommons->handleValidationError($this->Room->validationErrors);

		} else {
			//表示処理
			//--初期値セット
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
 * @param int $roomId rooms.id
 * @return void
 */
	public function edit() {
		//スペースModel
		$activeSpaceId = $this->viewVars['activeSpaceId'];
		$model = Inflector::camelize($this->viewVars['spaces'][$activeSpaceId]['Space']['plugin_key']);
		$this->$model = ClassRegistry::init($model . '.' . $model);
		$this->set('participationFixed', $this->$model->participationFixed);

		//ルームデータチェック
		if ($this->request->isPut()) {
			//登録処理の場合、URLよりPOSTパラメータでチェックする
			$roomId = $this->data['Room']['id'];
		} else {
			$roomId = $this->params['pass'][1];
		}
		if (! $this->Room->exists($roomId)) {
			$this->throwBadRequest();
			return false;
		}
		$room = $this->Room->findById($roomId);
		$this->set('room', $room);
		$this->set('activeRoomId', $roomId);

		$parentRooms = $this->Room->getPath($roomId, null, 1);
		$this->set('parentRooms', $parentRooms);


//		//登録処理の場合、URLよりPOSTパラメータでチェックする
//		if ($this->request->isPost()) {
//			$roomId = $this->data['Room']['id'];
//		}
//		//ルームデータチェック＆セット
//		if (! $this->RoomsUtility->validRoom($roomId, null)) {
//			return;
//		}
//		//スペースデータチェック＆セット
//		if (! $this->SpacesUtility->validSpace($this->viewVars['room']['Room']['space_id'])) {
//			return;
//		}
//
		if ($this->request->isPut()) {
//			$data = $this->data;

			//不要パラメータ除去
			unset($this->request->data['save'], $this->request->data['active_lang_id']);

			//登録処理
			if ($room = $this->Room->saveRoom($this->request->data)) {
				//正常の場合
				$this->redirect('/rooms/rooms_roles_users/edit/' . $room['Room']['id'] . '/');
				return;
			}
			$this->NetCommons->handleValidationError($this->Room->validationErrors);
			$this->request->data = $data;

		} else {
			//表示処理
			$this->request->data = $room;

//			$this->request->data = $this->viewVars['room'];

			$this->request->data = Hash::merge($this->request->data,
				$this->Page->find('first', array(
					'recursive' => -1,
					'conditions' => array('id' => $room['Room']['page_id_top'])
				))
			);
		}
//
//		//スペースModelの定義
//		$model = Inflector::camelize($this->viewVars['space']['Space']['plugin_key']);
//		$this->$model = ClassRegistry::init($model . '.' . $model);
//		$this->set('participationFixed', $this->$model->participationFixed);

		$this->RoomsRolesForm->settings['room_id'] = $roomId;
		$this->RoomsRolesForm->settings['type'] = DefaultRolePermission::TYPE_ROOM_ROLE;
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
//		if (! $this->request->isDelete()) {
//			$this->throwBadRequest();
//			return;
//		}
//
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
//		//削除処理
//		if (! $this->Room->deleteRoom($this->data)) {
//			$this->throwBadRequest();
//			return;
//		}
//
//		//$this->Room->deleteRoom($this->data);
//		$this->redirect('/rooms/' . $this->viewVars['space']['Space']['default_setting_action']);
	}

}
