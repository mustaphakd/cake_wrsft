<?php
/**
 * PaymentFixture
 *
 */
class PaymentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'license_generation_status' => array('type' => 'string', 'null' => false, 'default' => 'NotStarted', 'length' => 15, 'collate' => 'utf8_unicode_ci', 'comment' => 'NotStarted, Started, Error, Completed', 'charset' => 'utf8'),
		'payment_provider' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 25, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'transaction_status' => array('type' => 'string', 'null' => false, 'default' => 'Started', 'length' => 10, 'collate' => 'utf8_unicode_ci', 'comment' => 'started, Error, Committed', 'charset' => 'utf8'),
		'transaction_start_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'transaction_end_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'version_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'license_duration' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'months'),
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
			'id' => '57348b20-aa88-4152-aeb6-1230e1b253fa',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'license_generation_status' => 'Lorem ipsum d',
			'payment_provider' => 'Lorem ipsum dolor sit a',
			'transaction_status' => 'Lorem ip',
			'transaction_start_date' => '2016-05-12 15:54:40',
			'transaction_end_date' => '2016-05-12 15:54:40',
			'version_id' => 'Lorem ipsum dolor sit amet',
			'amount' => 1,
			'currency' => 'Lor',
			'license_duration' => 1
		),
	);

}
