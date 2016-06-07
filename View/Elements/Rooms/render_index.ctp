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

$notFound = true;
?>

<div class="table-responsive">
	<table class="table table-hover">
		<?php if (isset($headElementPath)) : ?>
			<thead>
				<?php echo $this->element($headElementPath); ?>
			</thead>
		<?php endif; ?>

		<?php if ($roomTreeList || $displaySpace) : ?>
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

								$notFound = false;
							}
						}
					}
				?>
			</tbody>
		<?php endif; ?>
	</table>

	<?php if ($notFound) : ?>
		<?php echo __d('rooms', 'Not found.'); ?>
	<?php endif; ?>
</div>

<?php
if ($paginator) {
	echo $this->element('NetCommons.paginator');
}
