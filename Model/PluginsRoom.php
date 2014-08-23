<?php
/**
 * PluginsRoom Model
 *
 * @author      Noriko Arai <arai@nii.ac.jp>
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link        http://www.netcommons.org NetCommons Project
 * @license     http://www.netcommons.org/license.txt NetCommons License
 * @copyright   Copyright 2014, NetCommons Project
 * @package     app.Plugin.PluginRoomManager.Model
 */

App::uses('AppModel', 'Model');

/**
 * PluginsRoom Model
 *
 * @author      Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package     app.Plugin.PluginRoomManager.Model
 */
class PluginsRoom extends AppModel {

/**
 * constant value for frame
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 */
	const PLUGIN_TYPE_FOR_FRAME = '1';

/**
 * composer.json file name
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     string
 */
	public $composerJsonName = 'composer.json';

/**
 * Validation rules
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $validate = array(
		'role_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'plugin_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * belongsTo associations
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $belongsTo = array(
		'Plugin' => array(
			'className' => 'Plugin',
			'foreignKey' => 'plugin_id',
		),
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
		),
	);

/**
 * hasMany associations
 *
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @var     array
 */
	public $hasMany = array(
		'LanguagesPlugin' => array(
			'className' => 'LanguagesPlugin',
			'foreignKey' => 'plugin_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

/**
 * Get plugin data from type and roomId, $langId
 *
 * @param int $roomId rooms.id
 * @param int $langId languages.id
 * @author  Shohei Nakajima <nakajimashouhei@gmail.com>
 * @return  mixed array or false
 */
	public function getPlugins($roomId, $langId) {
		//ルームIDのセット
		$roomId = (int)$roomId;
		//言語IDのセット
		$langId = (int)$langId;

		if (! $roomId) {
			return false;
		}

		//plugins_languagesテーブルの取得
		$this->hasMany['LanguagesPlugin']['conditions'] = array(
			'LanguagesPlugin.language_id' => $langId
		);

		//pluginsテーブルの取得
		$plugins = $this->find('all', array(
			'conditions' => array(
				'Plugin.type' => $this::PLUGIN_TYPE_FOR_FRAME,
				'Room.id' => $roomId
			),
			'order' => $this->name . '.id',
		));

		return $plugins;
	}
}
