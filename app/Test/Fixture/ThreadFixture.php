<?php
/**
 * ThreadFixture
 *
 */
class ThreadFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'forum_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'user_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'posted_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'thread_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36),
		'comment' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'id' => '57348c02-9170-4634-bd49-1230e1b253fa',
			'forum_id' => 'Lorem ipsum dolor sit amet',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'posted_date' => '2016-05-12 15:58:26',
			'thread_id' => 'Lorem ipsum dolor sit amet',
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
