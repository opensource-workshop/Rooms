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
		'Rooms.Space'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout'
	);

/**
 * index
 *
 * @return void
 */
	public function index($spaceId = null) {
//		$ret = $this->Space->find('all', array(
//			//'recursive' => 0,
//		));
//var_dump($ret);
//		$spaceTreeList = $this->Space->generateTreeList(null, null, null, chr(9)); //$spacer=Tab
//
//var_dump($spaceTreeList);
//		foreach ($spaceTreeList as $space) {
//			var_dump(preg_match('/^' . chr(9) . '/', $space));
//		}

		$ret = $this->Space->children(1);
		var_dump($ret);
	}

}
