<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property Version $Version
 * @property PaginatorComponent $Paginator
 */
class ProductsController extends AppController {


/**
 * todo: validate paging functionality
 * todo: being able to delete a product not in use and decomission it.
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Product->recursive = -1;
        $results = $this->Paginator->paginate();
        $products = array();

        foreach($results as &$item){
            $product = array(
                "id" => bin2hex($item["Product"]["id"]),
                "name" => $item["Product"]["name"],
                "description" => $item["Product"]["description"],
                "announced_date" => $item["Product"]["announced_date"]
            );
            array_push($products, $product);
            unset($item);
        }
		$this->set('products', $products);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($productId = null) {

        if (!isset($productId) && !isset($this->request->params["productId"])){
            throw new NotFoundException(__("Invalid product"));
        }

        if (!isset($productId)){
            $productId = $this->request->params["productId"];
        }

        $id = pack("H*", $productId);

		$options = array(
            "recursive" => 1,
            'conditions' => array('Product.' . $this->Product->primaryKey => $id));
        $foundProduct = $this->Product->find('first', $options);

        if (isset($foundProduct["Version"]) && is_array($foundProduct["Version"])) {
            //$versions = array();

            foreach($foundProduct["Version"] as &$version){
                $version["download_id"] = bin2hex($version["id"]);
                unset($version);
            }

            $product = array_merge($foundProduct["Product"], array("Version" => $foundProduct["Version"]));
        }else{
            $product = $foundProduct["Product"];
        }
        $product["id"] = $productId;

		$this->set('product', $product );
	}


    public function download($versionDownloadId){
        if(! isset($versionDownloadId) || empty($versionDownloadId)){
            throw new NotFoundException("File could not be found");
        }

        $id = pack("H*", $versionDownloadId);

        $this->loadModel("Version");

        if (!$this->Version->exists($id)){
            throw new NotFoundException("Version does not exist");
        }

        $option = array(
            "recursive" => 1,
            "conditions" => array("Version." . $this->Version->primaryKey => $id),
            "fields" => array("Version.id", "Version.path", "Version.download_count", "Product.name")
        );

        $foundVersion = $this->Version->find('first', $option);

        if(!isset($foundVersion) || empty($foundVersion)){

            $this->set("message", "Download could not be completed for the specified version");
            $this->render("/Messages/thanks");
            return;

        }

        $fullPath = WWW_ROOT . "files" . DS . strtolower($foundVersion["Product"]["name"]) . DS . strtolower($foundVersion["Version"]["path"]);

        $file = new File($fullPath, false);

        if (!$file->exists()){
            $this->set("message", "File: ". $file->name(). " does not exist");
            $this->render("/Messages/thanks");
            return;
        }

        $this->Version->set($this->Version->primaryKey, $id);
        if(!$this->Version->saveField("download_count", $foundVersion["Version"]["download_count"] + 1 )){
            $this->set("message", "Download could not be completed for the specified version");
            $this->render("/Messages/thanks");
            return;
        }

        $dirPath = dirname($file->pwd());

        $dirPath = rtrim(mb_stristr( $dirPath, WEBROOT_DIR), DS) . DS;

        $this->_download($file->name(), $file->ext(), $dirPath);
       // return;

       // $test = "file found look at api on how to start file download";
        //$this->set("message", $test);
        //$this->render("/Messages/thanks");

    }

    private function _download($file_name, $extension, $path ) {
        $this->viewClass = 'Media';
        $params = array(
                'id' => $file_name. "." . $extension, //'example.zip'
                'name' => $file_name,
                'download' => true,
                'extension' => $extension,
            'path' => $path);
        $this->set($params);
    }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
        //$this->Paginator = $this->Components->load("Paginator") ;
        $products = array();

        $options = array(
            'recursive' => 2,
            'limit' => 25,
            'order' => array(
                'Product.name' => 'desc'
            ),
            'fields' => array("Product.id", "Product.name", "Product.description", "Product.announced_date" )//, "License.id"
        );
//todo: control field list for associated models

        $this->Paginator->settings = $options;

        try{

            $results = $this->Paginator->paginate('Product');
            foreach($results as &$item){

                $licenseCount = 0;


                $product = array(
                    'id' => bin2hex($item["Product"]['id']),
                    'name' => $item["Product"]['name'],
                    'description' => $item["Product"]['description'],
                    'announced_date' => $item["Product"]['announced_date']
                );

                if (isset($item['Version'])){
                    $product = array_merge($product, array("Version" => $item['Version']));

                    foreach($item['Version'] as $version){
                        $numLicenses = count($version['License']);
                        $licenseCount += $numLicenses;
                    }
                }
                $product = array_merge($product, array("LicenseCount" => $licenseCount));

                array_push($products, $product);
                unset($product);
            }
        }
        catch(NotFoundException $e){
        }

		$this->set('products', $products);
        //todo: in future pull licenses count for product
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {

        $id_bin = pack("H*", $id);

        if (!$this->Product->exists($id_bin)) {
            throw new NotFoundException(__('Invalid product'));
        }

        $options = array(
            'recursive' => 2,
            'conditions' => array('Product.' . $this->Product->primaryKey => $id_bin));
        $foundProduct = $this->Product->find(
            'first', $options);

        $foundProduct['Product']['id'] = $id;

        if (isset($foundProduct['Version'])){
            foreach($foundProduct['Version'] as &$version){
                $version['edit_id'] = bin2hex($version['id']);
                //todo: compute # of valid/currently active licenses and total # of licenses attributed thus far
                unset($version);
            }
        }

        $this->set("product", array_merge($foundProduct['Product'],array("Version" => $foundProduct['Version'])) );
        $this->render('admin_view');
	}

    public function admin_version_add($productId){

        if (! isset($productId) && !isset($this->request->params['named']['productId']))
            throw new NotFoundException(__('Invalid product'));

        if (! isset($productId)){
            $productId = $this->request->params['named']['productId'];
        }

        $id = pack("H*", $productId);

        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }

        if ($this->request->is('post')) {
            $this->loadModel("Version");
            $this->Version->create($this->request->data);
            $this->Version->set("product_id", $id);

            if ($this->Version->validates()) {
                if ($this->Version->save(null, true)) {
                    $this->Session->setFlash(__('The product: ' . $this->request->data['Version']['name'] . ' Edition has been saved.'));
                    return $this->redirect(array('action' => 'view', $productId));
                } else {
                    $errors = $this->Version->validationErrors;
                    $this->Session->setFlash(__('The version could not be saved. Please, try again.<br /> ' . $this->convert_validationErrors_toString($errors)));
                }
            }
            else{
                $errors = $this->Version->validationErrors;
                $this->Session->setFlash(__('The version could not be saved. Please, try again.<br /> ' . $this->convert_validationErrors_toString($errors)));
            }
        }
        $this->set("productId", bin2hex($id));
        $this->render('admin_version_add');
    }

    public function  admin_version_edit($versionId){
        if (! isset($versionId) && !isset($this->request->params['named']['versionId']))
            throw new NotFoundException(__('Invalid product version'));

        if (! isset($versionId)){
            $versionId = $this->request->params['named']['versionId'];
        }

        $id = pack("H*", $versionId);

        $this->loadModel("Version");

        if (!$this->Version->exists($id)) {
            throw new NotFoundException(__('Invalid Product version'));
        }

        if ($this->request->is('post')) {
            $this->Version->id = $id;

            if (
                $this->Version->save(
                    $this->request->data,
                    true,
                    array("product_description_type", "description", "name", "available", "price"))
                )
            {
                $this->Session->setFlash(__('The product version: '. $this->request->data['Version']['name'] .' has been saved.'));
                return $this->redirect(array('admin'=> true,'action' => 'view', $this->request->data['Version']['product_id']));
            } else {
                $errors = $this->Product->validationErrors;
                $this->Session->setFlash(__('The product version could not be saved. Please, try again.<br /> '. $this->convert_validationErrors_toString($errors)));
            }
        }

        $options = array(
            'recursive' => -1,
            'conditions' => array('Version.' . $this->Version->primaryKey => $id));
        $foundVersion = $this->Version->find(
            'first', $options);


        $foundVersion['Version']['req_id'] = $versionId;

        $foundVersion['Version']['id'] = $id;
        $foundVersion['Version']['product_id'] = bin2hex($foundVersion['Version']['product_id']);

        $this->set("version", $foundVersion['Version']);
        $this->set("backlink", $this->referer());

    }

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('The product: '. $this->request->data['Product']['name'] .' has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
                $erros = $this->Product->validationErrors;
				$this->Session->setFlash(__('The product could not be saved. Please, try again.<br /> '. $this->convert_validationErrors_toString($erros)));
			}
		}
        $this->render('admin_add');
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($productId) {

        if (!isset($productId) && !isset($this->request->params["named"]["productId"])){
			throw new NotFoundException(__('Invalid product'));
		}

        if (!isset($productId))
        {
            $productId = $this->request->params["named"]["productId"];
        }

        $id = pack("H*",$productId );

        if (! $this->Product->exists($id)){
            throw new NotFoundException(__("Invalid product not found"));
        }

		if ($this->request->is(array('post', 'put'))) {
            $this->Product->id = $id;
            unset($this->request->data["Product"]["id"]);
			if ($this->Product->save(
                    $this->request->data,
                    true,
                    array("name", "announced_date", "description"))) {
				$this->Session->setFlash(__('The product has been saved.'));
				return $this->redirect(array('action' => 'admin_view', bin2hex($id)));
			} else {
                $errors = $this->Product->validationErrors;
                $this->Session->setFlash(__('The product version could not be saved. Please, try again.<br /> '. $this->convert_validationErrors_toString($errors)));

            }
		} else {
			$options = array(
                'recursive' => -1,
                'conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $results = $this->Product->find('first', $options);
            $results["Product"]["id"] = $productId;
            $this->set("backlink", $this->referer());
			$this->request->data = $results;
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void

	public function admin_delete($id = null) {
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Product->delete()) {
			$this->Session->setFlash(__('The product has been deleted.'));
		} else {
			$this->Session->setFlash(__('The product could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}*/

    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow(array("index", "view"));
    }
}
