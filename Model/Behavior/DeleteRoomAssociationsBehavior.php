<?php
/**
 * DeleteRoomAssociations Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * DeleteRoomAssociations Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Model\Behavior
 */
class DeleteRoomAssociationsBehavior extends ModelBehavior {

/**
 * Delete room association
 *
 * @param Model $model Model using this behavior
 * @param int $roomId rooms.id
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function deleteRoomAssociations(Model $model, $roomId) {
		$modelsByRoomId = [
			'RoomsLanguage' => 'Rooms.RoomsLanguage',
			'RolesRoom' => 'Rooms.RolesRoom',
		];
		$modelsByRolesRoomId = [
			'RolesRoomsUser' => 'Rooms.RolesRoomsUser',
			'RoomRolePermission' => 'Rooms.RoomRolePermission',
		];
		$model->loadModels(Hash::merge($modelsByRolesRoomId, $modelsByRoomId));

		$rolesRoomIds = $model->RolesRoom->find('list', array(
			'recursive' => -1,
			'conditions' => array(
				$model->RolesRoom->alias . '.room_id' => $roomId,
			),
		));
		$rolesRoomIds = array_keys($rolesRoomIds);

		//外部キーがroom_idのデータを削除
		foreach (array_keys($modelsByRoomId) as $assocModel) {
			$conditions = array(
				$model->$assocModel->alias . '.room_id' => $roomId
			);
			if (! $model->$assocModel->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//外部キーがrole_room_idのデータを削除
		foreach (array_keys($modelsByRolesRoomId) as $assocModel) {
			$conditions = array(
				$model->$assocModel->alias . '.roles_room_id' => $rolesRoomIds
			);
			if (! $model->$assocModel->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * Delete page data by room id
 *
 * @param Model $model Model using this behavior
 * @param int $roomId rooms.id
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function deletePagesByRoom(Model $model, $roomId) {
		$model->loadModels([
			'Page' => 'Pages.Page',
		]);

		$pageIds = $model->Page->find('list', array(
			'recursive' => -1,
			'conditions' => array(
				$model->Page->alias . '.room_id' => $roomId,
			),
		));
		$pageIds = array_keys($pageIds);

		foreach ($pageIds as $pageId) {
			$page = array(
				'Page' => array('id' => $pageId)
			);
			$model->Page->deletePage($page, array('atomic' => false));
		}

		return true;
	}

/**
 * Delete frame data by room id
 *
 * @param Model $model Model using this behavior
 * @param int $roomId rooms.id
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function deleteFramesByRoom(Model $model, $roomId) {
		//後で処理を入れる。削除するテーブルをピックアップする
		$model->loadModels([]);

		return (bool)$roomId;
		//return true;
	}

/**
 * Delete plugin data by room id
 *
 * @param Model $model Model using this behavior
 * @param int $roomId rooms.id
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function deletePluginByRoom(Model $model, $roomId) {
		$model->loadModels([]);

		return (bool)$roomId;
		//return true;
	}
}
