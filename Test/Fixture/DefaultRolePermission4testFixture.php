<?php
/**
 * アクセス権限(Permission)テスト用Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('DefaultRolePermissionFixture', 'Roles.Test/Fixture');

/**
 * アクセス権限(Permission)テスト用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class DefaultRolePermission4testFixture extends DefaultRolePermissionFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'DefaultRolePermission';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'default_role_permissions';

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();

		require_once App::pluginPath('Roles') . 'Config' . DS . 'Migration' . DS . '1469603399_records.php';
		$this->records = (new RolesRecords())->records[$this->name];
	}

}
