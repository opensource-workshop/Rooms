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
class RoomsHelper extends AppHelper {

/**
 * ルーム名のナビゲータの区切り文字
 *
 * @var const
 */
	const ROOM_NAME_PAUSE = ' / ';

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
 * After render file callback.
 * Called after any view fragment is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The file just be rendered.
 * @param string $content The content that was rendered.
 * @return void
 */
	public function afterRenderFile($viewFile, $content) {
		$content = $this->NetCommonsHtml->css('/rooms/css/style.css') . $content;
		parent::afterRenderFile($viewFile, $content);
	}

/**
 * ルームナビの出力
 *
 * @param int $activeSpaceId スペースID
 * @return string HTML
 */
	public function roomsNavi($activeSpaceId) {
		$output = '';

		if (isset($this->_View->viewVars['parentRooms'])) {
			$pathName = '{n}.RoomsLanguage.{n}[language_id=' . Current::read('Language.id') . '].name';
			$roomNames = Hash::extract($this->_View->viewVars['parentRooms'], $pathName);
		}

		if (isset($roomNames)) {
			$element = implode(self::ROOM_NAME_PAUSE, array_map('h', $roomNames));
		} else {
			$element = $this->roomName($this->_View->viewVars['spaces'][$activeSpaceId]);
		}
		if ($this->_View->request->params['action'] === 'add') {
			if (! $this->_View->viewVars['room']['Room']['parent_id']) {
				$element .= self::ROOM_NAME_PAUSE .
						'<span class="glyphicon glyphicon-plus"></span>' . __d('rooms', 'Add new room');
			} else {
				$element .= self::ROOM_NAME_PAUSE .
						'<span class="glyphicon glyphicon-plus"></span>' . __d('rooms', 'Add new subroom');
			}
		}
		$output .= $this->NetCommonsHtml->div(array(
			'text-muted', 'small',
			'visible-xs-inline-block', 'visible-sm-inline-block', 'visible-md-inline-block', 'visible-lg-inline-block'
		), $element);

		return '(' . $output . ')';
	}

/**
 * タブの出力
 *
 * @param int $activeSpaceId スペースID
 * @param bool $tabType タブの種類（tabs or pills）
 * @param string|null $urls URLオプション
 * @return string HTML
 */
	public function spaceTabs($activeSpaceId, $tabType = 'tabs', $urls = null) {
		$output = '';
		$output .= '<ul class="nav nav-' . $tabType . '" role="tablist">';
		foreach ($this->_View->viewVars['spaces'] as $space) {
			if ($space['Space']['default_setting_action']) {
				$output .= '<li class="' . ($space['Space']['id'] === $activeSpaceId ? 'active' : '') . '">';

				$attributes = array();
				if (! isset($urls)) {
					$url = '/rooms/' . $space['Space']['default_setting_action'];
				} elseif (is_string($urls)) {
					$url = sprintf($urls, (int)$space['Space']['id']);
				} elseif (isset($urls[$space['Space']['id']])) {
					$url = Hash::get($urls[$space['Space']['id']], 'url');
					$attributes = (array)Hash::get($urls[$space['Space']['id']], 'attributes');
				}
				$output .= $this->NetCommonsHtml->link($this->roomName($space), $url, $attributes);
				$output .= '</li>';
			}
		}
		$output .= '</ul>';
		$output .= '<br>';

		return $output;
	}

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
 * ルーム一覧の出力
 *
 * @param int $activeSpaceId スペースID
 * @param string $dataElementPath データ表示エレメント
 * @param string|null $headElementPath ヘッダ表示エレメント
 * @param array|null $roomTreeList ルームのTreeリスト
 * @param bool $paginator ページネーションの有無
 * @return string HTML
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function roomsRender($activeSpaceId, $dataElementPath, $headElementPath = null, $roomTreeList = null, $paginator = true) {
		$output = '';

		if (! isset($roomTreeList)) {
			$roomTreeList = Hash::get($this->_View->viewVars, 'roomTreeList');
		}

		$output .= $this->_View->element('Rooms.Rooms/render_index', array(
			'headElementPath' => $headElementPath,
			'dataElementPath' => $dataElementPath,
			'roomTreeList' => $roomTreeList,
			'space' => $this->_View->viewVars['spaces'][$activeSpaceId],
			'paginator' => $paginator
		));

		return $output;
	}

/**
 * ルーム名の出力
 *
 * @param array $room ルームデータ配列
 * @param int|null $nest インデント
 * @return string HTML
 */
	public function roomName($room, $nest = null) {
		$roomsLanguage = Hash::extract(
			$room,
			'RoomsLanguage.{n}[language_id=' . Current::read('Language.id') . ']'
		);

		$output = '';
		if (isset($nest)) {
			$output .= str_repeat('<span class="rooms-tree"> </span>', $nest);
		}
		$output .= h($roomsLanguage[0]['name']);
		return $output;
	}

/**
 * 状態によるCSSのクラス定義を返す
 *
 * @param array $room ルームデータ配列
 * @param string|null $prefix CSSクラスのプレフィックス
 * @return string HTML
 */
	public function statusCss($room, $prefix = '') {
		$output = '';
		if (! $room['Room']['active']) {
			$output .= $prefix . 'danger';
		}
		return $output;
	}

/**
 * 状態のラベルを出力
 *
 * @param array $room ルームデータ配列
 * @param string $messageFormat メッセージフォーマット
 * @param bool $displayActive アクティブの表示有無
 * @return string HTML
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function statusLabel($room, $messageFormat = '%s', $displayActive = false) {
		$output = '';

		if (! $room['Room']['active']) {
			$output .= ' ' . __d('rooms', sprintf($messageFormat, 'Under maintenance'));
		} elseif ($displayActive) {
			$output .= ' ' . __d('rooms', sprintf($messageFormat, 'Open'));
		}
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

/**
 * ルームロール名の出力
 *
 * @param string $roomRoleKey ルームロールKey
 * @return string HTML
 */
	public function roomRoleName($roomRoleKey) {
		if (is_array($roomRoleKey)) {
			if (isset($roomRoleKey['RolesRoom']['role_key'])) {
				$roomRoleKey = $roomRoleKey['RolesRoom']['role_key'];
			} else {
				$roomRoleKey = '';
			}
		}
		if (isset($this->_View->viewVars['defaultRoles'][$roomRoleKey])) {
			return h($this->_View->viewVars['defaultRoles'][$roomRoleKey]);
		} else {
			return '';
		}
	}

}
