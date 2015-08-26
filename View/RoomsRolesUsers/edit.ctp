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
?>
<?php echo $this->element('Rooms.subtitle'); ?>

<?php echo $this->element('Rooms.space_tabs'); ?>

<?php echo $this->element('Rooms.room_setting_tabs'); ?>

<?php echo $this->Form->create(null, array('novalidate' => true)); ?>


<div class="text-center">
	<a class="btn btn-default btn-workflow" href="<?php echo $this->Html->url('/rooms/' . $space['Space']['default_setting_action']); ?>">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Close'); ?>
	</a>
</div>

<?php echo $this->Form->end();
