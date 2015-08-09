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

<?php foreach ($this->request->data['SpacesLanguage'] as $index => $spaceLanguage) : ?>
	<?php $languageId = $spaceLanguage['language_id']; ?>

	<?php if (isset($languages[$languageId])) : ?>
		<div id="rooms-space-<?php echo $languageId; ?>"
				class="tab-pane<?php echo ($activeLangId === (string)$languageId ? ' active' : ''); ?>">

			<?php echo $this->Form->hidden('SpacesLanguage.' . $index . '.id'); ?>

			<?php echo $this->Form->hidden('SpacesLanguage.' . $index . '.space_id'); ?>

			<?php echo $this->Form->hidden('SpacesLanguage.' . $index . '.language_id'); ?>

			<div class="form-group">
				<?php echo $this->Form->input('SpacesLanguage.' . $index . '.name', array(
						'type' => 'text',
						'label' => __d('rooms', 'Space name') . $this->element('NetCommons.required'),
						'class' => 'form-control',
					)); ?>

				<?php echo $this->element(
					'NetCommons.errors', [
						'errors' => $this->validationErrors,
						'model' => 'SpacesLanguage',
						'field' => 'name',
					]); ?>
			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>

<div class="form-group">
	<?php echo $this->Form->label('Space.page_layout_permitted', __d('rooms', 'Allow to change page layout?')); ?>
	<br>
	<?php echo $this->Form->radio('Space.page_layout_permitted',
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
