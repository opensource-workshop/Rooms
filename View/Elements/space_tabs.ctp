<?php
/**
 * Space tabs template
 *   - $activeSpaceId: Active spaces.id.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-tabs" role="tablist">
	<?php foreach ($spaces as $space) : ?>
		<li class="<?php echo ($space['Space']['id'] === $activeSpaceId ? 'active' : ''); ?>">
			<?php echo $this->Html->link($space['SpacesLanguage']['name'],
					'/rooms/' . $space['Space']['default_setting_action']
				); ?>
		</li>
	<?php endforeach; ?>
</ul>

<br>
