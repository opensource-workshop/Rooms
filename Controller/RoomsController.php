<?php
/**
 * Rooms Controller
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppController', 'Rooms.Controller');

/**
 * Rooms Controller
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     Rooms\Controller
 */
class RoomsController extends RoomsAppController {

/**
 * use model
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       array
 */
	//public $uses = array();

/**
 * use component
 *
 * @author    Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var       array
 */
	public $components = array(
		'Security'
	);

/**
 * beforeFilter
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * index
 *
 * @author   Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return   CakeResponse
 */
	public function index() {
		return $this->render('Rooms/index');
	}

}
