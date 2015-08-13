<?php
/**
 * RoomsRolesFormHelper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FormHelper', 'View/Helper');

/**
 * RoomsRolesFormHelper
 *
 * @package NetCommons\Rooms\View\Helper
 */
class RoomsRolesFormHelper extends FormHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array('Form');

/**
 * Outputs room roles radio
 *
 * @param string $fieldName Name attribute of the RADIO
 * @param array $attributes The HTML attributes of the select element.
 * @return string Formatted RADIO element
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function checkboxRoomRoles($fieldName, $attributes = array()) {
		list($model, $permission) = explode('.', $fieldName);

		$html = '';

		foreach ($this->_View->request->data[$model][$permission] as $roleKey => $role) {
			if (! $role['value'] && $role['fixed']) {
				continue;
			}

			$html .= '<div class="form-group">';
			$html .= $this->Form->hidden($fieldName . '.' . $roleKey . '.id');

			$options = Hash::merge(array(
				'div' => false,
				'disabled' => (bool)$role['fixed']
			), $attributes);
			$html .= $this->Form->checkbox($fieldName . '.' . $roleKey . '.value', $options);

			$html .= $this->Form->label($fieldName . '.' . $roleKey . '.value', h($this->_View->request->data['Role'][$roleKey]['name']));
			$html .= '</div>';
			$html .= '<span class="checkbox-separator"></span>';
		}

		return $html;
	}

}
