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

<div class="form-group form-inline rooms-roles-form">
	<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('Role.key', array(
		'empty' => __d('rooms', 'Change the user role of the room'),
		'options' => array(
			__d('rooms', 'Room role') => $defaultRoles,
			'----------------------------------' => array('delete' => __d('users', 'Non members'))
		),
		'optionFormat' => __d('rooms', 'Changed to the %s role'),
		'onchange' => 'submit();',
		'ng-disabled' => 'sending',
		'ng-model' => 'RoomEditForm',
		'ng-change' => 'sending=true;'
	)); ?>
</div>

<div class="table-responsive">
	<table class="table table-condensed rooms-roles-users-table">
		<thead>
			<tr>
				<th>
					<input class="rooms-roles-users-checkbox" type="checkbox" ng-click="allCheck($event)">
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
						<?php echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.user_id',
									array('value' => $user['User']['id'])
							); ?>
						<?php echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.room_id',
									array('value' => $this->data['Room']['id'])
							); ?>
						<?php echo $this->NetCommonsForm->checkbox('User.id.' . $user['User']['id'], array(
							'label' => false,
							'div' => false,
							'type' => 'checkbox',
							'checked' => false,
							'class' => 'rooms-roles-users-checkbox',
							'ng-click' => 'check($event)',
							'ng-disabled' => 'sending',
							'inline' => true,
						)); ?>
					</td>

					<?php echo $this->UserSearch->tableRow($user, false); ?>

					<td class="rooms-roles-form"
							ng-init="<?php echo $domUserRoleKey . ' = \'' . Hash::get($user, 'RolesRoom.role_key', '') . '\';'; ?>">

						<div class="pull-left" ng-class="{'bg-success': <?php echo $domUserRoleKey; ?>}">
							<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('RolesRoom.' . $user['User']['id'] . '.role_key', array(
								'value' => Hash::get($user, 'RolesRoom.role_key', ''),
								'class' => 'form-control input-sm',
								'ng-model' => $domUserRoleKey,
								'ng-change' => 'save(' . $user['User']['id'] . ', \'' . $domUserRoleKey . '\')',
								'options' => array(
									__d('rooms', 'Room role') => $defaultRoles,
									'-----------------------' => array(
										'' => __d('users', 'Non members')
									)
								),
								'ng-disabled' => 'sending'
							)); ?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php echo $this->element('NetCommons.paginator');