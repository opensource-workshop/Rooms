<?php
/**
 * RoomsApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * RoomsApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class RoomsAppController extends AppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Rooms.Room',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		'NetCommons.Permission' => array(
			'type' => PermissionComponent::CHECK_TYEP_SYSTEM_PLUGIN,
			'allow' => array()
		),
		'Rooms.Rooms',
		'Security',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Rooms.RoomForm',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index', 'view');

		//スペースデータチェック
		$spaceId = $this->params['pass'][0];
		if ($this->Room->Space->exists($spaceId)) {
			$this->set('activeSpaceId', $spaceId);

			//ルームデータチェック＆セット
			if ($this->params['action'] !== 'index') {
				if ($this->request->isPost() && $this->params['controller'] === 'rooms') {
					$roomId = $this->data['Room']['parent_id'];
				} elseif ($this->request->isPost() || $this->request->isPut() || $this->request->isDelete()) {
					$roomId = $this->data['Room']['id'];
				} else {
					$roomId = $this->params['pass'][1];
				}
				$room = $this->Room->findById($roomId);
				if (! $room) {
					$this->setAction('throwBadRequest');
					return;
				}
				$this->set('room', $room);
				$this->set('activeRoomId', $roomId);
				$this->set('activeSpaceId', $room['Space']['id']);

				$parentRooms = $this->Room->getPath($roomId, null, 1);
				$this->set('parentRooms', $parentRooms);
			}

		} else {
			$this->setAction('throwBadRequest');
		}
	}

}
