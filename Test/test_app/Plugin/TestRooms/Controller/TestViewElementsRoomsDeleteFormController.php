<?php
/**
 * View/Elements/Rooms/delete_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/Rooms/delete_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\test_app\Plugin\TestRooms\Controller
 */
class TestViewElementsRoomsDeleteFormController extends AppController {

/**
 * delete_form
 *
 * @return void
 */
	public function delete_form() {
		$this->autoRender = true;
		$this->set('activeSpaceId', '2');
		$this->set('activeRoomId', '7');

		$this->request->data['Room']['id'] = '7';

		$this->request->params['plugin'] = 'rooms';
		$this->request->params['controller'] = 'rooms';
	}

}
