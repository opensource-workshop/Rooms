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
			'RolesRoom' => 'Rooms.RolesRoom',
			'Room' => 'Rooms.Room',
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
			'Space' => 'Rooms.Space',
		]);
	}

/**
 * ルームデータ取得用の条件取得
 *
 * @param Model $model ビヘイビア呼び出し元モデル
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
 * @param Model $model ビヘイビア呼び出し元モデル
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

/**
 * ロールルームデータの取得
 *
 * @param Model $model ビヘイビア呼び出し元モデル
 * @param array $conditions 条件配列
 * @return array
 */
	public function getRolesRooms(Model $model, $conditions = array()) {
		$conditions = Hash::merge(array(
			'Room.page_id_top NOT' => null,
		), $conditions);

		$rolesRoomsUsers = $model->RolesRoom->find('all', array(
			'recursive' => 0,
			'fields' => array(
				$model->RolesRoom->alias . '.*',
				$model->Room->alias . '.*',
			),
			'conditions' => $conditions,
		));

		return $rolesRoomsUsers;
	}

}
