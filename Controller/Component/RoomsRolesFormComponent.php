<?php
/**
 * RoomsRolesForm Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * RoomsRolesForm Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class RoomsRolesFormComponent extends Component {

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsRoomRole'
	);

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::startup
 */
	public function startup(Controller $controller) {
		//RequestActionの場合、スキップする
		if (! empty($controller->request->params['requested'])) {
			return;
		}
		$this->controller = $controller;
		$this->controller->helpers[] = 'Rooms.RoomsRolesForm';

		$this->DefaultRolePermission = ClassRegistry::init('Roles.DefaultRolePermission');
	}

/**
 * Called before the Controller::beforeRender(), and before
 * the view class is loaded, and before Controller::render()
 *
 * @param Controller $controller Controller with components to beforeRender
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::beforeRender
 */
	public function beforeRender(Controller $controller) {
		//RequestActionの場合、スキップする
		if (! empty($controller->request->params['requested'])) {
			return;
		}
		$this->controller = $controller;

		//RoomRolePermissionデータセット
		if (isset($this->settings['room_id'])) {
			$roomId = $this->settings['room_id'];
		} else {
			$roomId = null;
		}
		if (isset($this->settings['type'])) {
			$type = $this->settings['type'];
		} else {
			$type = null;
		}

		if (isset($this->settings['permissions'])) {
			$results = $this->NetCommonsRoomRole->getRoomRolePermissions($roomId, $this->settings['permissions'], $type);
			$defaultPermissions = Hash::remove($results['DefaultRolePermission'], '{s}.{s}.id');
			$results['RoomRolePermission'] = Hash::merge($defaultPermissions, $results['RoomRolePermission']);

			$this->controller->request->data = Hash::merge($this->controller->request->data, $results);
		}
	}

}