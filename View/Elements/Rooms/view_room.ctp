<?php
/**
 * Room edit form template
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
		<?php echo $this->SwitchLanguage->tablist('rooms-rooms-'); ?>

		<div class="tab-content">
			<?php
				foreach ($this->request->data['RoomsLanguage'] as $index => $roomLanguage) {
					$languageId = $roomLanguage['language_id'];
					if (isset($languages[$languageId])) {
						echo '<div id="rooms-rooms-' . $languageId . '" ' .
									'class="tab-pane' . ($activeLangId === (string)$languageId ? ' active' : '') . '">';

						echo $this->NetCommonsForm->input('RoomsLanguage.' . $index . '.name', array(
							'type' => 'label',
							'label' => $this->SwitchLanguage->inputLabel(__d('rooms', 'Room name'), $languageId),
							'required' => true,
						));

						echo '</div>';
					}
				}
			?>

			<?php
				echo $this->NetCommonsForm->inlineCheckbox('Room.default_participation', array(
					'label' => __d('rooms', 'Open for all members'),
					'disabled' => true,
				));
			?>

			<div class="form-group row">
				<div class="col-xs-offset-1 col-xs-11 room-roles-desc">
					<?php echo $this->RoomsRolesForm->selectDefaultRoomRoles('Room.default_role_key', array(
							'label' => array('label' => __d('rooms', 'Default room role')),
							'options' => $defaultRoleOptions,
							'disabled' => true,
						)); ?>
				</div>
			</div>

			<?php
				echo $this->NetCommonsForm->input('Room.need_approval', array(
					'type' => 'radio',
					'options' => array(
						'1' => __d('rooms', 'Authority to publish approved content'),
						'0' => __d('rooms', 'Do not use the approval')
					),
					'label' => __d('rooms', 'Approved content?'),
					'disabled' => true,
				));
			?>

			<?php echo $this->RoomsRolesForm->checkboxRoomRoles('RoomRolePermission.content_publishable', array(
					'label' => __d('rooms', 'Allow publish approved content'),
					'disabled' => true,
				)); ?>

			<?php echo $this->RoomsRolesForm->checkboxRoomRoles('RoomRolePermission.html_not_limited', array(
					'label' => __d('rooms', 'Allow all html tags?  e.g.) Javascript or iframe'),
					'disabled' => true,
				)); ?>

			<div class="form-inline form-group">
				<?php echo $this->NetCommonsForm->input('Room.active', array(
						'type' => 'select',
						'label' => __d('rooms', 'Status'),
						'options' => array(
							'0' => __d('rooms', 'Under maintenance'),
							'1' => __d('rooms', 'Open'),
						),
						'value' => (int)Hash::get($this->data, 'Room.active'),
						'between' => ' ',
						'disabled' => true
					)); ?>
			</div>
		</div>
	</div>
</div>
