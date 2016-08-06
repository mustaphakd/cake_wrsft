<?php
App::uses('License', 'Model');

/**
 * License Test Case
 *
 */
class LicenseTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.license',
		'app.payment',
		'app.user',
		'app.machine',
		'app.message',
		'app.thread',
		'app.role',
		'app.roles_user',
		'app.version'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->License = ClassRegistry::init('License');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->License);

		parent::tearDown();
	}

}
