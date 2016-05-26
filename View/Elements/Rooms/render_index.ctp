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

<div class="table-responsive">
	<?php if ($this->params['plugin'] === 'rooms' &&
				$this->params['controller'] === 'rooms' &&
				$this->params['action'] === 'index') : ?>

		<table class="table space-edit-table">
			<tbody>
				<td>
					<label>
						<?php echo __d('rooms', 'Space name'); ?>
					</label>

					<div class="form-control space-name-edit">
						<?php echo $this->Rooms->roomName($space, 0); ?>

						<?php echo $this->Button->editLink('',
								array('action' => 'edit', 'key' => $space['Space']['id'], 'key2' => $space['Room']['id']),
								array('iconSize' => 'btn-xs')
							); ?>
					</div>
				</td>
				<td class="text-right">
					<?php echo $this->Button->addLink(__d('rooms', 'Add new room'),
							array('action' => 'add', 'key' => $space['Space']['id'], 'key2' => $space['Room']['id']),
							array('iconSize' => 'btn-xs')
						); ?>
				</td>
			</tbody>
		</table>
	<?php endif; ?>

	<table class="table table-hover">
		<?php if (isset($headElementPath)) : ?>
			<thead>
				<?php echo $this->element($headElementPath); ?>
			</thead>
		<?php endif; ?>
		<tbody>
			<?php
				if ($displaySpace) {
					echo $this->element($dataElementPath, array('room' => $space, 'nest' => 0));
					$defaultNest = 0;
				} else {
					$defaultNest = 1;
				}

				if ($roomTreeList) {
					foreach ($roomTreeList as $roomId => $tree) {
						if (Hash::get($rooms, $roomId) && ! in_array((string)$roomId, Room::$spaceRooms, true)) {
							$nest = substr_count($tree, Room::$treeParser);
							echo $this->element($dataElementPath, array(
								'room' => $rooms[$roomId],
								'nest' => $nest - $defaultNest
							));
						}
					}
				}
			?>
		</tbody>
	</table>
</div>

<?php
if ($paginator) {
	echo $this->element('NetCommons.paginator');
}
