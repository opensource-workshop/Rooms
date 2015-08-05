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
class SpacesController extends RoomsAppController {

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
		'Rooms.SpaceTabs',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit($spaceId = null) {
		//スペースデータチェック
		if (! $this->SpaceTabs->check($spaceId)) {
			return;
		}
		$this->set('activeSpaceId', $spaceId);


	}

}
