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
 * Behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'Rooms.DeleteRoomAssociations',
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
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Language' => array(
			'className' => 'M17n.Language',
			'joinTable' => 'rooms_languages',
			'foreignKey' => 'room_id',
			'associationForeignKey' => 'language_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

/**
 * Save Room
 *
 * @param array $data received post data
 * @param bool $created True is created(add action), false is updated(edit action)
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveRoom($data, $created) {
		$this->loadModels([
			'Room' => 'Rooms.Room',
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		//バリデーション
		if (! $this->validateRoom($data['Room'])) {
			return false;
		}
		$roomsLanguages = $data['RoomsLanguage'];
		if (! $this->RoomsLanguage->validateMany($roomsLanguages)) {
			$this->validationErrors = Hash::merge($this->validationErrors, $this->RoomsLanguage->validationErrors);
			return false;
		}

		try {
			//登録処理
			$room['Page'] = $data['Page'];

			//Roomデータの登録
			if (! $ret = $this->save($data['Room'], false, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$room = Hash::merge($room, $ret);

			//RoomsLanguageデータの登録
			$data = Hash::insert($data, 'RoomsLanguage.{n}.room_id', $room['Room']['id']);
			foreach ($data['RoomsLanguage'] as $index => $roomsLanguage) {
				if (! $ret = $this->RoomsLanguage->save($roomsLanguage, false, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
				$room['RoomsLanguage'][$index] = Hash::extract($ret, 'RoomsLanguage');
			}

			//デフォルトデータ登録処理
			if ($created) {
				$this->saveDefaultRolesRoom($room);
				$this->saveDefaultRolesRoomsUsers($room);
				$this->saveDefaultRolesPluginsRoom($room);
				$this->saveDefaultRoomRolePermissions($room);
				$this->saveDefaultPage($room);
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return $room;
	}

/**
 * validate of Room
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
	public function validateRoom($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

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
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		$children = $this->Room->children($data['Room']['id'], false, 'Room.id', 'Room.rght');
		$roomIds = Hash::extract($children, '{n}.Room.id');
		$roomIds[] = $data['Room']['id'];

		try {
			foreach ($roomIds as $roomId) {
				//プラグインデータの削除
				$this->deletePluginByRoom($roomId);

				//frameデータの削除
				$this->deleteFramesByRoom($roomId);

				//pageデータの削除
				$this->deletePagesByRoom($roomId);

				//Roomデータの削除
				if (! $this->delete($roomId, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}

				//Roomの関連データの削除
				$this->deleteRoomAssociations($roomId);
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Return readable rooms
 *
 * @param array $conditions conditions.
 * @return array
 */
	public function getReadableRooms($conditions = []) {
		$room = [
			0 => [
				'Room' => [
					'id' => 1
				],
				'Page' => [
					'id' => 1
				],
				'LanguagesPage' => [
					'id' => 1,
					'name' => '2000年度入学者',
				],
			],
			1 => [
				'Room' => [
					'id' => 2
				],
				'Page' => [
					'id' => 2
				],
				'LanguagesPage' => [
					'id' => 2,
					'name' => '2001年度入学者',
				],
			],
		];

		return $room;
	}
}
