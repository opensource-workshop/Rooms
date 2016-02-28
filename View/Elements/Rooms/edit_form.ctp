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

<?php
	if ($participationFixed) {
		echo $this->NetCommonsForm->hidden('Room.default_participation');
	}
	echo $this->NetCommonsForm->inlineCheckbox('Room.default_participation', array(
		'label' => __d('rooms', 'Open for all members'),
		'disabled' => $participationFixed,
	));
?>

<div class="form-group">
	<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('Room.default_role_key', array(
			'label' => array('label' => __d('rooms', 'Default room role'))
		)); ?>
</div>

<div class="form-group">
	<?php
		$options = array('1' => __d('rooms', 'Authority to publish approved content'));
		echo $this->NetCommonsHtml->div(array(), $this->NetCommonsForm->radio('Room.need_approval', $options));

		echo $this->RoomsRolesForm->checkboxRoomRoles(
			'RoomRolePermission.content_publishable',
			array('outerDiv' => false)
		);

		$options = array('0' => __d('rooms', 'Do not use the approval'));
		echo $this->NetCommonsHtml->div(array(), $this->NetCommonsForm->radio('Room.need_approval', $options));
	?>
</div>

<?php echo $this->RoomsRolesForm->checkboxRoomRoles('RoomRolePermission.html_not_limited', array(
		'label' => __d('rooms', 'Allow HTML tags?  e.g.) Javascript or iframe')
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

