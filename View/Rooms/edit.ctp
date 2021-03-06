<?php
/**
 * Rooms edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Space', 'Rooms.Model');
?>

<?php
	echo $this->Rooms->spaceTabs($activeSpaceId);
	echo $this->element('Rooms.subtitle');
	echo $this->RoomsForm->settingTabs();
	echo $this->MessageFlash->description(__d('rooms', 'Input the room name.'));
?>

<div class="panel panel-default">
	<?php echo $this->NetCommonsForm->create('Room'); ?>

	<div class="panel-body">
		<?php echo $this->SwitchLanguage->tablist('rooms-rooms-'); ?>

		<div class="tab-content">

			<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>
			<?php echo $this->NetCommonsForm->hidden('Room.space_id'); ?>
			<?php echo $this->NetCommonsForm->hidden('Room.parent_id'); ?>
			<?php echo $this->NetCommonsForm->hidden('Page.parent_id'); ?>

			<?php echo $this->element('Rooms/edit_form'); ?>
		</div>
	</div>

	<div class="panel-footer text-center">
		<?php
			echo $this->Button->cancelAndSave(
				__d('net_commons', 'Cancel'),
				__d('net_commons', 'OK'),
				'/rooms/' . $spaces[$activeSpaceId]['Space']['default_setting_action']
			);
		?>
	</div>

	<?php echo $this->NetCommonsForm->end(); ?>
</div>

<?php if ($this->data['Room']['parent_id'] !== Space::getRoomIdRoot(Space::WHOLE_SITE_ID, 'Room') &&
		$this->request->params['action'] === 'edit') : ?>
	<?php echo $this->element('Rooms/delete_form'); ?>
<?php endif;
