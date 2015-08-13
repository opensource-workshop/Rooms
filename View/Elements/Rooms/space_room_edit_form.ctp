<?php
/**
 * Space edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<?php echo $this->Form->label('Room.page_layout_permitted', __d('rooms', 'Allow to change page layout?')); ?>
	<br>
	<?php echo $this->Form->radio('Room.page_layout_permitted',
			array(
				'1' => __d('user_roles', 'Permitted'),
				'0' => __d('user_roles', 'Not permitted'),
			),
			array(
				'legend' => false,
				'separator' => '<span class="radio-separator"> </span>',
			)
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->label('DefaultRolePermission.html_not_limited', __d('rooms', 'Allow HTML tags?')); ?>
	<div class="form-inline">
		<?php echo $this->RoomsRolesForm->checkboxRoomRoles('DefaultRolePermission.html_not_limited'); ?>
	</div>
</div>

<div class="form-group">
	<?php echo $this->Form->label('DefaultRolePermission.upload_picture_not_limited', __d('rooms', 'Allow to uploads picture files?')); ?>
	<div class="form-inline">
		<?php echo $this->RoomsRolesForm->checkboxRoomRoles('DefaultRolePermission.upload_picture_not_limited'); ?>
	</div>
</div>

<div class="form-group">
	<?php echo $this->Form->label('DefaultRolePermission.upload_attachment_not_limited', __d('rooms', 'Allow to uploads attachment files?')); ?>
	<div class="form-inline">
		<?php echo $this->RoomsRolesForm->checkboxRoomRoles('DefaultRolePermission.upload_attachment_not_limited'); ?>
	</div>
</div>

<div class="form-group">
	<?php echo $this->Form->label('DefaultRolePermission.upload_video_not_limited', __d('rooms', 'Video files paste from the editor')); ?>
	<div class="form-inline">
		<?php echo $this->RoomsRolesForm->checkboxRoomRoles('DefaultRolePermission.upload_video_not_limited'); ?>
	</div>
</div>
