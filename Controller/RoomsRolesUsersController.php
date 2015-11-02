<?php
/**
 * RoomsUsers Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppController', 'Rooms.Controller');

/**
 * RoomsUsers Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class RoomsRolesUsersController extends RoomsAppController {

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
		'UserAttributes.UserAttributeLayout',
		'UserRoles.UserRoleForm',
		'Users.UserSearch',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Users.UserSearch',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//ルームデータチェック
		$room = $this->viewVars['room'];

		//登録処理
		if ($this->request->isPost()) {

		}

		$this->UserSearch->search();
		$this->request->data = $room;
	}
}
