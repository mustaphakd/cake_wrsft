<?php
/**
 * Created by PhpStorm.
 * User: musta
 * Date: 11/27/2016
 * Time: 11:09 PM
 */

App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

define( 'WWW_JS_ROOT', WWW_ROOT . 'js' . DS );
define( 'WWW_IMG_ROOT', WWW_ROOT . 'img' . DS );

/**
 * SourceMedia Controller
 *
 * @property Product $Product
 * @property
 */


class SourceMediaController extends AppController
{

    public $uses = array();
    public $components = array('RequestHandler');

    public  function provide(){

        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            $this->serveDefaultJson();

            return;
        }

        $fullpath = $this->constructPath($path);


        if (!file_exists($fullpath)){
            $this->serveDefaultJson();
            return;
        }

        $this->response->file($fullpath, array('download' => true, 'name' => $path[count($path) - 1 ]));
        return $this->response;
      /*  $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }*/
    }

    public function beforeFilter(){
       // parent::beforeFilter();

        $this->Auth->allow("provide");

        if (!method_exists($this, $this->action)) {
            unshift($this->params['pass'], $this->action);
            $this->action = 'provide';
        }
    }

    private function constructPath($pathArr){

        $path = '';
        $firstNode = strtolower(trim($pathArr[0]));

        $tokens = array_slice($pathArr, 1, null, true);
        switch ($firstNode){
            case 'js':
                array_unshift($tokens, WWW_JS_ROOT);
                $path = implode(DS, $tokens);
                return $path;
                break;
            default :  //'img'
                array_unshift($tokens, WWW_IMG_ROOT);
                $path = implode(DS, $tokens);
                return $path;
                break;
        }
    }

    private function serveDefaultJson()
    {
        $this->viewClass = "Json";

        $this->set(array(
            'status' => 'ok',
            "data" => "not found",
            "_serialize" => array("article", "status")
        ));
    }

}