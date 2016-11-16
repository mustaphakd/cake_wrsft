<?php

/**
 * Created by PhpStorm.
 * User: musta
 * Date: 11/15/2016
 * Time: 11:02 PM
 */

App::uses('AppController', 'Controller');



/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 */

class ArticlesController extends  AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public function latest(){

        $options = array(
            'recursive' => 0,
            "fields" => array("title", "content", "image_path" ),
            "conditions" => array("Article.enabled" => true),
            "order" => array("Article.created" => "desc")
        );

        $foundArticle = $this->Article->find('first', $options);

        $this->set(array(
            'status' => 'ok',
            "article" => $foundArticle,
            "_serialize" => array("article","status")
        ));
    }

    public  function admin_index(){
        $options = array(
            'recursive' => 1,
            'fields' => array("Article.id", "Article.title", "Article.enabled", "Article.modified", "User.name"),
            "order" => array("Article.created" => "desc"),
            'limit' => 5
        );

        $articles = array();

        try{

            $results = $this->Paginator->paginate('Article');
            foreach($results as &$item){


                $article = array(
                    'id' => bin2hex($item["Article"]['id']),
                   // 'content' => $item["Article"]['content'],
                    'enabled' => $item["Article"]['enabled'],
                    'title' => $item["Article"]['title'],
                    'modified' => $item["Article"]['modified'],
                    //'image_path' => $item["Article"]['image_path']
                );

                if (isset($item["Article"]['User'])){
                    $article["user_name"] = $item["Article"]['User']["name"];
                }

                array_push($articles, $article);
                unset($message);
            }
        }
        catch(NotFoundException $e){
            $this->Session->setFlash(__('Articles not found ' . $e ));
        }
        $this->set('articles', $articles);
    }

    public function admin_create(){

        if ($this->request->is("post")){
            $this->Article->create($this->request->data);

            /*if($this->Article->validates()){
                if ($this->Article->save(null, true)) {
                    $this->Session->setFlash(__('The Article: ' . $this->request->data['Article']['title'] . ' has been saved.'));
                    return $this->redirect(array('action' => 'admin_detail', bin2hex($this->Article->id)));
                } else {
                    $errors = $this->Version->validationErrors;
                    $this->Session->setFlash(__('The version could not be saved. Please, try again.<br /> ' . $this->convert_validationErrors_toString($errors)));
                }
            }
            else
            {
                $errors = $this->Article->validationErrors;
                $this->Session->setFlash(__('The Article could not be saved. Please, try again.<br /> ' . $this->convert_validationErrors_toString($errors)));
            }*/
            return;
        }

        $this->request->data = array(
            "Article.title" => " ",
            "Article.content" => " ",
            "Article.image_path" => " ",
            "Article.enabled" => " "
        );
    }

    public function admin_detail($articleId){
        $id = pack("H*", $articleId);

        if (! $this->Article->exists($id)){
            throw  new UnexpectedValueException("Article not found");
        }

        $foundArticle = $this->FindArticle($id);
        $this->request->data = $foundArticle;
    }

    public function admin_edit($articleId){
        $id = unpack("H*", $articleId);

        if (! $this->Article->exists($id)){
            throw  new UnexpectedValueException("Article not found");
        }

        if ($this->request->is('post')){

            $this->Article->id = $id;
            if ($this->Article->save($this->request->data, true, array("title", "content", "image_path", "enabled"))) {
                $this->Session->setFlash(__('The Article: ' . $this->request->data['Article']['title'] . ' has been saved.'));
                return $this->redirect(array('action' => 'admin_detail', bin2hex($this->Article->id)));
            } else {
                $errors = $this->Version->validationErrors;
                $this->Session->setFlash(__('The version could not be saved. Please, try again.<br /> ' . $this->convert_validationErrors_toString($errors)));
            }

            return;
        }

        $foundArticle = $this->FindArticle($id);
        $this->request->data = $foundArticle;
    }

    public function admin_delete($articleId){

        $id = pack("H*", $articleId);

        if (! $this->Article->exists($id)){
            throw  new UnexpectedValueException("Article not found");
        }

        $this->Article->delete($id);
        $this->Session->setFlash("Article with id: $id has been deleted");

        $redirect = Router::url(array(
            "action" => "admin_index"
        ));

        $this->redirect($redirect);
    }

    private function FindArticle($articleId){

        $options = array(
            "recursive" => 1,
            "conditions" => array(
                "Article." . $this->Article->primaryKey => $articleId
            )
        );

        return $this->Article->find("first", $options);
    }

    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow(array("latest"));

        $this->WrsftAuth = $this->Components->load('WrsftAuth');
        $this->WrsftAuth->initialize($this);
        $this->WrsftAuth->ConstraintRolesAction(
            array(
                'admin'   => array('admin_index', 'admin_create', 'admin_detail', 'admin_edit', 'admin_delete'),
                'manager' => array('admin_index', 'admin_create', 'admin_detail', 'admin_edit'),
                'support' => array('admin_index', 'admin_create', 'admin_detail')
            )
        );
    }
}