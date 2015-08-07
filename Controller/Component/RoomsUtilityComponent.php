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
 * @param string $treeSpacer Spacer on tree list
 * @return array Rooms data
 */
	public function getRoomsForPaginator($spaceId, $treeSpacer = null) {
		$result = array();
		if (! isset($treeSpacer)) {
			$treeSpacer = chr(9);
		}

		//ルームデータ取得
		$this->controller->Paginator->settings = array(
			'recursive' => 0,
			'conditions' => array(
				'Room.space_id' => $spaceId,
				'Room.parent_id' => null,
				'Language.id' => Configure::read('Config.languageId'),
			),
			'order' => 'Room.lft'
		);
		$data = $this->controller->Paginator->paginate('RoomsLanguage');
		$result = Hash::combine($data, '{n}.Room.id', '{n}');

		//子ルームのデータ取得
		$parentRoomIds = array_keys($result);
		foreach ($parentRoomIds as $roomId) {
			//Treeリスト取得
			$roomTreeList = $this->Room->generateTreeList(array('Room.parent_id' => $roomId), null, null, $treeSpacer); //$spacer=Tab
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
 * @return array Room data
 */
	public function get($roomId) {
		static $room = null;

		if (! isset($room)) {
			$room = $this->RoomsLanguage->find('first', array(
				'recursive' => 0,
				'conditions' => array(
					'RoomsLanguage.room_id' => $roomId,
					'RoomsLanguage.language_id' => Configure::read('Config.languageId')
				),
			));
		}
		return $room;
	}

/**
 * Exist the room data
 *
 * @param int $roomId rooms.id
 * @return bool True on success, false on failure
 */
	public function exist($roomId) {
		if (! $this->get($roomId)) {
			return false;
		}
		return true;
	}

}
