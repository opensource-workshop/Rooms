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
	echo $this->Rooms->spaceTabs($activeSpaceId);
	echo $this->element('Rooms.subtitle');
	echo $this->RoomsForm->settingTabs();
	echo $this->MessageFlash->description(__d('rooms',
		'Please set the role of the members in this room. After changing the role of the member, it will be registered. <br>' .
		'For you add new participants to the room, please search for the subject from the [Search for the members], and add.'
	));
?>

<?php
	$ajaxAction = $this->NetCommonsHtml->url(array(
		'action' => 'role_room_user',
		'key' => Hash::get($this->data, 'Room.space_id'),
		'key2' => Hash::get($this->data, 'Room.id')
	));

	echo $this->NetCommonsForm->create('Room', array(
		'ng-controller' => 'RoomsRolesUsers',
		'ng-init' => 'initialize(\'' . $ajaxAction . '\');',
	));

	echo $this->NetCommonsForm->hidden('Room.id');

	echo $this->UserSearchForm->displaySearchButton(
		__d('rooms', 'Search for the members'), array($activeSpaceId, $room['Room']['id'])
	);
?>

<?php echo $this->element('Rooms.RoomsRolesUsers/edit_form'); ?>

<div class="text-center">
	<?php
		echo $this->Button->cancelAndSave(
			__d('net_commons', 'Cancel'),
			__d('net_commons', 'OK'),
			'/rooms/' . $spaces[$activeSpaceId]['Space']['default_setting_action']
		);
	?>
</div>

<?php
	//タイムゾーン関係を含めたくないため、FormHelperを使う
	echo $this->Form->end();