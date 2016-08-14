<?php
/**
 * Rooms All Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsTestSuite', 'NetCommons.TestSuite');

/**
 * Rooms All Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Case
 * @codeCoverageIgnore
 */
class AllRoomsTest extends NetCommonsTestSuite {

/**
 * All test suite
 *
 * @return NetCommonsTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new NetCommonsTestSuite(sprintf('All %s Plugin tests', $plugin));
		//$suite->addTestDirectoryRecursive(CakePlugin::path($plugin) . 'Test' . DS . 'Case');

//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsAppController/BeforeFilterTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsAppController/PermissionTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/Component/RoomsRolesFormComponent/StartupTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/Component/RoomsRolesFormComponent/BeforeRenderTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/Component/RoomsComponent/InitializeTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/Component/RoomsComponent/SetRoomsForPaginatorTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/Component/RoomsComponent/StartupTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/PluginsRoomsController/EditTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/PluginsRoomsController/BeforeFilterTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsRolesUsersController/EditTest.php');
$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsRolesUsersController/SearchConditionsTest.php');
$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsController/EditTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsController/DeleteTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsController/IndexTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Controller/RoomsController/ActiveTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Room/DeleteRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Room/SaveRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Room/SaveTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Room/DeleteTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Room/ValidateTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Room/SaveActiveTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Room/SaveThemeTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/DeleteRoomAssociationsBehavior/DeletePagesByRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/DeleteRoomAssociationsBehavior/DeleteFramesByRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/DeleteRoomAssociationsBehavior/DeleteRoomAssociationsTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/DeleteRoomAssociationsBehavior/DeleteBlocksByRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/DeleteRoomAssociationsBehavior/QueryDeleteAllTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/RoomBehavior/GetSpacesTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/RoomBehavior/GetReadableRoomsConditionsTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/RoomBehavior/GetRoomsCondtionsTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/RoomBehavior/GetRolesRoomsTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/SaveRoomAssociationsBehavior/SaveDefaultRolesRoomsUserTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/SaveRoomAssociationsBehavior/SaveDefaultRolesRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/SaveRoomAssociationsBehavior/SaveDefaultRolesPluginsRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/SaveRoomAssociationsBehavior/SaveDefaultPageTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Behavior/SaveRoomAssociationsBehavior/SaveDefaultRoomRolePermissionTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RolesRoomsUser/SaveAccessedTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RolesRoomsUser/ValidateTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RolesRoomsUser/SaveRolesRoomsUsersForRoomsTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RolesRoomsUser/GetRolesRoomsUsersTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RoomsLanguage/ValidateTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RolesRoom/ValidateTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RoomRolePermission/ValidateTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Space/ValidateTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/Space/CreateRoomTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/Model/RoomRole/ValidateTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Elements/Rooms/RenderHeaderTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Elements/Rooms/RenderIndexTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Elements/Rooms/EditFormTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Elements/Rooms/DeleteFormTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Elements/Rooms/RenderRoomIndexTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Elements/SubtitleTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsRolesFormHelper/SelectDefaultRoomRolesTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsRolesFormHelper/CheckboxRoomRolesTest.php');

//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsRolesFormHelper/BeforeRenderTest.php');

//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsFormHelper/SettingTabsTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsFormHelper/ChangeStatusTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/StatusCssTest.php');

//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/SpaceTabsTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/RoomAccessedTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/RoomsNaviTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/RoomRoleNameTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/StatusLabelTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/RoomsRenderTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/RoomNameTest.php');
//$suite->addTestFile(CakePlugin::path($plugin) . 'Test' . DS . 'Case' . '/View/Helper/RoomsHelper/BeforeRenderTest.php');

		return $suite;
	}
}
