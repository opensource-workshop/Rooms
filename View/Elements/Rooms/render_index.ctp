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

<table class="table table-hover">
	<tbody>
		<?php if (isset($headElementPath)) : ?>
			<?php echo $this->element($headElementPath); ?>
		<?php endif; ?>

		<?php echo $this->element($elementPath, array(
				'spaceId' => $space['Space']['id'],
				'roomId' => $space['Room']['id'],
				'nest' => 0,
				'roomName' => $space['RoomsLanguage']['name'],
				'active' => (bool)$space['Room']['active'],
				'isLink' => (bool)$space['Room']['page_id_top']
			)); ?>

		<?php foreach ($rooms as $room) : ?>
			<?php echo $this->element($elementPath, array(
					'spaceId' => $space['Space']['id'],
					'roomId' => $room['Room']['id'],
					'nest' => 1,
					'roomName' => $room['RoomsLanguage']['name'],
					'active' => (bool)$room['Room']['active'],
					'isLink' => (bool)$room['Room']['page_id_top']
				)); ?>

			<?php if (isset($room['TreeList'])) : ?>
				<?php foreach ($room['TreeList'] as $roomId => $roomName) : ?>
					<?php echo $this->element($elementPath, array(
							'spaceId' => $space['Space']['id'],
							'roomId' => $roomId,
							'nest' => substr_count($roomName, chr(9)) + 1,
							'roomName' => $room['children'][$roomId]['RoomsLanguage']['name'],
							'active' => (bool)$room['children'][$roomId]['Room']['active'],
							'isLink' => true
						)); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->element('NetCommons.paginator');
