<?php
/**
 * View/Elements/Rooms/edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/Rooms/edit_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\test_app\Plugin\TestRooms\Controller
 */
class TestViewElementsRoomsEditFormController extends AppController {

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
		'M17n.SwitchLanguage',
		'NetCommons.Permission' => array(
			'type' => PermissionComponent::CHECK_TYPE_SYSTEM_PLUGIN,
			'allow' => array()
		),
		'Rooms.Rooms',
		'Rooms.RoomsRolesForm' => array(
			'permissions' => array('content_publishable', 'html_not_limited')
		),
	);

/**
 * use helper
 *
 * @var array
 */
	public $helpers = array(
		'Rooms.RoomsForm',
	);

/**
 * edit_form
 *
 * @param int $roomId ルームID
 * @return void
 */
	public function edit_form($roomId) {
		$this->autoRender = true;

		$this->request->data = $this->Room->findById($roomId);

		$this->RoomsRolesForm->settings['room_id'] = $roomId;
		$this->RoomsRolesForm->settings['type'] = DefaultRolePermission::TYPE_ROOM_ROLE;

		if ($roomId === '7') {
			$this->set('activeSpaceId', '4');
			$this->set('participationFixed', false);
		} else {
			$this->set('activeSpaceId', '2');
			$this->set('participationFixed', true);
		}
	}

}
