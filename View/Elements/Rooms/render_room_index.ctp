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
		<?php echo $this->Rooms->roomName($room, $nest); ?>

		<?php echo $this->Button->editLink('',
				array($room['Space']['id'], $room['Room']['id']),
				array('iconSize' => 'btn-xs')
			); ?>
	</td>

	<td>
		<?php
			if ($nest !== 0) {
				echo $this->Rooms->changeStatus($room);
			}
		?>
	</td>

	<td class="text-right">
		<?php
			if ($nest === 0) {
				$title = __d('rooms', 'Add new room');
			} else {
				$title = __d('rooms', 'Add new subroom');
			}
			echo $this->Button->addLink($title,
					array('action' => 'add', $room['Space']['id'], $room['Room']['id']),
					array('iconSize' => 'btn-xs')
				);
		?>
	</td>
</tr>
