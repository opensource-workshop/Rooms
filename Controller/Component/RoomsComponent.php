<?php
/**
 * Rooms Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * Rooms Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller\Component
 */
class RoomsComponent extends Component {

/**
 * デフォルトロールキー
 *
 * @var array
 */
	public $defaultRoleKeyList = null;

/**
 * 一覧表示の参加者リスト件数
 *
 * @var const
 */
	const LIST_LIMIT_ROOMS_USERS = 5;

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		//コンポーネント内でPaginatorを使うため、Paginatorがロードされている必要がある
		$controller->Paginator = $controller->Components->load('Paginator');

		//Modelの呼び出し
		$controller->Room = ClassRegistry::init('Rooms.Room');
		$controller->Role = ClassRegistry::init('Roles.Role');
		$controller->RolesRoomsUser = ClassRegistry::init('Rooms.RolesRoomsUser');

		$this->controller = $controller;

		//スペースデータ取得＆viewVarsにセット
		$spaces = $controller->Room->getSpaces();
		$controller->set('spaces', $spaces);
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::startup
 */
	public function startup(Controller $controller) {
		$controller->helpers[] = 'Rooms.Rooms';

		if ($this->defaultRoleKeyList) {
			$conditions = array(
				'is_system' => true,
				'language_id' => Current::read('Language.id'),
				'type' => Role::ROLE_TYPE_ROOM,
				'key' => $this->defaultRoleKeyList
			);
		} else {
			$conditions = array(
				'is_system' => true,
				'language_id' => Current::read('Language.id'),
				'type' => Role::ROLE_TYPE_ROOM,
			);
		}
		$defaultRoles = $controller->Role->find('all', array(
			'recursive' => -1,
			'fields' => array('key', 'name', 'description'),
			'conditions' => $conditions,
			'order' => array('id' => 'asc')
		));
		$controller->set('defaultRoles', Hash::combine($defaultRoles, '{n}.{s}.key', '{n}.{s}'));
		$controller->set(
			'defaultRoleOptions', Hash::combine($defaultRoles, '{n}.{s}.key', '{n}.{s}.name')
		);
	}

/**
 * ルームデータ取得
 *
 * @param int $spaceId スペースID
 * @return void
 */
	public function setRoomsForPaginator($spaceId = null) {
		$controller = $this->controller;

		if (! $spaceId) {
			$getSpaces = [Space::PUBLIC_SPACE_ID, Space::COMMUNITY_SPACE_ID];
		} else {
			$getSpaces = [$spaceId];
		}
		$spaces = $controller->viewVars['spaces'];

		$result = array();
		foreach ($getSpaces as $spaceId) {
			//ルームデータ取得
			$controller->Paginator->settings = $controller->Room->getRoomsConditions(
				$spaceId,
				array('limit' => 1000, 'maxLimit' => 1000)
			);
			$rooms = $controller->Paginator->paginate('Room');
			$rooms = Hash::combine($rooms, '{n}.Room.id', '{n}');
			$roomIds = array_keys($rooms);

			//Treeリスト取得
			$roomTreeList = $controller->Room->generateTreeList(
				array('Room.id' => array_merge(array($spaces[$spaceId]['Room']['id']), $roomIds)),
				null,
				null,
				Room::$treeParser
			);

			$result[$spaceId]['rooms'] = $rooms;
			$result[$spaceId]['roomTreeList'] = $roomTreeList;
		}

		if (count($getSpaces) > 1) {
			$controller->set('rooms', $result);
		} else {
			$controller->set('rooms', $result[$spaceId]['rooms']);
			$controller->set('roomTreeList', $result[$spaceId]['roomTreeList']);
		}
	}

/**
 * ユーザIDが閲覧できるルームデータ取得
 *
 * @param int $userId ユーザID
 * @return void
 */
	public function setReadableRooms($userId = null) {
		$controller = $this->controller;

		//ルームデータ取得
		$options = $controller->Room->getReadableRoomsConditions([], $userId);
		$result = $controller->Room->find('all', $options);
		$controller->set('rooms', Hash::combine($result, '{n}.Room.id', '{n}'));

		//ルームのTreeリスト取得
		$roomTreeLists[Space::PUBLIC_SPACE_ID] = $controller->Room->generateTreeList(
				array('Room.space_id' => Space::PUBLIC_SPACE_ID), null, null, Room::$treeParser);

		$roomTreeLists[Space::COMMUNITY_SPACE_ID] = $controller->Room->generateTreeList(
				array('Room.space_id' => Space::COMMUNITY_SPACE_ID), null, null, Room::$treeParser);
		$controller->set('roomTreeLists', $roomTreeLists);

		//** ロールルームユーザデータ取得
		$rolesRoomsUsers = $controller->RolesRoomsUser->getRolesRoomsUsers(array(
			'RolesRoomsUser.user_id' => $userId,
		));
		$rolesRoomsUsers = Hash::combine(
			$rolesRoomsUsers, '{n}.RolesRoomsUser.room_id', '{n}'
		);
		$controller->set('rolesRoomsUsers', $rolesRoomsUsers);
	}

}
