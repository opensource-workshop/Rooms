<?php
/**
 * 権限管理の会員権限の詳細表示テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php $this->start('title_for_modal'); ?>
<?php echo Current::read('Plugin.name'); ?>
 -
<?php echo h($roomName); ?>
<?php $this->end(); ?>

<ul class="nav nav-tabs" role="tablist">
	<?php
		if ($activeTab === RoomsAppController::WIZARD_ROOMS) {
			$activeClass = ' class="active"';
		} else {
			$activeClass = '';
		}
	?>
	<li<?php echo $activeClass; ?>>
		<?php
			$key = RoomsAppController::WIZARD_ROOMS;
			$label = __d('rooms', 'General information');
			echo $this->NetCommonsHtml->link(
				$label, '#' . $key, ['aria-controls' => $key, 'role' => 'tab', 'data-toggle' => 'tab']
			);
		?>
	</li>

	<?php
		if ($activeTab === RoomsAppController::WIZARD_ROOMS_ROLES_USERS) {
			$activeClass = ' class="active"';
		} else {
			$activeClass = '';
		}
	?>
	<li<?php echo $activeClass; ?>>
		<?php
			$key = RoomsAppController::WIZARD_ROOMS_ROLES_USERS;
			$label = __d('rooms', 'The members to join');
			echo $this->NetCommonsHtml->link(
				$label, '#' . $key, ['aria-controls' => $key, 'role' => 'tab', 'data-toggle' => 'tab']
			);
		?>
	</li>

	<li>
		<?php
			$key = RoomsAppController::WIZARD_PLUGINS_ROOMS;
			$label = __d('rooms', 'The plugins to join');
			echo $this->NetCommonsHtml->link(
				$label, '#' . $key, ['aria-controls' => $key, 'role' => 'tab', 'data-toggle' => 'tab']
			);
		?>
	</li>
</ul>

<div class="tab-content">
	<?php
		if ($activeTab === RoomsAppController::WIZARD_ROOMS) {
			$activeClass = ' active';
		} else {
			$activeClass = '';
		}
	?>
	<div class="tab-pane<?php echo $activeClass; ?>"
			id="<?php echo RoomsAppController::WIZARD_ROOMS; ?>">
		<div class="text-right nc-edit-link">
			<?php echo $this->Button->editLink(__d('net_commons', 'Edit'),
					array('controller' => 'rooms', 'action' => 'edit', 'key' => $activeSpaceId, 'key2' => $activeRoomId),
					array('iconSize' => ' btn-sm')
				); ?>
		</div>
		<?php echo $this->element('Rooms/view_room'); ?>
	</div>

	<?php
		if ($activeTab === RoomsAppController::WIZARD_ROOMS_ROLES_USERS) {
			$activeClass = ' active';
		} else {
			$activeClass = '';
		}
	?>
	<div class="tab-pane<?php echo $activeClass; ?>"
			id="<?php echo RoomsAppController::WIZARD_ROOMS_ROLES_USERS; ?>">
		<div class="text-right nc-edit-link">
			<?php echo $this->Button->editLink(__d('net_commons', 'Edit'),
					array('controller' => 'rooms_roles_users', 'action' => 'edit', 'key' => $activeSpaceId, 'key2' => $activeRoomId),
					array('iconSize' => ' btn-sm')
				); ?>
		</div>
		<?php echo $this->element('Rooms/view_rooms_roles_users'); ?>
	</div>

	<div class="tab-pane" id="<?php echo RoomsAppController::WIZARD_PLUGINS_ROOMS; ?>">
		<div class="text-right nc-edit-link">
			<?php echo $this->Button->editLink(__d('net_commons', 'Edit'),
					array('controller' => 'plugins_rooms', 'action' => 'edit', 'key' => $activeSpaceId, 'key2' => $activeRoomId),
					array('iconSize' => ' btn-sm')
				); ?>
		</div>
		<?php echo $this->element('Rooms/view_plugins_rooms'); ?>
	</div>
</div>
