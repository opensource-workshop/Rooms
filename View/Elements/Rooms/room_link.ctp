<?php
/**
 * Room link template
 *   - $spaceId: spaces.id
 *   - $roomId: rooms.id
 *   - $nest: nest count
 *   - $roomName: rooms_languages.name
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$roomName = str_repeat('<span class="rooms-tree"></span>', $nest) . h($roomName);
?>

<tr class="<?php echo (! $active ? 'danger' : ''); ?>">
	<td>
		<a href="<?php echo $this->Html->url('/rooms/rooms/edit/' . $roomId); ?>">
			<?php echo $roomName; ?>
		</a>
	</td>
	<td class="text-right">
		<a class="btn btn-xs btn-success"
			href="<?php echo $this->Html->url('/rooms/rooms/add/' . $spaceId . '/' . $roomId); ?>">

			<span class="glyphicon glyphicon-plus"> </span>
		</a>
	</td>
</tr>
