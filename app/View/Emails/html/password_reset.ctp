<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
   // $content = explode("\n", $content);


    echo '<fieldset>';
    echo    '<legend>Click link below to reset your password</legend>'
        . '<div class="row">'
        .'<div class="col-lg-6">';

    echo '<a href="'. $content  .'">'. $content . '</a>';


    echo '</div></div>';

    echo '<fieldset>';
?>
