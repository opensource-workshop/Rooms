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

<div class="table-responsive">
	<table class="table table-condensed rooms-roles-users-table">
		<thead>
			<tr>
				<?php echo $this->UserSearch->tableHeaders(false, false); ?>

				<th>
					<?php echo __d('rooms', 'Room role'); ?>
				</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($users as $index => $user) : ?>
				<tr>
					<?php echo $this->UserSearch->tableRow($user, false); ?>

					<td class="rooms-roles-form">
						<?php
							echo Hash::get($defaultRoles, Hash::get($user, 'RolesRoom.role_key', ''));
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php if ((int)$this->Paginator->counter('{:pages}') > 1) : ?>
	<div class="text-center form-group">
		<?php
			echo $this->NetCommonsHtml->link(
				__d('net_commons', 'More'),
				array('controller' => 'rooms_roles_users', 'action' => 'edit', 'key' => $activeSpaceId, 'key2' => $activeRoomId),
				array('class' => 'btn btn-info btn-block')
			);
		?>
	</div>
<?php endif;
