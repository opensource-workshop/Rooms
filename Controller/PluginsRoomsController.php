<?php
/**
 * PluginsRooms Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppController', 'Rooms.Controller');

/**
 * PluginsRooms Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class PluginsRoomsController extends RoomsAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
//		'Rooms.RoomsLanguage',
//		'Rooms.Room',
//		'Rooms.Space',
//		'Rooms.SpacesLanguage',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		'Rooms.RoomsUtility',
		'Rooms.SpaceTabs',
	);

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
		}

		$this->set('activeSpaceId', $this->request->data['Room']['space_id']);
		$this->set('activeRoomId', $roomId);
	}

}
