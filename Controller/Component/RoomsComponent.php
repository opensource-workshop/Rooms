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
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		$controller->Paginator = $controller->Components->load('Paginator');

		//Modelの呼び出し
		$controller->Room = ClassRegistry::init('Rooms.Room');

		$this->controller = $controller;
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::startup
 */
	public function startup(Controller $controller) {
		//スペースデータ取得＆viewVarsにセット
		$spaces = $controller->Room->getSpaces();
		$controller->set('spaces', $spaces);
		$controller->helpers[] = 'Rooms.Rooms';
	}

/**
 * ルームデータ取得
 *
 * @param int $spaceId スペースID
 * @return void
 */
	public function setRoomsForPaginator($spaceId) {
		$controller = $this->controller;

		//ルームデータ取得
		$controller->Paginator->settings = $controller->Room->getRoomsCondtions($spaceId);
		$rooms = $controller->Paginator->paginate('Room');
		$rooms = Hash::combine($rooms, '{n}.Room.id', '{n}');
		$controller->set('rooms', $rooms);

		//Treeリスト取得
		$roomTreeList = $controller->Room->generateTreeList(
				array('Room.id' => array_keys($rooms)), null, null, Room::$treeParser);
		$controller->set('roomTreeList', $roomTreeList);
	}

}
