<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 9/12/2016
 * Time: 11:04 PM
 */

App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

define( 'WWW_FILE_ROOT', WWW_ROOT . 'files' . DS);
define( 'WWW_IMG_ROOT', WWW_ROOT . 'img' . DS);

/**
 * FileSystem Controller
 *
 * @property Product $Product
 * @property Version $Version
 */


class FileSystemController extends AppController{

    public $uses = array('Product', 'Version');

    public $components = array('RequestHandler');

    public  function directoryAndFiles(){

        $path = ltrim(trim($this->request->query['path']), DS);
        $tokens = explode(DS, strtolower($path));

        ($tokens[0] == 'root') && ($tokens = array_slice($tokens, 1, null, true));

        $path = implode(DS, $tokens);
// to here goes into an if block so rest of code can be shared with the default that returns root folder
        $fullPath = WWW_FILE_ROOT. strtolower($path);

        if (!file_exists($fullPath)){
            $this->setErrorMessage("the following path: " . $this->request->query['path'] . " does not exist");
            return;
        }

        $dir = new Folder($fullPath, false);

        $dirAndFiles = $dir->read(false);

        $dir = null;


        $this->set(array(
            "filesystem" => array(
                'folders' => $dirAndFiles[0],
                'files' => $dirAndFiles[1]
            ),
            'status' => 'ok',
            "message" => '',
            "_serialize" => array("message", "filesystem", "status")
        ));
    }
    // (3)
    public function createDirectory(){

        if(!isset($this->request->data['currentPath'])  || !isset($this->request->data['newDirName'])){
            $this->setErrorMessage('invalid parameters');
            return;
        }

        $newDirName = trim(trim($this->request->data['newDirName'], DS));

        $currentPath = ltrim(trim($this->request->data['currentPath']), DS);
        $tokens = explode(DS, strtolower($currentPath));

        if (count($tokens) == 0){
            $this->setErrorMessage('Invalid path');
            return;
        }

        ($tokens[0] == 'root') && ($tokens = array_slice($tokens, 1, null, true));

        $currentPath = implode(DS, $tokens);

        $fullPath = WWW_FILE_ROOT . $currentPath;

        if (!is_dir($fullPath)){
            $this->setErrorMessage('Invalid path');
            return;
        }

        $fullPath = $fullPath . DS . strtolower($newDirName) ;

        $dir = new Folder($fullPath, true);

        if( !is_dir($fullPath)){
            $this->set(array(
                'status' => 'er',
                "message" => 'Unable to create ' . $newDirName,
                "_serialize" => array("message","status")
            ));
            return;
        }

        $this->set(array(
            'status' => 'ok',
            "message" => '',
            "_serialize" => array("message","status")
        ));
    }

    public function deleteDirectory(){

        if (
            !isset($this->request->data['currentPath'])  ||
            !isset($this->request->data['dirName']) ||
            !isset($this->request->data['fileType']) )
        {
            $this->setErrorMessage('invalid parameters');
            return;
        }

        $dirName = trim(trim($this->request->data['dirName'], DS));
        $fileType = trim(trim($this->request->data['fileType'], DS));

        $currentPath = ltrim(trim($this->request->data['currentPath']), DS);
        $tokens = explode(DS, strtolower($currentPath));

        if (count($tokens) == 0){
            $this->setErrorMessage('Invalid path');
            return;
        }

        ($tokens[0] == 'root') && ($tokens = array_slice($tokens, 1, null, true));

        $currentPath = implode(DS, $tokens);

        $fullPath = WWW_FILE_ROOT . $currentPath;

        if (!is_dir($fullPath)){
            $this->setErrorMessage('Invalid path');
            return;
        }

        $fullPath = $fullPath . DS . strtolower($dirName) ;

        if( ( $fileType == 'dir' && !is_dir($fullPath)) || ($fileType == 'file' && !is_file($fullPath))){
            $this->setErrorMessage('Unable to Delete ' . $dirName . '  .It does not exist' );
            return;
        }

        switch($fileType){
            case 'dir':
                $fldr = new Folder($fullPath);
                $fldr->delete($fullPath);
                if (is_dir($fullPath)){
                    $this->setErrorMessage('Unable to Delete ' . $dirName  );
                    return;
                }
                break;
            case 'file':
                $file = new File($fullPath);
                $file->delete();
                if (is_file($fullPath)){
                    $this->setErrorMessage('Unable to Delete ' . $dirName );
                    return;
                }
                break;
        }

        $this->set(array(
            'status' => 'ok',
            "message" => '',
            "_serialize" => array("message","status")
        ));
    }
    // (2)
    public  function setVersionFilePath(){

        if(!isset($this->request->data['versionId'])  || !isset($this->request->data['file'])){
            $this->setErrorMessage('invalid version');
            return;
        }

        $versionId = $this->request->data['versionId'];
        $filePath = ltrim(trim($this->request->data['file']), DS); ;

        $path_tokens = explode(DS, $filePath);

        if(count($path_tokens) == 0){
            $this->setErrorMessage('file path is invalid or not well formed');
            return;
        }

        if($path_tokens[0] == 'root') array_shift($path_tokens);

        $path = implode(DS, $path_tokens);
        $relativePath = strtolower($path);
        $fullPath = WWW_FILE_ROOT . $relativePath ;

        if (!file_exists($fullPath)){
            $this->setErrorMessage("the following path: " . $filePath . " does not exist");
            return;
        }

        $v_id = pack('H*', $versionId);

        $options = array(
            'recursive' => 1,
            'conditions' => array('Version.' . $this->Version->primaryKey => $v_id)
        );

        $this->loadModel('Version');

        $this->Version->set($this->Version->primaryKey, $v_id) ;
        $this->Version->saveField('path', $relativePath, false);

        $this->set(array(
            'status' => 'ok',
            "message" => 'successful',
            "_serialize" => array("message", "status")
        ));
    }

    private  function setErrorMessage($message){
        $this->set(array(
            "status" => "er",
            "message" => $message,
            "_serialize" => array("message", "status")
        ));
    }
    // (4) tobe implemented last
    public function uploadFile(){

        if (!$this->request->is('post'))
        {
            $this->setErrorMessage('Post method required');
            return;
        }

        if (!isset($this->request->data['currentPath']) ||
            !isset($this->request->params['form']) ||
            !isset($this->request->params['form']['idia'])
        ){
            $this->setErrorMessage('Invalid parameters');
            return;
        }

        $path = ltrim(trim($this->request->data['currentPath']), DS);
        $tokens = explode(DS, strtolower($path));

        ($tokens[0] == 'root') && ($tokens = array_slice($tokens, 1, null, true));

        $path = implode(DS, $tokens);
        $fullPath = WWW_FILE_ROOT . strtolower($path);

        if(!is_dir($fullPath)){
            $this->setErrorMessage('Invalid path');
            return;
        }

        if(is_file($fullPath . DS . strtolower($this->request->params['form']['idia']['name']))){
            $this->setErrorMessage('File with similar name already exist');
            return;
        }

        $newFile = new File($fullPath . DS . strtolower($this->request->params['form']['idia']['name']), true );
        $newFile->close();

        $tempFile = new File(($this->request->params['form']['idia']['tmp_name']));
        $tempFile->copy($fullPath . DS .$this->request->params['form']['idia']['name']);
        $tempFile->delete();

        $this->set(array(
            'status' => 'ok',
            "message" => 'successful',
            "_serialize" => array("message", "status")
        ));
    }

    public function default_image(){

        $fullPath = WWW_IMG_ROOT.  "woroIcon.png";

        if (!file_exists($fullPath)){
            $this->setErrorMessage("the following path: " . $fullPath . " does not exist");
            return;
        }

        $this->response->file($fullPath, array('download' => true, 'name' => 'woroArch'));
        return $this->response;
    }

    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow("default_image");
    }
}