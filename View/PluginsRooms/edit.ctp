<?php
/**
 * PluginsRooms edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/plugin_manager/css/style.css');
?>

<?php
	echo $this->Rooms->spaceTabs($activeSpaceId);
	echo $this->element('Rooms.subtitle');
	echo $this->RoomForm->settingTabs();
	echo $this->MessageFlash->description(__d('rooms', 'You can set the plugins to be used in the specified room. Press [OK] button to proceed.'));
?>

<div class="panel panel-default">
	<?php echo $this->NetCommonsForm->create('Room'); ?>
	<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>

	<div class="panel-body">
		<div class="form-inline">
			<div class="clearfix">
				<?php
					$default = Hash::extract($pluginsRoom, '{n}.PluginsRoom[room_id=' . Current::read('Room.id') . ']');
					echo $this->PluginsForm->checkboxPluginsRoom(
						'PluginsRoom.plugin_key',
						array(
							'div' => array('class' => 'plugin-checkbox-outer'),
							'default' => array_values(Hash::combine($default, '{n}.plugin_key', '{n}.plugin_key'))
						)
					);
				?>
			</div>
		</div>
	</div>

	<div class="panel-footer text-center">
		<?php
			echo $this->Button->cancelAndSave(
				__d('net_commons', 'Cancel'),
				__d('net_commons', 'OK'),
				$this->NetCommonsHtml->url('/rooms/' . $spaces[$activeSpaceId]['Space']['default_setting_action'])
			);
		?>
	</div>

	<?php echo $this->NetCommonsForm->end(); ?>
</div>
