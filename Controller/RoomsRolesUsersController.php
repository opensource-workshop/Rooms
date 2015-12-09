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
 * Limit定数
 *
 * @var const
 */
	const DEFAULT_LIMIT = 30;

/**
 * 会員一覧の表示する項目
 *
 * @var const
 */
	public static $displaFields = array(
		//'room_role_key',
		'handlename',
		'name',
		'role_key',
	);

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Rooms.Room',
		'Rooms.RolesRoomsUser'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Rooms.RoomsRolesForm',
		'UserAttributes.UserAttributeLayout',
		'Users.UserSearch',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'UserManager.UserSearchForm',
		'Users.UserSearch',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//ルームデータチェック
		$room = $this->viewVars['room'];

		//登録処理
		if ($this->request->isPut()) {
			foreach ($this->request->data['RolesRoomsUser'] as $i => $rolesRoomsUser) {
				if (! $rolesRoomsUser['user_id']) {
					unset($this->request->data['RolesRoomsUser'][$i]);
					continue;
				}
			}

			if ($this->request->data['Role']['key'] !== 'delete') {
				$rolesRooms = $this->Room->getRolesRooms(array(
					'Room.id' => $room['Room']['id'],
					'RolesRoom.role_key' => $this->request->data['Role']['key']
				));
				if ($rolesRooms) {
					$rolesRoomId = $rolesRooms[0]['RolesRoom']['id'];
				}
				$this->request->data['RolesRoomsUser'] = Hash::insert($this->request->data['RolesRoomsUser'], '{n}.roles_room_id', $rolesRoomId);
				$result = $this->RolesRoomsUser->saveRolesRoomsUsers($this->request->data);
			} else {
				$result = $this->RolesRoomsUser->deleteRolesRoomsUsers($this->request->data);
			}

			//登録処理
			if ($result) {
				//正常の場合
				$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array(
					'class' => 'success',
				));
			} else {
				$this->NetCommons->handleValidationError($this->RolesRoomsUser->validationErrors);
			}
		} else {
			$this->UserSearch->clearConditions();
		}

		$sessionConditions = $this->Session->read(UserSearchComponent::$sessionKey);
		if (! isset($sessionConditions)) {
			$type = 'INNER';
		} else {
			$type = 'LEFT';
		}

		$this->UserSearch->search(
			array(),
			array('RolesRoomsUser' => array(
				'type' => $type,
				'conditions' => array(
					'RolesRoomsUser.room_id' => $room['Room']['id'],
				)
			)),
			array('RoomRole.level' => 'desc'),
			self::DEFAULT_LIMIT
		);

		$fields = array_combine(self::$displaFields, self::$displaFields);
		$this->set('displayFields', $this->User->cleanSearchFields($fields));

		$this->request->data = $room;
		$this->request->data['RolesRoomsUser'] = Hash::combine($this->viewVars['users'], '{n}.User.id', '{n}.RolesRoomsUser');
	}
}
