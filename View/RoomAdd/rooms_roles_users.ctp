<?php
/**
 * RolesRoomUsers edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

	echo $this->NetCommonsHtml->css('/users/css/style.css');
	echo $this->NetCommonsHtml->script('/rooms/js/rooms_roles_users.js');
	echo $this->element('NetCommons.javascript_alert');
?>

<?php
	echo $this->Rooms->spaceTabs($activeSpaceId, 'tabs', false);
	echo $this->Wizard->navibar(RoomsAppController::WIZARD_ROOMS_ROLES_USERS);
	echo $this->element('Rooms.subtitle');
	echo $this->MessageFlash->description(__d('rooms',
		'Please set the role of the members in this room. When selecting the plug-ins to be used, please press the [Next].<br>' .
		'For you add new participants to the room, please search for the subject from the [Search for the members], and add.'
	));
?>

<?php
	$jsonEncode = json_encode(
		array(
			'Room' => array('id' => Hash::get($this->data, 'Room.id')),
			'Role' => array('key' => '')
		),
		JSON_FORCE_OBJECT
	);

	echo $this->NetCommonsForm->create('Room', array(
		'ng-controller' => 'RoomsRolesUsers',
		'ng-init' => 'initialize(' . $jsonEncode . ',  \'RoomRoomsRolesUsersForm\');',
	));

	echo $this->NetCommonsForm->hidden('Room.id');

	echo $this->UserSearchForm->displaySearchButton(
		__d('rooms', 'Search for the members'), array($activeSpaceId, $room['Room']['parent_id'])
	);
?>

<?php echo $this->element('Rooms.RoomsRolesUsers/edit_form'); ?>

<div class="text-center">
	<?php echo $this->Wizard->buttons(
			RoomsAppController::WIZARD_ROOMS_ROLES_USERS,
			array(),
			array(),
			array('url' => $this->Wizard->naviUrl(RoomsAppController::WIZARD_PLUGINS_ROOMS))
		); ?>
</div>

<?php
	//タイムゾーン関係を含めたくないため、FormHelperを使う
	echo $this->Form->end();