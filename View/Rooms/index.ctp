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

echo $this->Html->css(
	array(
		'/rooms/css/style.css'
	),
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
?>

<?php echo $this->element('Rooms.subtitle'); ?>

<?php echo $this->element('Rooms.space_tabs'); ?>

<table class="table table-hover">
	<tbody>
		<tr>
			<th>
				<a href="<?php echo $this->Html->url('/rooms/spaces/edit/' . $space['Space']['id']); ?>">
					<?php echo h($space['SpacesLanguage']['name']); ?>
				</a>
			</th>
			<th class="text-right">
				<?php if ($space['Space']['plugin_key'] !== 'public_space') : ?>
					<a class="btn btn-xs btn-success" href="<?php echo $this->Html->url('/rooms/rooms/add/' . $space['Space']['id']); ?>">
						<span class="glyphicon glyphicon-plus"> </span>
					</a>
				<?php endif; ?>
			</th>
		</tr>
		<?php foreach ($rooms as $room) : ?>
			<?php echo $this->element('Rooms/room_link', array(
					'spaceId' => $space['Space']['id'],
					'roomId' => $room['Room']['id'],
					'nest' => 0,
							'roomName' => $room['RoomsLanguage']['name'],
					'active' => (bool)$room['Room']['active'],
				)); ?>

			<?php if (isset($room['TreeList'])) : ?>
				<?php foreach ($room['TreeList'] as $roomId => $roomName) : ?>
					<?php echo $this->element('Rooms/room_link', array(
							'spaceId' => $space['Space']['id'],
							'roomId' => $roomId,
							'nest' => substr_count($roomName, chr(9)) + 1,
							'roomName' => $room['children'][$roomId]['RoomsLanguage']['name'],
							'active' => (bool)$room['children'][$roomId]['Room']['active'],
						)); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('NetCommons.paginator');
