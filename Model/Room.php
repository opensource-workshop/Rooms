<?php
/**
 * Room Model
 *
 * @property Space $Space
 * @property Room $ParentRoom
 * @property Room $ChildRoom
 * @property Language $Language
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomsAppModel', 'Rooms.Model');

/**
 * Room Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Model
 */
class Room extends RoomsAppModel {

/**
 * room id
 *
 * @var const
 */
	const
		PUBLIC_PARENT_ID = '1',
		PRIVATE_PARENT_ID = '2',
		ROOM_PARENT_ID = '3';

/**
 * TreeParser
 * __constructでセットする
 *
 * @var array
 */
	public static $treeParser;

/**
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'Rooms.DeleteRoomAssociations',
		'Rooms.Room',
		'Rooms.SaveRoomAssociations',
		'Tree',
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Space' => array(
			'className' => 'Rooms.Space',
			'foreignKey' => 'space_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentRoom' => array(
			'className' => 'Rooms.Room',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildRoom' => array(
			'className' => 'Rooms.Room',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RoomsLanguage' => array(
			'className' => 'Rooms.RoomsLanguage',
			'foreignKey' => 'room_id',
			'dependent' => false,
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
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		self::$treeParser = chr(9);
	}

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		//RoomsLanguageのバリデーション
		$roomsLanguages = $this->data['RoomsLanguage'];
		if (! $this->RoomsLanguage->validateMany($roomsLanguages)) {
			$this->validationErrors = Hash::merge(
				$this->validationErrors,
				$this->RoomsLanguage->validationErrors
			);
			return false;
		}

		return parent::beforeValidate($options);
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @throws InternalErrorException
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		//RoomsLanguage登録
		if (isset($this->data['RoomsLanguage'])) {
			$roomsLanguages = Hash::insert($this->data['RoomsLanguage'], '{n}.room_id', $this->data['Room']['id']);
			foreach ($roomsLanguages as $index => $roomsLanguage) {
				if (! $result = $this->RoomsLanguage->save($roomsLanguage, false, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
				$this->data['RoomsLanguage'][$index] = $result;
			}
		}

		//デフォルトデータ登録処理
		$room = $this->data;
		if ($created) {
			$this->saveDefaultRolesRoom($room);
			$this->saveDefaultRolesRoomsUsers($room);
			$this->saveDefaultRolesPluginsRoom($room);
			$this->saveDefaultRoomRolePermissions($room);
			$this->saveDefaultPage($room);
		}

		parent::afterSave($created, $options);
	}

/**
 * Save Room
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveRoom($data) {
		$this->loadModels([
			'Room' => 'Rooms.Room',
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//登録処理
			if (! $room = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return $room;
	}

/**
 * validate of Room
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
//	public function validateRoom($data) {
//		$this->set($data);
//		$this->validates();
//		if ($this->validationErrors) {
//			return false;
//		}
//		return true;
//	}

/**
 * Save Room
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function deleteRoom($data) {
		$this->loadModels([
			'Room' => 'Rooms.Room',
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
		]);

		//トランザクションBegin
		$this->begin();

//		$children = $this->Room->children($data['Room']['id'], false, 'Room.id', 'Room.rght');
//		$roomIds = Hash::extract($children, '{n}.Room.id');
//		$roomIds[] = $data['Room']['id'];
//
		try {
//			foreach ($roomIds as $roomId) {
//				//プラグインデータの削除
//				$this->deletePluginByRoom($roomId);
//
//				//frameデータの削除
//				$this->deleteFramesByRoom($roomId);
//
//				//pageデータの削除
//				$this->deletePagesByRoom($roomId);
//
//				//Roomデータの削除
//				if (! $this->delete($roomId, false)) {
//					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//				}
//
//				//Roomの関連データの削除
//				$this->deleteRoomAssociations($roomId);
//			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * Return readable rooms
 * 検索、新着で使っている＞＞＞後で削除
 *
 * @param array $conditions conditions.
 * @return array
 */
	//public function getReadableRooms($conditions = []) {
	//	$room = [
	//		0 => [
	//			'Room' => [
	//				'id' => 1
	//			],
	//			'Page' => [
	//				'id' => 1
	//			],
	//			'LanguagesPage' => [
	//				'id' => 1,
	//				'name' => '2000年度入学者',
	//			],
	//		],
	//		1 => [
	//			'Room' => [
	//				'id' => 2
	//			],
	//			'Page' => [
	//				'id' => 2
	//			],
	//			'LanguagesPage' => [
	//				'id' => 2,
	//				'name' => '2001年度入学者',
	//			],
	//		],
	//	];
	//
	//	return $room;
	//}
}
