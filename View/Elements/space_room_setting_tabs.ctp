<?php
/**
 * Space setting tabs template
 *   - $activeSpaceId: Active spaces.id.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-pills" role="tablist">
	<li class="<?php echo ($this->params['controller'] === 'spaces' ? 'active' : ''); ?>">
		<a href="<?php echo $this->Html->url('/rooms/spaces/edit/' . h($activeSpaceId) . '/'); ?>">
			<?php echo __d('rooms', 'General setting'); ?>
		</a>
	</li>

	<li class="<?php echo ($this->params['controller'] === 'plugins_spaces' ? 'active' : ''); ?>">
		<a href="<?php echo $this->Html->url('/rooms/plugins_spaces/edit/' . h($activeSpaceId) . '/'); ?>">
			<?php echo __d('rooms', 'Select the plugins to join'); ?>
		</a>
	</li>
</ul>

<br>
