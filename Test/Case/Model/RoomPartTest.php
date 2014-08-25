<?php
/**
 * RoomPart Test Case
 *
 * @author   Takako Miyagawa <nekoget@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RoomPart', 'Rooms.Model');

/**
 * Summary for RoomPart Test Case
 */
class RoomPartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rooms.room_part',
		'plugin.rooms.part',
		'plugin.rooms.language',
		'plugin.rooms.languages_part'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RoomPart = ClassRegistry::init('Rooms.RoomPart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RoomPart);

		parent::tearDown();
	}

/**
 * find
 */
	public function testFind() {
		$rtn = $this->RoomPart->find('first');
		$this->assertTrue(is_array($rtn));
	}

}
