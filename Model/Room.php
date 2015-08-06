<?php
App::uses('AppModel', 'Model');
/**
 * Room Model
 *
 * @property Group $Group
 * @property Space $Space
 * @property Block $Block
 * @property Box $Box
 * @property Frame $Frame
 * @property Page $Page
 * @property File $File
 * @property Plugin $Plugin
 * @property Role $Role
 */
class Room extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Space' => array(
			'className' => 'Space',
			'foreignKey' => 'space_id',
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
		'Block' => array(
			'className' => 'Block',
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
		'Box' => array(
			'className' => 'Box',
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
		'Frame' => array(
			'className' => 'Frame',
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
		'Page' => array(
			'className' => 'Page',
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
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'File' => array(
			'className' => 'File',
			'joinTable' => 'files_rooms',
			'foreignKey' => 'room_id',
			'associationForeignKey' => 'file_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Plugin' => array(
			'className' => 'PluginManagers.Plugin',
			'joinTable' => 'plugins_rooms',
			'foreignKey' => 'room_id',
			'associationForeignKey' => 'plugin_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Role' => array(
			'className' => 'Role',
			'joinTable' => 'roles_rooms',
			'foreignKey' => 'room_id',
			'associationForeignKey' => 'role_id',
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
