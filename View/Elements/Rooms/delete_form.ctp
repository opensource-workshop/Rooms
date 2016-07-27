<?php
/**
 * Element of delete form
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="nc-danger-zone" ng-init="dangerZone=false;">
	<?php echo $this->NetCommonsForm->create('Room', array('type' => 'delete',
			'url' => array('action' => 'delete', $activeSpaceId, $activeRoomId)
		)); ?>

		<uib-accordion close-others="false">
			<div uib-accordion-group is-open="dangerZone" class="panel-danger">
				<uib-accordion-heading class="clearfix">
					<span style="cursor: pointer">
						<?php echo __d('net_commons', 'Danger Zone'); ?>
					</span>
					<span class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': dangerZone, 'glyphicon-chevron-right': ! dangerZone}"></span>
				</uib-accordion-heading>

				<div class="pull-left">
					<?php echo sprintf(__d('net_commons', 'Delete all data associated with the %s.'), __d('rooms', 'Room')); ?>
				</div>

				<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>
				<?php echo $this->Button->delete(
						__d('net_commons', 'Delete'),
						sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('rooms', 'Room')),
						array('addClass' => 'pull-right')
					); ?>
			</div>
		</uib-accordion>
	<?php echo $this->NetCommonsForm->end(); ?>
</div>
