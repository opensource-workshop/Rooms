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

<?php echo $this->element('Rooms.space_tabs'); ?>

<?php echo $this->element('Rooms.room_setting_tabs'); ?>

<br>

<div class="panel panel-default">
	<?php echo $this->Form->create(null, array('novalidate' => true)); ?>

	<?php echo $this->Form->hidden('Room.id'); ?>

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
				$this->NetCommonsHtml->url('/rooms/' . $space['Space']['default_setting_action'])
			); ?>
	</div>

	<?php echo $this->Form->end(); ?>
</div>
