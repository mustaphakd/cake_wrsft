<?php
App::uses('RolesController', 'Controller');

/**
 * RolesController Test Case
 *
 */
class RolesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.role',
		'app.user',
		'app.license',
		'app.payment',
		'app.version',
		'app.product',
		'app.forum',
		'app.thread',
		'app.machine',
		'app.message',
		'app.roles_user'
	);

}
