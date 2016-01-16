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
echo $this->NetCommonsHtml->script('/rooms/js/rooms_roles_users.js');
?>
<?php echo $this->element('NetCommons.javascript_alert'); ?>

<?php echo $this->element('Rooms.subtitle'); ?>
<?php echo $this->Rooms->spaceTabs($activeSpaceId); ?>
<?php echo $this->RoomForm->settingTabs(); ?>

<?php echo $this->NetCommonsForm->create('Room', array(
		'ng-controller' => 'RoomsRolesUsers',
		'ng-init' => 'initialize(' . json_encode(array(
						'Room' => array('id' => Hash::get($this->data, 'Room.id')),
						'Role' => array('key' => '')), JSON_FORCE_OBJECT) .
					',  \'RoomEditForm\');',
	)); ?>
	<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>

	<div class="user-search-index-head-margin">
		<?php echo $this->UserSearchForm->displaySearchButton(array($activeSpaceId, $this->data['Room']['id'])); ?>

		<div class="form-group form-inline">
			<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('Role.key', array(
				'empty' => __d('rooms', 'Change the user role of the room'),
				'options' => array('delete' => __d('users', 'Non members')),
				'optionFormat' => __d('rooms', 'Changed to the %s role'),
				'onchange' => 'submit();'
			)); ?>
		</div>
	</div>

	<table class="table table-condensed">
		<thead>
			<tr>
				<th>
					<input class="form-control rooms-roles-users-checkbox" type="checkbox" ng-click="allCheck($event)">
				</th>
				<th>
					<?php echo $this->Paginator->sort('RoomRole.level', __d('rooms', 'Room role')); ?>
				</th>
				<th class="rooms-roles-users-separator"> </th>
				<?php echo $this->UserSearch->tableHeaders(); ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($users as $index => $user) : ?>
				<?php
					$appendData = array(
						'User' => array(
							'id' => array($user['User']['id'] => '0')
						),
						'RolesRoom' => array(
							$user['User']['id'] => array(
								'role_key' => Hash::get($user, 'RolesRoom.role_key', '')
							)
						),
						'RolesRoomsUser' => array(
							$user['User']['id'] => array(
								'id' => Hash::get($this->request->data, 'RolesRoomsUser.' . $user['User']['id'] . '.id', ''),
								'user_id' => $user['User']['id'],
								'room_id' => Hash::get($this->request->data, 'Room.id', ''),
							),
						),
					);
					$domUserId = $this->NetCommonsForm->domId('RolesRoomsUser.' . $user['User']['id'] . '.user_id');
					$domUserRoleKey = $this->NetCommonsForm->domId('RolesRoom.' . $user['User']['id'] . '.role_key');
				?>
				<tr ng-init="appendUser(<?php echo h(json_encode($appendData, JSON_FORCE_OBJECT)); ?>);"
					ng-class="{active: <?php echo $domUserId; ?>}">
					<td>
						<?php echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.id'); ?>
						<?php echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.user_id', array('value' => $user['User']['id'])); ?>
						<?php echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.room_id', array('value' => $this->data['Room']['id'])); ?>
						<?php echo $this->NetCommonsForm->input('User.id.' . $user['User']['id'], array(
							'label' => false,
							'div' => false,
							'type' => 'checkbox',
							'checked' => false,
							'class' => 'form-control rooms-roles-users-checkbox',
							'ng-click' => 'check($event)',
						)); ?>
					</td>
					<td>
						<div class="pull-left">
							<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('RolesRoom.' . $user['User']['id'] . '.role_key', array(
								'empty' => '',
								'value' => Hash::get($user, 'RolesRoom.role_key', ''),
								'class' => 'form-control input-sm',
								'ng-init' => $domUserRoleKey . ' = \'' . Hash::get($user, 'RolesRoom.role_key', '') . '\';',
								'ng-model' => $domUserRoleKey,
								'ng-change' => 'save(' . $user['User']['id'] . ', \'' . $domUserRoleKey . '\')'
							)); ?>
						</div>
						<div>
							<?php echo $this->Button->cancel(__d('users', 'Non members'), null, array(
									'iconSize' => 'sm',
									'ng-click' => 'delete(' . $user['User']['id'] . ', \'' . $domUserRoleKey . '\');',
									'ng-disabled' => '!' . $domUserRoleKey
								)); ?>
						</div>

						<?php //echo $this->UserSearch->tableCell($user, 'RolesRoom', 'room_role_key', false, false); ?>
					</td>
					<td class="rooms-roles-users-separator"> </td>
					<?php echo $this->UserSearch->tableRow($user, false); ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php echo $this->element('NetCommons.paginator'); ?>

	<div class="text-center">
		<?php echo $this->Button->cancel(__d('net_commons', 'Close'),
				$this->NetCommonsHtml->url('/rooms/' . $spaces[$activeSpaceId]['Space']['default_setting_action'])); ?>
	</div>

<?php echo $this->Form->end();
