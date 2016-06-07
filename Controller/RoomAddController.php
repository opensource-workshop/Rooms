<?php
/**
 * ルーム作成(ウィザード) Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppController', 'Rooms.Controller');
App::uses('RoomsRolesUsersController', 'Rooms.Controller');

/**
 * ルーム作成(ウィザード) Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class RoomAddController extends RoomsAppController {

/**
 * ウィザード定数(一般設定)
 *
 * @var string
 */
	const WIZARD_ROOMS = 'rooms';

/**
 * ウィザード定数(参加者の管理)
 *
 * @var string
 */
	const WIZARD_ROOMS_ROLES_USERS = 'rooms_roles_users';

/**
 * ウィザード定数(プラグイン選択)
 *
 * @var string
 */
	const WIZARD_PLUGINS_ROOMS = 'plugins_rooms';

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'M17n.SwitchLanguage' => array(
			'fields' => array(
				'RoomsLanguage.name'
			)
		),
		'Rooms.RoomsRolesForm' => array(
			'permissions' => array('content_publishable', 'html_not_limited')
		),
		'UserAttributes.UserAttributeLayout',
		'Users.UserSearch',
	);

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Rooms.Room',
		'Rooms.RolesRoom',
		'Rooms.RolesRoomsUser',
		'Users.User',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Wizard' => array(
			'navibar' => array(
				self::WIZARD_ROOMS => array(
					'url' => array(
						'controller' => 'room_add',
						'action' => 'basic',
					),
					'label' => array('rooms', 'General setting'),
				),
				self::WIZARD_ROOMS_ROLES_USERS => array(
					'url' => array(
						'controller' => 'room_add',
						'action' => 'rooms_roles_users',
					),
					'label' => array('rooms', 'Edit the members to join'),
				),
				self::WIZARD_PLUGINS_ROOMS => array(
					'url' => array(
						'controller' => 'room_add',
						'action' => 'plugins_rooms',
					),
					'label' => array('rooms', 'Select the plugins to join'),
				),
			),
			'cancelUrl' => null
		),
		'UserAttributes.UserAttributeLayout',
		'Users.UserSearchForm',
		'Users.UserSearch',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//ウィザードの設定
		$navibar = $this->helpers['NetCommons.Wizard']['navibar'];
		$navibar = Hash::insert($navibar, '{s}.url.key', $this->params['pass'][0]);
		$navibar = Hash::insert($navibar, '{s}.url.key2', $this->params['pass'][1]);
		$this->helpers['NetCommons.Wizard']['navibar'] = $navibar;

		$spaces = $this->viewVars['spaces'];
		$activeSpaceId = $this->viewVars['activeSpaceId'];
		$this->helpers['NetCommons.Wizard']['cancelUrl'] =
				'/rooms/' . $spaces[$activeSpaceId]['Space']['default_setting_action'];
	}

/**
 * 追加アクション
 *
 * @return void
 */
	public function basic() {
		$spaceId = $this->viewVars['activeSpaceId'];
		$roomId = $this->viewVars['activeRoomId'];
		$room = $this->viewVars['room'];

		//スペースModel
		$model = Inflector::camelize($this->viewVars['spaces'][$spaceId]['Space']['plugin_key']);
		$this->$model = ClassRegistry::init($model . '.' . $model);
		$this->set('participationFixed', $this->$model->participationFixed);

		if ($this->request->is('post') || $this->request->is('put')) {
			//不要パラメータ除去
			unset($this->request->data['save'], $this->request->data['active_lang_id']);

			//他言語が入力されていない場合、Currentの言語データをセット
			$this->SwitchLanguage->setM17nRequestValue();

			//登録処理
			$this->request->data['Room']['in_draft'] = true;
			$room = $this->Room->saveRoom($this->request->data);
			if ($room) {
				//正常の場合
				$this->Session->write('RoomAdd', $room);
				return $this->redirect('/rooms/room_add/rooms_roles_users/' . $spaceId . '/' . $roomId);
			}
			$this->NetCommons->handleValidationError($this->Room->validationErrors);

		} else {
			//表示処理
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

			$referer = '/rooms/room_add/rooms_roles_users/' . $spaceId . '/' . $roomId;
			if ($this->referer() === Configure::read('App.fullBaseUrl') . $referer) {
				$roomId = $this->Session->read('RoomAdd.Room.id');
				$this->request->data = $this->Room->findById($roomId);
				$this->RoomsRolesForm->settings['room_id'] = $roomId;
			} else {
				$this->request->data = Hash::merge($this->request->data,
					$this->$model->createRoom(array(
						'space_id' => $spaceId,
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
				$this->RoomsRolesForm->settings['room_id'] = null;
			}
		}

		//RoomsRolesFormのセット
		$this->RoomsRolesForm->settings['type'] = DefaultRolePermission::TYPE_ROOM_ROLE;
	}

/**
 * 参加者の管理
 *
 * @return void
 */
	public function rooms_roles_users() {
		$roomId = $this->Session->read('RoomAdd.Room.id');
		$room = $this->Room->findById($roomId);
		$this->set('room', $room);

		return $this->RoomsRolesForm->actionRoomsRolesUser($this, false);
	}

/**
 * 検索フォーム表示アクション
 *
 * @return void
 */
	public function search_conditions() {
		//検索フォーム表示
		$this->UserSearch->conditions();
	}

}
