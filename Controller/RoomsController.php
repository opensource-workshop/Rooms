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
		'Rooms.SpaceTabs',
		'Paginator',
	);

/**
 * index
 *
 * @return void
 */
	public function index($spaceId = null) {
		//スペースデータチェック
		if (! $this->SpaceTabs->check($spaceId)) {
			return;
		}
		$this->set('activeSpaceId', $spaceId);

		//ルームデータ取得
		$this->Paginator->settings = array(
			'recursive' => 0,
			'conditions' => array(
				'Room.space_id' => $spaceId,
				'Room.parent_id' => null,
				'Language.id' => Configure::read('Config.languageId'),
			),
			'order' => 'Room.lft'
		);
		$data = $this->Paginator->paginate('RoomsLanguage');
		$this->request->data = Hash::combine($data, '{n}.Room.id', '{n}');

		//子ルームのデータ取得
		$parentRoomIds = array_keys($this->request->data);
		foreach ($parentRoomIds as $roomId) {
			//Treeリスト取得
			$roomTreeList = $this->Room->generateTreeList(array('Room.parent_id' => $roomId), null, null, chr(9)); //$spacer=Tab
			if ($roomTreeList) {
				$conditions = array(
					'Room.id' => array_keys($roomTreeList),
					'Language.id' => Configure::read('Config.languageId')
				);
				$this->request->data[$roomId]['children'] = $this->RoomsLanguage->find('all', array(
					'recursive' => 0,
					'conditions' => $conditions,
					'order' => 'Room.lft'
				));
				$this->request->data[$roomId]['TreeList'] = $roomTreeList;
			}
		}
	}

}
