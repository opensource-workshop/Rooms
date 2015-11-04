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

echo $this->NetCommonsHtml->css('/users/css/style.css');
?>

<?php echo $this->element('Rooms.subtitle'); ?>
<?php echo $this->Rooms->spaceTabs($activeSpaceId); ?>
<?php echo $this->Rooms->settingTabs(); ?>

<?php echo $this->NetCommonsForm->create(null); ?>

<div class="user-search-index-head-margin">
	<div class="text-center">
		<?php echo $this->Button->searchLink(__d('users', 'Search for the members'),
				array('plugin' => 'user_manager', 'controller' => 'user_manager', 'action' => 'search')); ?>
	</div>

	<div class="form-group rooms-room-role-select">
		<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('Room.role_key', array(
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
			<th>
				<?php echo __d('rooms', 'Room role'); ?>
			</th>
			<?php echo $this->UserSearch->tableHeaders(); ?>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($users as $index => $user) : ?>
			<tr>
				<td>
					<input type="checkbox">
				</td>
				<td>

				</td>
				<?php echo $this->UserSearch->tableRow($user, false); ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('NetCommons.paginator'); ?>

<div class="text-center">
	<a class="btn btn-default btn-workflow" href="<?php echo $this->NetCommonsHtml->url('/rooms/' . $spaces[$activeSpaceId]['Space']['default_setting_action']); ?>">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Close'); ?>
	</a>
</div>

<?php echo $this->Form->end();
