<?php
/**
 * Subtitle template
 *   - $active: Active tab key. Value is 'block_index or 'frame_settings' or 'role_permissions'.
 *   - $disabled: Disabled tab
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php $this->start('subtitle'); ?>
<div class="text-muted small visible-xs-inline-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">
(
	<?php echo h($spaceName); ?>
	<?php if (isset($roomNames)) : ?>
		<?php foreach ($roomNames as $roomName) : ?>
			/ <?php echo h($roomName); ?>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if ($this->params['action'] === 'add') : ?>
		/ <?php echo __d('rooms', 'Add new room'); ?>
	<?php endif; ?>
)
</div>
<?php $this->end();
