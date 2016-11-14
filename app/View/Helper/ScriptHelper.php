<?php

/**
 * Created by PhpStorm.
 * User: musta
 * Date: 11/14/2016
 * Time: 3:16 PM
 */

App::uses('AppHelper', 'View/Helper');


class ScriptHelper extends AppHelper {

    protected $_View;

    public function __construct(View $View, $settings = array()) {

    }

   /* public function scriptBlock($script, $options = array()) {
        $options += array('type' => 'text/javascript', 'safe' => true, 'inline' => true);
        if ($options['safe']) {
            $script = "\n" . '//<![CDATA[' . "\n" . $script . "\n" . '//]]>' . "\n";
        }
        unset($options['inline'], $options['safe']);

        $attributes = $this->_parseAttributes($options, array('block'), ' ');
        $out = sprintf($this->_tags['javascriptblock'], $attributes, $script);

        if (empty($options['block'])) {
            return $out;
        }
        $this->_View->append($options['block'], $out);
    }*/
}