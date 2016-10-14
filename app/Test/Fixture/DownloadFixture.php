<?php
/**
 * DownloadFixture
 *
 */
class DownloadFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'version_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'last_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'unique_id' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '57ec00df-31e8-488c-a8b5-1abce1b253fa',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'version_id' => 'Lorem ipsum dolor sit amet',
			'last_date' => '2016-09-28 19:41:51'
		),
	);

}
