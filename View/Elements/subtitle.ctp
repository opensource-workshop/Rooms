<?php
/**
 * Subtitle template
 *   - $spaceName
 *   - $roomNames
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
	<?php if (isset($roomNames)) : ?>
		<?php echo implode(' / ', array_map('h', $roomNames)); ?>
	<?php else : ?>
		<?php echo h($spaceName); ?>
	<?php endif; ?>
	<?php if ($this->params['action'] === 'add') : ?>
		/ <?php echo __d('rooms', 'Add new room'); ?>
	<?php endif; ?>
)
</div>
<?php $this->end();