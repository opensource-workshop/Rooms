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

echo $this->Html->css(
	array(
		'/users/css/style.css',
		'/rooms/css/style.css',
	),
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
?>
<?php echo $this->element('Rooms.subtitle'); ?>

<?php echo $this->element('Rooms.space_tabs'); ?>

<?php echo $this->element('Rooms.room_setting_tabs'); ?>

<?php echo $this->Form->create(null, array('novalidate' => true)); ?>

<div class="user-search-index-head-margin">
	<div class="text-center">
		<a class="btn btn-info" href="<?php echo $this->Html->url('/user_manager/user_manager/search/'); ?>">
			<span class="glyphicon glyphicon-search"></span>
			<?php echo __d('users', 'Search for the members'); ?>
		</a>
	</div>

	<div class="form-group rooms-manager-room-role-select">
		<?php echo $this->UserRoleForm->selectDefaultRoomRoles('Room.role_key', array(
			'empty' => __d('rooms', '(Select room role)'),
			'options' => array('delete' => __d('users', 'Non members'))
		)); ?>
	</div>
</div>

<table class="table table-condensed">
	<thead>
		<tr>
			<th>
				<input type="checkbox">
			</th>
			<?php foreach ($displayFields as $field) : ?>
				<th>
					<?php echo $this->UserValue->label($field); ?>
				</th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $index => $user) : ?>
			<tr>
				<td>
					<input type="checkbox">
				</td>

				<?php $this->UserValue->set($user); ?>

				<?php foreach ($displayFields as $field) : ?>
					<td>
						<?php echo $this->UserValue->display($field); ?>
					</td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('NetCommons.paginator'); ?>

<div class="text-center">
	<a class="btn btn-default btn-workflow" href="<?php echo $this->Html->url('/rooms/' . $space['Space']['default_setting_action']); ?>">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Close'); ?>
	</a>
</div>

<?php echo $this->Form->end();
