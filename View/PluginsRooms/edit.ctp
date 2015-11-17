<?php
/**
 * PluginsRooms edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/plugin_manager/css/style.css');
?>

<?php echo $this->element('Rooms.subtitle'); ?>
<?php echo $this->Rooms->spaceTabs($activeSpaceId); ?>
<?php echo $this->RoomForm->settingTabs(); ?>

<div class="panel panel-default">
	<?php echo $this->NetCommonsForm->create('Room'); ?>
	<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>

	<div class="panel-body">
		<div class="form-inline">
			<div class="clearfix">
				<?php echo $this->PluginsForm->checkboxPluginsRoom(
						array('class' => 'pull-left plugin-checkbox-separator')); ?>
			</div>
		</div>
	</div>

	<div class="panel-footer text-center">
		<?php echo $this->Button->cancelAndSave(
				__d('net_commons', 'Cancel'),
				__d('net_commons', 'OK'),
				$this->NetCommonsHtml->url('/rooms/' . $spaces[$activeSpaceId]['Space']['default_setting_action'])
			); ?>
	</div>

	<?php echo $this->NetCommonsForm->end(); ?>
</div>
