<?php
/**
 * RoomsHtml Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * RoomsHtml Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Controller\Component
 */
class RoomsHtmlComponent extends Component {

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
//		$this->controller = $controller;
//		$this->controller->Paginator = $this->controller->Components->load('Paginator');

		//Modelの呼び出し
//		$this->Room = ClassRegistry::init('Rooms.Room');
//		$this->RoomsLanguage = ClassRegistry::init('Rooms.RoomsLanguage');
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::startup
 */
	public function startup(Controller $controller) {
		//スペースデータ取得＆viewVarsにセット
		$spaces = $controller->Room->getSpaces();
//		var_dump($spaces);
//		$controller->set('spaces', Hash::combine($spaces, '{n}.Space.id', '{n}'));
		$controller->set('spaces', $spaces);
	}

}
