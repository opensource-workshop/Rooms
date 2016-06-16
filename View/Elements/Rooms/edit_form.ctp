<?php
/**
 * Room edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

	foreach ($this->request->data['RoomsLanguage'] as $index => $roomLanguage) {
		$languageId = $roomLanguage['language_id'];
		if (isset($languages[$languageId])) {
			echo '<div id="rooms-rooms-' . $languageId . '" ' .
						'class="tab-pane' . ($activeLangId === (string)$languageId ? ' active' : '') . '">';

			echo $this->NetCommonsForm->hidden('RoomsLanguage.' . $index . '.id');
			echo $this->NetCommonsForm->hidden('RoomsLanguage.' . $index . '.room_id');
			echo $this->NetCommonsForm->hidden('RoomsLanguage.' . $index . '.language_id');
			echo $this->NetCommonsForm->input('RoomsLanguage.' . $index . '.name', array(
				'type' => 'text',
				'label' => $this->SwitchLanguage->inputLabel(__d('rooms', 'Room name'), $languageId),
				'required' => true,
				//'disabled' => ! (bool)$this->data['Room']['parent_id']
			));

			echo '</div>';
		}
	}
?>

<?php echo $this->RoomsForm->inputDefaultParticipation(); ?>

<div class="form-group">
	<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('Room.default_role_key', array(
			'label' => array('label' => __d('rooms', 'Default room role')),
			'options' => $defaultRoles
		)); ?>
</div>

<?php
	echo $this->NetCommonsForm->input('Room.need_approval', array(
		'type' => 'radio',
		'options' => array(
			'1' => __d('rooms', 'Authority to publish approved content'),
			'0' => __d('rooms', 'Do not use the approval')
		),
		'label' => __d('rooms', 'Approved content?'),
		'help' => __d('rooms', 'Even if you no need, you can have the approval functions in each block.')
	));
?>

<?php echo $this->RoomsRolesForm->checkboxRoomRoles('RoomRolePermission.content_publishable', array(
		'label' => __d('rooms', 'Allow publish approved content'),
	)); ?>

<?php echo $this->RoomsRolesForm->checkboxRoomRoles('RoomRolePermission.html_not_limited', array(
		'label' => __d('rooms', 'Allow all html tags?  e.g.) Javascript or iframe'),
		'help' => '<span class="text-warning">' .
				'<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> ' .
				__d('rooms', 'If you allow Javascript, etc., there is a possibility that cause of vulnerability') .
			'</span>',
	)); ?>

<div class="form-inline form-group">
	<?php echo $this->NetCommonsForm->input('Room.active', array(
			'type' => 'select',
			'label' => __d('rooms', 'Status'),
			'options' => array(
				'0' => __d('rooms', 'Under maintenance'),
				'1' => __d('rooms', 'Open'),
			),
			'value' => (int)Hash::get($this->data, 'Room.active'),
			'between' => ' ',
			'disabled' => ! (bool)$this->data['Room']['parent_id']
		)); ?>
</div>

