<?php
/**
 * UserAttribute edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php foreach ($this->request->data['RoomsLanguage'] as $index => $roomLanguage) : ?>
	<?php $languageId = $roomLanguage['RoomsLanguage']['language_id']; ?>

	<?php if (isset($languages[$languageId])) : ?>
		<div id="rooms-rooms-<?php echo $languageId; ?>"
				class="tab-pane<?php echo ($activeLangId === (string)$languageId ? ' active' : ''); ?>">

			<?php echo $this->Form->hidden('RoomsLanguage.' . $index . '.' . 'RoomsLanguage.id'); ?>

			<?php echo $this->Form->hidden('RoomsLanguage.' . $index . '.' . 'RoomsLanguage.room_id'); ?>

			<?php echo $this->Form->hidden('RoomsLanguage.' . $index . '.' . 'RoomsLanguage.language_id'); ?>

			<div class="form-group">
				<?php echo $this->Form->input('RoomsLanguage.' . $index . '.' . 'RoomsLanguage.name', array(
						'type' => 'text',
						'label' => __d('rooms', 'Room name') . $this->element('NetCommons.required'),
						'class' => 'form-control',
					)); ?>

				<?php echo $this->element(
					'NetCommons.errors', [
						'errors' => $this->validationErrors,
						'model' => 'RoomsLanguage',
						'field' => 'name',
					]); ?>
			</div>

		</div>
	<?php endif; ?>
<?php endforeach; ?>

