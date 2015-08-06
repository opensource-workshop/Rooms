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

<?php foreach ($this->request->data['SpacesLanguage'] as $index => $spaceLanguage) : ?>
	<?php $languageId = $spaceLanguage['SpacesLanguage']['language_id']; ?>

	<?php if (isset($languages[$languageId])) : ?>
		<div id="rooms-space-<?php echo $languageId; ?>"
				class="tab-pane<?php echo ($activeLangId === (string)$languageId ? ' active' : ''); ?>">

			<?php echo $this->Form->hidden('SpacesLanguage.' . $index . '.' . 'SpacesLanguage.id'); ?>

			<?php echo $this->Form->hidden('SpacesLanguage.' . $index . '.' . 'SpacesLanguage.space_id'); ?>

			<?php echo $this->Form->hidden('SpacesLanguage.' . $index . '.' . 'SpacesLanguage.language_id'); ?>

			<div class="form-group">
				<?php echo $this->Form->input('SpacesLanguage.' . $index . '.' . 'SpacesLanguage.name', array(
						'type' => 'text',
						'label' => __d('rooms', 'Space name') . $this->element('NetCommons.required'),
						'class' => 'form-control',
					)); ?>

				<?php echo $this->element(
					'NetCommons.errors', [
						'errors' => $this->validationErrors,
						'model' => 'SpacesLanguage',
						'field' => 'name',
					]); ?>
			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>

