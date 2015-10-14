<?php
/**
 * Rooms edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/rooms/css/style.css');
?>

<?php echo $this->element('Rooms.subtitle'); ?>

<?php echo $this->element('Rooms.space_tabs'); ?>

<?php echo $this->element('Rooms.room_setting_tabs'); ?>

<br>

<div class="panel panel-default">
	<?php echo $this->Form->create(null, array('novalidate' => true)); ?>

	<div class="panel-body">
		<?php echo $this->SwitchLanguage->tablist('rooms-rooms-'); ?>

		<div class="tab-content">

			<?php echo $this->Form->hidden('Room.id'); ?>
			<?php echo $this->Form->hidden('Room.space_id'); ?>
			<?php echo $this->Form->hidden('Room.root_id'); ?>
			<?php echo $this->Form->hidden('Room.parent_id'); ?>
			<?php echo $this->Form->hidden('Page.parent_id'); ?>

			<?php echo $this->element('Rooms/edit_form'); ?>
		</div>
	</div>

	<div class="panel-footer text-center">
		<a class="btn btn-default btn-workflow" href="<?php echo $this->NetCommonsHtml->url('/rooms/' . $space['Space']['default_setting_action']); ?>">
			<span class="glyphicon glyphicon-remove"></span>
			<?php echo __d('net_commons', 'Cancel'); ?>
		</a>

		<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save',
			)); ?>
	</div>

	<?php echo $this->Form->end(); ?>
</div>

<?php if (isset($this->data['Room']['parent_id']) && $this->request->params['action'] === 'edit') : ?>
	<?php echo $this->element('Rooms/delete_form'); ?>
<?php endif;
