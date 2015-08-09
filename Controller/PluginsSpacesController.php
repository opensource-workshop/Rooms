<?php
/**
 * PluginsSpaces Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppController', 'Rooms.Controller');

/**
 * PluginsSpaces Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class PluginsSpacesController extends RoomsAppController {

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
		'Rooms.SpacesUtility',
	);

/**
 * use helper
 *
 * @var array
 */
	public $helpers = array(
		'PluginManager.PluginsForm',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit($spaceId = null) {
		//スペースデータチェック＆セット
		if (! $this->SpacesUtility->validSpace($spaceId)) {
			return;
		}

		if ($this->request->isPost()) {
			$data = $this->data;

			//不要パラメータ除去
			unset($data['save']);
		}
	}

}
