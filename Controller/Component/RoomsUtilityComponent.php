<?php
/**
 * RoomsUtility Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * RoomsUtility Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class RoomsUtilityComponent extends Component {

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
		$this->controller->Paginator = $this->controller->Components->load('Paginator');

		//Modelの呼び出し
		$this->Room = ClassRegistry::init('Rooms.Room');
		$this->RoomsLanguage = ClassRegistry::init('Rooms.RoomsLanguage');
	}

/**
 * Get rooms data by spaces.id
 *
 * @param int $spaceId spaces.id
 * @param int $spaceRoomId rooms.id
 * @param string $treeSpacer Spacer on tree list
 * @return array Rooms data
 */
	public function getRoomsForPaginator($spaceId, $spaceRoomId, $treeSpacer = null) {
		$result = array();
		if (! isset($treeSpacer)) {
			$treeSpacer = chr(9);
		}

		//ルームデータ取得
		$this->controller->Paginator->settings = array(
			'recursive' => 0,
			'conditions' => array(
				'Room.space_id' => $spaceId,
				'Room.parent_id' => $spaceRoomId,
				'Language.id' => Configure::read('Config.languageId'),
			),
			'order' => 'Room.lft',
		);
		$data = $this->controller->Paginator->paginate('RoomsLanguage');
		$result = Hash::combine($data, '{n}.Room.id', '{n}');

		//子ルームのデータ取得
		$rootRoomIds = array_keys($result);
		foreach ($rootRoomIds as $roomId) {
			//Treeリスト取得
			$roomTreeList = $this->Room->generateTreeList(array('Room.root_id' => $roomId), null, null, $treeSpacer); //$spacer=Tab
			if ($roomTreeList) {
				$children = $this->RoomsLanguage->find('all', array(
					'recursive' => 0,
					'conditions' => array(
						'RoomsLanguage.room_id' => array_keys($roomTreeList),
						'RoomsLanguage.language_id' => Configure::read('Config.languageId')
					),
					'order' => 'Room.lft'
				));
				$result[$roomId]['children'] = Hash::combine($children, '{n}.Room.id', '{n}');
				$result[$roomId]['TreeList'] = $roomTreeList;
			}
		}
		return $result;
	}

/**
 * Get the room data
 *
 * @param int $roomId rooms.id
 * @param int $languageId languages.id
 * @return array Room data
 */
	public function getRoom($roomId, $languageId) {
		if (! $parents = $this->Room->getPath($roomId)) {
			return $parents;
		}
		$result = array_pop($parents);
		$parents[] = $result;

		foreach ($parents as $index => $room) {
			$conditions = array(
				'RoomsLanguage.room_id' => $room['Room']['id'],
			);
			if (isset($languageId)) {
				$conditions['RoomsLanguage.language_id'] = $languageId;
			}
			$ret = $this->RoomsLanguage->find('all', array(
				'recursive' => -1,
				'conditions' => $conditions,
			));
			$roomLang['RoomsLanguage'] = Hash::extract($ret, '{n}.RoomsLanguage');

			if ($result['Room']['id'] === $room['Room']['id']) {
				$result = Hash::merge($result, $roomLang);
			} else {
				$result['Parent'][$index] = $roomLang;
			}
		}
		return $result;
	}

/**
 * Exist the room data
 *
 * @param int $roomId rooms.id
 * @return bool True on success, false on failure
 */
	public function exist($roomId) {
		$this->Room->id = $roomId;
		return $this->Room->exists();
	}

/**
 * Check rooms.id
 *
 * @param int $roomId rooms.id
 * @param int $languageId languages.id
 * @return bool True on success, false on failure
 */
	public function validRoom($roomId, $languageId) {
		//ルームデータチェック
		if ($roomId && ! $this->exist($roomId)) {
			$this->controller->throwBadRequest();
			return;
		}
		//ルームデータセット
		$this->controller->set('activeRoomId', $roomId);

		$room = $this->getRoom($roomId, $languageId);
		$this->controller->set('room', $room);

		$roomNames = Hash::extract($room, 'Parent.{n}.RoomsLanguage.{n}[language_id=' . Configure::read('Config.languageId') . '].name');
		$roomNames = Hash::merge(
			$roomNames,
			Hash::extract($room, 'RoomsLanguage.{n}[language_id=' . Configure::read('Config.languageId') . '].name')
		);
		$this->controller->set('roomNames', $roomNames);

		return true;
	}

}
