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
?>

<div class="form-group">
	<?php echo $this->Form->checkbox('Room.default_participation', array(
			'div' => false,
			'disabled' => $defaultParticipationFixed
		)); ?>

	<?php echo $this->Form->label(
			'Room.default_participation',
			__d('rooms', 'Open for all members')
		); ?>
</div>

<div class="form-group">
	<div>
		<?php echo $this->Form->label('Room.need_approval', __d('rooms', 'Approval settings of content')); ?>
	</div>
	<div>
		<?php echo $this->Form->radio('Room.need_approval', array('1' => __d('rooms', 'Authority to publish approved content'))); ?>
	</div>

	<div class="form-inline">
		<div class="form-group checkbox-separator"></div>
		<?php echo $this->RoomsRolesForm->checkboxRoomRoles('RoomRolePermission.content_publishable', array('inline' => true)); ?>
	</div>

	<div>
		<?php echo $this->Form->radio('Room.need_approval', array('0' => __d('rooms', 'Do not use the approval'))); ?>
	</div>
</div>

<div class="form-inline form-group">
	<?php echo $this->Form->label('Room.active', __d('rooms', 'Status')); ?>

	<?php echo $this->Form->select('Room.active',
			array(
				'0' => __d('rooms', 'Under maintenance'),
				'1' => __d('rooms', 'Open'),
			),
			array(
				'class' => 'form-control',
				'empty' => false
			)
		); ?>
</div>
