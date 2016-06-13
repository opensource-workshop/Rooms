<?php
/**
 * Rooms index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<tr class="<?php echo $this->Rooms->statusCss($room); ?>">
	<td>
		<a href="" ng-click="showRoom(<?php echo $room['Space']['id'] . ', ' . $room['Room']['id']; ?>)">
			<?php echo $this->Rooms->roomName($room, $nest); ?>
		</a>
	</td>

	<td>
		<?php echo $this->Button->editLink('',
				array(
					'action' => 'edit',
					'key' => $room['Space']['id'],
					'key2' => $room['Room']['id']
				),
				array('iconSize' => 'btn-xs')
			); ?>
	</td>

	<td>
		<?php
			echo $this->RoomForm->changeStatus($room);
		?>
	</td>

	<td>
		<?php echo $this->DisplayUser->handleLink($room, array('avatar' => true)); ?>
	</td>
	<td>
		<?php echo $this->Rooms->roomMembers(Hash::get($rolesRoomsUsers, $room['Room']['id']), $room['Room']['id']); ?>
	</td>
	<td>
		<?php echo $this->Button->editLink(__d('rooms', 'Edit the members'),
				array(
					'controller' => 'rooms_roles_users',
					'action' => 'edit',
					'key' => $room['Space']['id'],
					'key2' => $room['Room']['id']
				),
				array('iconSize' => 'btn-xs')
			); ?>
	</td>

	<td class="text-right">
		<?php
			if ($nest === 0) {
				echo $this->Button->addLink(__d('rooms', 'Add new subroom'),
						array('action' => 'add', $room['Space']['id'], $room['Room']['id']),
						array('iconSize' => 'btn-xs')
					);
			}
		?>
	</td>
</tr>
