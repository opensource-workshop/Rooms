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
<?php echo $this->Wizard->navibar(RoomsAppController::WIZARD_ROOMS_ROLES_USERS); ?>
<?php echo $this->MessageFlash->description(__d('rooms',
		'Please set the role of the members in this room. After changing the role of the member, it will be registered. <br>' .
		'When selecting the plug-ins to be used, please press the [Next]. If you want to exit this screen, please press the [Cancel].'
	)); ?>

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

				<?php echo $this->UserSearch->tableHeaders(); ?>

				<th>
					<?php echo $this->Paginator->sort('RoomRole.level', __d('rooms', 'Room role')); ?>
				</th>
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

					<?php echo $this->UserSearch->tableRow($user, false); ?>

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
						<div class="pull-left">&nbsp;</div>
						<div>
							<?php echo $this->Button->cancel(__d('users', 'Non members'), null, array(
									'class' => 'btn btn-default btn-sm',
									'ng-click' => 'delete(' . $user['User']['id'] . ', \'' . $domUserRoleKey . '\');',
									'ng-disabled' => '!' . $domUserRoleKey
								)); ?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php echo $this->element('NetCommons.paginator'); ?>

	<div class="text-center">
		<?php echo $this->Wizard->buttons(
				RoomsAppController::WIZARD_ROOMS_ROLES_USERS,
				array(),
				array(),
				array('url' => $this->Wizard->naviUrl(RoomsAppController::WIZARD_PLUGINS_ROOMS))
			); ?>
	</div>

<?php echo $this->Form->end();
