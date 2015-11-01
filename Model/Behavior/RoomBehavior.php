<?php
/**
 * Room Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * Room Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Model\Behavior
 */
class RoomBehavior extends ModelBehavior {

/**
 * スペースデータ
 *
 * @var array
 */
	private static $__spaces;

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		parent::setup($model, $config);

		$model->loadModels([
			'Room' => 'Rooms.Room',
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
			'Space' => 'Rooms.Space',
		]);
	}

/**
 * Get rooms data by spaces.id
 *
 * @param Model $model Model ビヘイビア呼び出し元モデル
 * @param int $spaceId SpaceId
 * @return array ルームデータ取得条件
 */
	public function getRoomsCondtions(Model $model, $spaceId, $addConditions = array(), $addJoins = array()) {
		$spaces = $this->getSpaces($model);
		$addOptions = array(
			'conditions' => $addConditions,
			'joins' => $addJoins
		);

		$options = Hash::merge(array(
			//'recursive' => 0,
			'conditions' => array(
				'Room.space_id' => $spaceId,
				'Room.root_id' => $spaces[$spaceId]['Room']['id'],
			),
			'order' => 'Room.lft',
		), $addOptions);

		return $options;
	}

/**
 * スペースデータ取得
 *
 * @return array スペースデータ配列
 */
	public function getSpaces(Model $model) {
		if (self::$__spaces) {
			return self::$__spaces;
		}

		//スペースデータ取得
		$model->Room->unbindModel(array(
			'belongsTo' => array('ParentRoom'),
			'hasMany' => array('ChildRoom')
		));
		$spaces = $model->Room->find('all', array(
			'conditions' => array(
				$model->Room->alias . '.parent_id' => null,
			),
			'order' => 'Room.lft'
		));

		self::$__spaces = Hash::combine($spaces, '{n}.Space.id', '{n}');

		return self::$__spaces;
	}

}
