<?php
/**
 * PluginsSpaces edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->Html->css(
	array(
		'/plugin_manager/css/style.css'
	),
	array('plugin' => false)
);
?>

<?php echo $this->element('Rooms.space_tabs'); ?>

<?php echo $this->element('Rooms.space_setting_tabs'); ?>


<div class="panel panel-default">
	<?php echo $this->Form->create(null, array('novalidate' => true)); ?>

	<div class="panel-body">
		<div class="form-inline">
			<div class="clearfix">
				<?php echo $this->PluginsForm->checkboxPluginsSpace('Plugin.key', $activeSpaceId, array('all' => true,
						'class' => 'pull-left plugin-checkbox-separator'
					)); ?>
			</div>
		</div>
	</div>

	<div class="panel-footer text-center">
		<a class="btn btn-default btn-workflow" href="<?php echo $this->Html->url('/rooms/' . $space['Space']['default_setting_action']); ?>">
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
