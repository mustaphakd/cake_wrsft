<?php
/**
 * LicenseFixture
 *
 */
class LicenseFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'payment_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'user_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'version_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'activation_start_date' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'starts once user/client retrieves license file'),
		'duration' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'months'),
		'retrieved' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'license_file' => array('type' => 'binary', 'null' => false, 'default' => null, 'comment' => 'x509 file'),
		'public_key' => array('type' => 'binary', 'null' => false, 'default' => null, 'comment' => '4096 bits'),
		'private_key' => array('type' => 'binary', 'null' => false, 'default' => null, 'comment' => '4096 bits'),
		'expiration_date' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'set at the same moment activation start_date is set'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '57348915-20bc-478d-8ceb-1230e1b253fa',
			'payment_id' => 'Lorem ipsum dolor sit amet',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'version_id' => 'Lorem ipsum dolor sit amet',
			'activation_start_date' => '2016-05-12 15:45:57',
			'duration' => 1,
			'retrieved' => 1,
			'license_file' => 'Lorem ipsum dolor sit amet',
			'public_key' => 'Lorem ipsum dolor sit amet',
			'private_key' => 'Lorem ipsum dolor sit amet',
			'expiration_date' => '2016-05-12 15:45:57'
		),
	);

}
