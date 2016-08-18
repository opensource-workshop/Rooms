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

$roomsRolesUsers = $this->Session->read('RoomsRolesUsers');
?>

<div class="form-group form-inline rooms-roles-form">

	<?php
		if ($room['Room']['space_id'] === Space::PUBLIC_SPACE_ID) {
			$options = array(
				__d('rooms', 'Room role') => $defaultRoleOptions,
			);
		} else {
			$options = array(
				__d('rooms', 'Room role') => $defaultRoleOptions,
				'----------------------------------' => array(
					'delete' => __d('users', 'Non members')
				)
			);
		}

		echo $this->RoomsRolesForm->selectDefaultRoomRoles('Role.key', array(
			'empty' => __d('rooms', 'Change the user role of the room'),
			'options' => $options,
			'optionFormat' => __d('rooms', 'Changed to the %s role'),
			'onchange' => 'submit();',
			'ng-class' => 'sending',
			'ng-model' => 'RoomEditForm',
			'ng-change' => 'sending=true;',
		));
	?>
</div>

<div class="table-responsive">
	<table class="table rooms-roles-users-table">
		<thead>
			<tr>
				<th class="text-center rooms-roles-users-checkbox">
					<label>
						<input type="checkbox" ng-click="allCheck($event)">
					</label>
				</th>

				<?php echo $this->UserSearch->tableHeaders(); ?>

				<th class="room-roles-desc">
					<?php echo $this->Paginator->sort('room_role_level', __d('rooms', 'Room role')); ?>
					<?php echo $this->RoomsRolesForm->roomRolesDescription(); ?>
				</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($users as $index => $user) : ?>
				<?php
					$appendData = array(
						'RolesRoomsUser' => array(
							'user_id' => $user['User']['id'],
							'role_key' => Hash::get($user, 'RolesRoom.role_key', '')
						),
					);
					$domUserId = $this->NetCommonsForm->domId('RolesRoomsUser.' . $user['User']['id'] . '.user_id');
					$domUserRoleKey = $this->NetCommonsForm->domId('RolesRoom.' . $user['User']['id'] . '.role_key');
					$domUserIdLabel = $this->NetCommonsForm->domId('User.id.' . $user['User']['id']);
					$ngInit = '';
					$ngClick = $domUserId . '=!' . $domUserId . '; check(\'' . $domUserId . '\', ' . $domUserId . ');'
				?>
				<tr ng-init="<?php echo $ngInit; ?>"
					ng-class="{active: <?php echo $domUserId; ?>}">
					<td class="text-center rooms-roles-users-checkbox">
						<?php
							echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.id');
							echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.user_id',
								array('value' => $user['User']['id'])
							);
							echo $this->NetCommonsForm->hidden('RolesRoomsUser.' . $user['User']['id'] . '.room_id',
								array('value' => $this->data['Room']['id'])
							);

							echo '<label for="' . $domUserIdLabel . '">';
							echo $this->NetCommonsForm->checkbox('User.id.' . $user['User']['id'], array(
								'label' => false,
								'div' => false,
								'type' => 'checkbox',
								'ng-checked' => $domUserId,
								'ng-click' => $ngClick,
								'ng-disabled' => 'sending',
								//'inline' => true,
							));
							echo '</label>';
						?>
					</td>

					<?php echo $this->UserSearch->tableRow($user, false, [], ['ng-click' => $ngClick]); ?>

					<?php
						$orgRoleKey = Hash::get($user, 'RolesRoom.role_key', '');
						if (isset($roomsRolesUsers[$user['User']['id']])) {
							$roleKey = $roomsRolesUsers[$user['User']['id']]['role_key'];
						} else {
							$roleKey = $orgRoleKey;
						}
					?>
					<td class="rooms-roles-form"
							ng-init="<?php echo $domUserRoleKey . ' = \'' . $roleKey . '\';'; ?>">

						<div class="pull-left" ng-class="{'bg-success': <?php echo $domUserRoleKey; ?>}" ng-cloak>
							<?php
								if ($room['Room']['space_id'] === Space::PUBLIC_SPACE_ID) {
									$options = array(
										__d('rooms', 'Room role') => $defaultRoleOptions,
									);
								} else {
									$options = array(
										__d('rooms', 'Room role') => $defaultRoleOptions,
										'-----------------------' => array(
											'' => __d('users', 'Non members')
										)
									);
								}
								echo $this->RoomsRolesForm->selectDefaultRoomRoles('RolesRoom.' . $user['User']['id'] . '.role_key', array(
									'class' => 'form-control input-sm',
									'ng-model' => $domUserRoleKey,
									'ng-change' => 'save(' . $user['User']['id'] . ', \'' . $domUserRoleKey . '\')',
									'options' => $options,
									'ng-class' => '{disabled: sending}'
								));
							?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php echo $this->element('NetCommons.paginator');
