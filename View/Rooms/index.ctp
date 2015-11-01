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

<?php echo $this->element('Rooms.subtitle'); ?>
<?php echo $this->RoomsHtml->tabs($activeSpaceId); ?>

<article class="rooms-manager">
	<?php //echo $this->element('Rooms.Rooms/render_index', array('elementPath' => 'Rooms/room_link')); ?>

	<?php echo $this->RoomsHtml->roomsRender($activeSpaceId, 'Rooms.Rooms/render_room_index', 'Rooms.Rooms/render_header'); ?>
</article>
