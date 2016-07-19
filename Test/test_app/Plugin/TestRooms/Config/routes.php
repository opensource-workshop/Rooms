<?php
/**
 * テストRoomsのルーティング
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

Router::connect(
	'/test_rooms/:controller/:action/*',
	array('plugin' => 'test_rooms')
);
