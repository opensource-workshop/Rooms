<?php
/**
 * SpacesUtility Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * SpacesUtility Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class SpacesUtilityComponent extends Component {

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::startup
 */
	public function startup(Controller $controller) {
		$this->controller = $controller;

		//Modelの呼び出し
		$this->Space = ClassRegistry::init('Rooms.Space');
		$this->Room = ClassRegistry::init('Rooms.Room');
		$this->RoomsLanguage = ClassRegistry::init('Rooms.RoomsLanguage');

		//スペースデータ取得
		$spaces = $this->Room->find('all', array(
			'recursive' => -1,
			'fields' => '*',
			'joins' => array(
				array(
					'table' => $this->Space->table,
					'alias' => $this->Space->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Room->alias . '.space_id' . ' = ' . $this->Space->alias . ' .id',
						$this->Room->alias . '.parent_id' => null,
					),
				),
				array(
					'table' => $this->RoomsLanguage->table,
					'alias' => $this->RoomsLanguage->alias,
					'type' => 'LEFT',
					'conditions' => array(
						$this->Room->alias . '.id' . ' = ' . $this->RoomsLanguage->alias . ' .room_id',
						$this->RoomsLanguage->alias . '.language_id' => Configure::read('Config.languageId')
					),
				)
			),
			'order' => 'Room.lft'
		));

		$data = Hash::combine($spaces, '{n}.Space.id', '{n}');
		$this->controller->set('spaces', $data);
	}

/**
 * Exist the space
 *
 * @param int $spaceId spaces.id
 * @return bool True on success, false on failure
 */
	public function exist($spaceId) {
		if (! Hash::check($this->controller->viewVars['spaces'], '{n}.Space[id=' . $spaceId . ']')) {
			return false;
		}
		return true;
	}

/**
 * Get the space
 *
 * @param int $spaceId spaces.id
 * @return array space data
 */
	public function get($spaceId) {
		return $this->controller->viewVars['spaces'][$spaceId];
	}

/**
 * Check space.id
 *
 * @param int $spaceId spaces.id
 * @return bool True on success, false on failure
 */
	public function validSpace($spaceId) {
		//スペースデータチェック＆セット
		if (! $this->exist($spaceId)) {
			$this->controller->throwBadRequest();
			return false;
		}

		//スペースデータセット
		$this->controller->set('activeSpaceId', $spaceId);
		$space = $this->get($spaceId);
		$this->controller->set('space', $space);
		$this->controller->set('spaceName', $space['RoomsLanguage']['name']);

		return true;
	}

}
