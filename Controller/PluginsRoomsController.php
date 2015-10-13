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
		//'Rooms.RoomsLanguage',
		//'Rooms.Room',
		//'Rooms.Space',
		//'Rooms.SpacesLanguage',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		'PluginManager.PluginsForm',
		'Rooms.RoomsUtility',
		'Rooms.SpacesUtility',
	);

/**
 * edit
 *
 * @param int $roomId rooms.id
 * @return void
 */
	public function edit($roomId = null) {
		//登録処理の場合、URLよりPOSTパラメータでチェックする
		if ($this->request->isPost()) {
			$roomId = $this->data['Room']['id'];
		}
		//ルームデータチェック＆セット
		if (! $this->RoomsUtility->validRoom($roomId, Configure::read('Config.languageId'))) {
			return;
		}
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($this->viewVars['room']['Room']['space_id'])) {
			return;
		}

		if ($this->request->isPost()) {
			//登録処理
			$data = $this->data;

			//--不要パラメータ除去
			unset($data['save']);

			$this->request->data = $data;
		} else {
			$this->request->data = $this->viewVars['room'];
		}
	}

}
