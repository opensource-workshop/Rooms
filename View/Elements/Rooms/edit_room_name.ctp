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

<?php foreach ($this->request->data['RoomsLanguage'] as $index => $roomLanguage) : ?>
	<?php $languageId = $roomLanguage['language_id']; ?>

	<?php if (isset($languages[$languageId])) : ?>
		<div id="rooms-rooms-<?php echo $languageId; ?>"
				class="tab-pane<?php echo ($activeLangId === (string)$languageId ? ' active' : ''); ?>">

			<?php echo $this->Form->hidden('RoomsLanguage.' . $index . '.id'); ?>

			<?php echo $this->Form->hidden('RoomsLanguage.' . $index . '.room_id'); ?>

			<?php echo $this->Form->hidden('RoomsLanguage.' . $index . '.language_id'); ?>

			<div class="form-group">
				<?php echo $this->Form->input('RoomsLanguage.' . $index . '.name', array(
						'type' => 'text',
						'label' => __d('rooms', 'Room name') . $this->element('NetCommons.required'),
						'class' => 'form-control',
						'error' => false,
					)); ?>

				<div class="has-error">
					<?php echo $this->Form->error('RoomsLanguage.' . $index . '.name', null, array(
							'class' => 'help-block'
						)); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endforeach;