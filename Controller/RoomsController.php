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
		'Rooms.SpaceTabs',
		//'Paginator',
	);

/**
 * index
 *
 * @return void
 */
	public function index($spaceId = null) {
		//スペースデータチェック
		if (! $this->SpaceTabs->exist($spaceId)) {
			$this->throwBadRequest();
			return;
		}
		$this->set('activeSpaceId', $spaceId);
		$space = $this->SpaceTabs->get($spaceId);

		//ルームデータ取得
		$rooms = $this->RoomsUtility->getRoomsForPaginator($spaceId);

		$this->set(compact('space', 'rooms'));
	}

/**
 * add
 *
 * @return void
 */
	public function add($spaceId = null, $roomId = null) {
		$this->view = 'edit';

		//スペースデータチェック
		if (! $this->SpaceTabs->exist($spaceId)) {
			$this->throwBadRequest();
			return;
		}
		$this->set('activeSpaceId', $spaceId);
		$this->request->data = $this->SpaceTabs->get($spaceId);

		//登録処理の場合、URLよりPOSTパラメータでチェックする
		if ($this->request->isPost()) {
			$roomId = $this->data['Room']['parent_id'];
		}

		//ルームデータチェック
		if (isset($roomId) && ! $this->RoomsUtility->exist($roomId)) {
			$this->throwBadRequest();
			return;
		}

		if ($this->request->isPost()) {
			//登録処理

		} else {
			//表示処理
			$space = $this->SpaceTabs->get($spaceId);
			$this->set('space', $space);

			$model = Inflector::camelize($space['Space']['plugin']);
			$this->$model = ClassRegistry::init($model . '.' . $model);

			$this->RoomsRolesForm->settings['room_id'] = null;
			$this->RoomsRolesForm->settings['type'] = DefaultRolePermission::TYPE_ROOM_ROLE;

			//初期値セット
			$this->request->data['RoomsLanguage'] = array();
			foreach (array_keys($this->viewVars['languages']) as $langId) {
				$index = count($this->request->data['RoomsLanguage']);

				$this->request->data['RoomsLanguage'][$index] = $this->RoomsLanguage->create(array(
					'id' => null,
					'language_id' => $langId,
					'room_id' => null,
					'name' => '',
				));
			}
			$this->request->data = Hash::merge($this->request->data,
				$this->Room->create(array(
					'id' => null,
					'parent_id' => $roomId,
					'active' => true,
					'need_approval' => $this->$model->defaultNeedApproval,
					'default_participation' => $this->$model->defaultParticipation,
				))
			);
		}

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
		//ルームデータチェック
		if (! $this->RoomsUtility->exist($roomId)) {
			$this->throwBadRequest();
			return;
		}

		if ($this->request->isPost()) {
			$data = $this->data;

			//不要パラメータ除去
			unset($data['save'], $data['active_lang_id']);

		} else {
			$this->request->data =  $this->RoomsUtility->get($roomId);
			$this->request->data['RoomsLanguage'] = $this->RoomsLanguage->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'room_id' => $roomId,
				),
			));
		}
		$this->set('activeSpaceId', $this->request->data['Room']['space_id']);
		$space = $this->SpaceTabs->get($this->viewVars['activeSpaceId']);
		$model = Inflector::camelize($space['Space']['plugin']);
		$this->set('space', $space);

		$this->$model = ClassRegistry::init($model . '.' . $model);
		$this->set('defaultParticipationFixed', $this->$model->defaultParticipationFixed);
		$this->set('activeRoomId', $roomId);

		$this->RoomsRolesForm->settings['room_id'] = $roomId;
		$this->RoomsRolesForm->settings['type'] = DefaultRolePermission::TYPE_ROOM_ROLE;

	}

/**
 * edit
 *
 * @return void
 */
	public function delete($roomId = null) {


	}

}
