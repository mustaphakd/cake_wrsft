<?php
App::uses('AppModel', 'Model');
/**
 * Download Model
 *
 * @property User $User
 * @property binary $id
 * @property string $title
 * @property string $content
 * @property DateTime $created
 * @property DateTime $modified
 * @property boolean $enabled
 * @property binary $user_id
 * @property string $image_path
 */
class Article extends AppModel {


    public $validate = array(
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty')
            )
        ),
        'content' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty')
            )
        ),
        'image_path' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty')
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'enabled' => array(
        )
    );

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
