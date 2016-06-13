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
?>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-inline">
			<div class="clearfix">
				<?php
					$default = Hash::extract($pluginsRoom, '{n}.PluginsRoom[room_id=' . Current::read('Room.id') . ']');
					echo $this->PluginsForm->checkboxPluginsRoom(
						'PluginsRoom.plugin_key',
						array(
							'div' => array('class' => 'plugin-checkbox-outer'),
							'default' => array_values(Hash::combine($default, '{n}.plugin_key', '{n}.plugin_key')),
							'disabled' => true
						)
					);
				?>
			</div>
		</div>
	</div>
</div>
