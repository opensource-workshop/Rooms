<?php
/**
 * Rooms Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * ルーム表示ヘルパー
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttribute\View\Helper
 */
class RoomFormHelper extends AppHelper {

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * ルーム設定タブの出力
 *
 * @return string HTML
 */
	public function settingTabs() {
		$activeSpaceId = $this->_View->viewVars['activeSpaceId'];
		if (isset($this->_View->viewVars['activeRoomId'])) {
			$activeRoomId = $this->_View->viewVars['activeRoomId'];
		} else {
			$activeRoomId = null;
		}

		$output = '';
		if ($this->_View->params['action'] === 'add') {
			$disabled = 'disabled';
			$urlRooms = '';
			$urlRolesRoomsUsers = '';
			$urlPluginsRooms = '';
		} else {
			$disabled = '';
			$urlRooms = '/rooms/rooms/' . $this->_View->params['action'] . '/' . h($activeSpaceId) . '/' . h($activeRoomId) . '/';
			$urlRolesRoomsUsers = '/rooms/rooms_roles_users/edit/' . h($activeSpaceId) . '/' . h($activeRoomId) . '/';
			$urlPluginsRooms = '/rooms/plugins_rooms/edit/' . h($activeSpaceId) . '/' . h($activeRoomId) . '/';
		}

		$output .= '<ul class="nav nav-pills" role="tablist">';
		if ($this->_View->params['controller'] === 'rooms') {
			$class = 'active';
		} else {
			$class = $disabled;
		}
		$output .= '<li class="' . $class . '">';
		$output .= $this->NetCommonsHtml->link(__d('rooms', 'General setting'), $urlRooms);
		$output .= '</li>';

		if (Hash::get($this->_View->request->data, 'Room.id') !== Room::ROOM_PARENT_ID) {
			if ($this->_View->params['controller'] === 'rooms_roles_users') {
				$class = 'active';
			} else {
				$class = $disabled;
			}
			$output .= '<li class="' . $class . '">';
			$output .= $this->NetCommonsHtml->link(__d('rooms', 'Edit the members to join'), $urlRolesRoomsUsers);
			$output .= '</li>';
		}

		if (isset($this->_View->request->data['Room']['parent_id'])) {
			if ($this->_View->params['controller'] === 'plugins_rooms') {
				$class = 'active';
			} else {
				$class = $disabled;
			}
			$output .= '<li class=' . $class . '>';
			$output .= $this->NetCommonsHtml->link(__d('rooms', 'Select the plugins to join'), $urlPluginsRooms);
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '<br>';

		return $output;
	}

/**
 * 状態の変更
 *
 * @param array $room ルームデータ配列
 * @return string HTML
 */
	public function changeStatus($room) {
		$this->_View->request->data = $room;
		$output = '';

		$output .= $this->NetCommonsForm->create('Room', array(
			'url' => $this->NetCommonsHtml->url(array(
				'action' => 'active', $room['Space']['id'], $room['Room']['id']
			)),
		));

		$output .= $this->NetCommonsForm->hidden('Room.id');
		if ($room['Room']['active']) {
			$output .= $this->NetCommonsForm->hidden('Room.active', array('value' => false));
			$output .= $this->NetCommonsForm->button(__d('rooms', 'It will be in maintenance'), array(
				'name' => 'save',
				'class' => 'btn-link',
				'ng-disabled' => 'sending'
			));
		} else {
			$output .= $this->NetCommonsForm->hidden('Room.active', array('value' => true));
			$output .= $this->NetCommonsForm->button(__d('rooms', 'Open the room'), array(
				'name' => 'save',
				'class' => 'btn-link',
				'ng-disabled' => 'sending'
			));
		}
		$output .= $this->NetCommonsForm->end();

		return $output;
	}

}