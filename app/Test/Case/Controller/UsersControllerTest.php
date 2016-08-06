<?php
App::uses('UsersController', 'Controller');

/**
 * UsersController Test Case
 *
 */
class UsersControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user',
		'app.license',
		'app.payment',
		'app.version',
		'app.product',
		'app.forum',
		'app.thread',
		'app.machine',
		'app.message',
		'app.role',
		'app.roles_user'
	);

}
