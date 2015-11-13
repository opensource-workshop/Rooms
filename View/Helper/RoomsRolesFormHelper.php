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

App::uses('AppHelper', 'View/Helper');

/**
 * RoomsRolesFormHelper
 *
 * @package NetCommons\Rooms\View\Helper
 */
class RoomsRolesFormHelper extends AppHelper {

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * After render file callback.
 * Called after any view fragment is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The file just be rendered.
 * @param string $content The content that was rendered.
 * @return void
 */
	public function afterRenderFile($viewFile, $content) {
		$content = $this->NetCommonsHtml->script(array(
					'/rooms/js/role_permissions.js',
					'/rooms/js/room_role_permissions.js'
				)) . $content;

		parent::afterRenderFile($viewFile, $content);
	}

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

		$attributes = Hash::merge(array(
			'outerDiv' => true,
			'label' => false,
			'indent' => true
		), $attributes);

		$html = '';

		//外枠のdiv
		$outerDiv = $attributes['outerDiv'];
		if ($outerDiv === true) {
			$html .= '<div class="form-group">';
			$attributes['indent'] = true;
		}
		unset($attributes['outerDiv']);

		//ラベル
		if ($attributes['label']) {
			$outerDiv = true;
			$attributes['indent'] = true;
			$html .= $this->NetCommonsForm->label($fieldName, $attributes['label']);
		}
		unset($attributes['label']);

		$initialize = NetCommonsAppController::camelizeKeyRecursive(array('roles' => $this->_View->viewVars['roles']));
		$html .= '<div class="form-inline" ' .
						'ng-controller="RoomRolePermissions" ' .
						'ng-init="RolePermission.initialize(' . h(json_encode($initialize, JSON_FORCE_OBJECT)) . ')">';

		//外枠のdivがある場合、インデントする
		$indent = $attributes['indent'];
		unset($attributes['indent']);
		if ($indent) {
			$html .= '<div class="form-group checkbox-separator"></div>';
		}

		//権限のチェックボックス
		foreach ($this->_View->request->data[$model][$permission] as $roleKey => $role) {
			if (! $role['value'] && $role['fixed']) {
				continue;
			}

			$html .= '<div class="form-group">';
			$html .= $this->NetCommonsForm->hidden($fieldName . '.' . $roleKey . '.id');

			$options = Hash::merge(array(
				'div' => false,
				'disabled' => (bool)$role['fixed'],
			), $attributes);
			if (! $options['disabled']) {
				$options['ng-click'] = 'RolePermission.clickRole(' . '$event, \'' .
						$model . '\', \'' . $permission . '\', \'' . Inflector::variable($roleKey) . '\')';
			}

			$html .= $this->NetCommonsForm->checkbox($fieldName . '.' . $roleKey . '.value', $options);
			$html .= $this->NetCommonsForm->label($fieldName . '.' . $roleKey . '.value',
						h($this->_View->request->data['Role'][$roleKey]['name']));

			$html .= '</div>';
			$html .= '<span class="checkbox-separator"></span>';
		}

		$html .= '</div>';

		//外枠のdiv
		if ($outerDiv === true) {
			$html .= '</div>';
		}

		return $html;
	}

/**
 * ルーム内の役割のデフォルト値のSELECTタグ
 *
 * @param string $fieldName フィールド名
 * @param array $attributes HTML属性オプション
 * @return string HTMLタグ
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#options-for-select-checkbox-and-radio-inputs
 */
	public function selectDefaultRoomRoles($fieldName, $attributes = array()) {
		$defaultRoles = $this->_View->viewVars['defaultRoles'];
		if (isset($attributes['options'])) {
			$defaultRoles = Hash::merge($defaultRoles, $attributes['options']);
			unset($attributes['options']);
		}

		$html = '<div class="form-group">';

		if (isset($attributes['label'])) {
			if (is_array($attributes['label'])) {
				$label = $attributes['label']['label'];
				unset($attributes['label']['label']);

				$html .= $this->NetCommonsForm->label($fieldName, $label, $attributes['label']) . ' ';
			} else {
				$html .= $this->NetCommonsForm->label($fieldName, $attributes['label']) . ' ';
			}
			unset($attributes['label']);
		}
		$attributes = Hash::merge(array(
			'type' => 'select',
			'class' => 'form-control',
			'empty' => false
		), $attributes);
		$html .= $this->NetCommonsForm->select($fieldName, $defaultRoles, $attributes);

		$html .= '</div>';
		return $html;
	}

}
