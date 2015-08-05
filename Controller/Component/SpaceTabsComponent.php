<?php
/**
 * UserAttributeLayouts Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * UserAttributeLayouts Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller
 */
class SpaceTabsComponent extends Component {

/**
 * startup
 *
 * @param Controller $controller Controller
 * @return void
 */
	public function startup(Controller $controller) {
		//RequestActionの場合、スキップする
		if (! empty($controller->request->params['requested'])) {
			return;
		}
		$this->controller = $controller;

		//Modelの呼び出し
		$this->Space = ClassRegistry::init('Rooms.Space');
		$this->SpacesLanguage = ClassRegistry::init('Rooms.SpacesLanguage');

		//スペースデータ取得
		$spaces = $this->SpacesLanguage->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'Space.parent_id' => Space::WHOLE_SITE_ID,
				'SpacesLanguage.language_id' => Configure::read('Config.languageId')
			),
			'order' => 'Space.lft'
		));
		$this->controller->set('spaces', $spaces);
	}

/**
 * startup
 *
 * @param int $spaceId spaces.id
 * @return bool True on success, false on failure
 */
	public function check($spaceId) {
		if (! Hash::check($this->controller->viewVars['spaces'], '{n}.Space[id=' . $spaceId . ']')) {
			$this->controller->throwBadRequest();
			return false;
		}
		return true;
	}

}
