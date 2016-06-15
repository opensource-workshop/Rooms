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
	<table class="<?php echo $tableClass; ?>">
		<?php if (isset($headElementPath)) : ?>
			<thead>
				<?php echo $this->element($headElementPath); ?>
			</thead>
		<?php endif; ?>

		<?php
			echo '<tbody>';
			if ($roomTreeList || $displaySpace) {
				if ($displaySpace) {
					echo $this->element($dataElementPath, array('room' => $space, 'nest' => 0));
					$defaultNest = 0;
					$notFound = false;
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
			}
			if ($notFound) {
				echo '<td>';
				echo __d('rooms', 'Not found.');
				echo '</td>';
			}
			echo '</tbody>';
		?>
	</table>
</div>

<?php
	if ($paginator) {
		echo $this->element('NetCommons.paginator');
	}
