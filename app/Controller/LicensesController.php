<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 1/1/2002
 * Time: 12:42 AM
 */


App::uses('AppController', 'Controller');

/**
 *Licenses Controller
 *
 * @property License $License
 * @property Product $Product
 * @property Version $Version
 */

// one license per version for user

class LicensesController extends AppController{

    public $uses = array('Product', 'Version', 'License');
    public $components = array('Paginator');


    /**
     *
     * Session key
     *
     * @field
     *
     * */
    public static $_sessionKey = 'Licenses.PurKey';

    public function index(){

        if ($this->Auth->user() == null){
            throw new UnauthorizedException();
        }

        // = new DateTime('now', new DateTimeZone('UTC'));

        $options = array(
            'recursive' => 1,
            'limit' => 25,
            'order' => array(
                'License.expiration_date' => 'desc'
            ),
            'conditions' => array(
                'License.user_id' => $this->Auth->user('id')
            )
        );
        $this->Paginator->settings = $options;

        $results = $this->Paginator->paginate('License');
        $licenses = array();
        $licensesExist = false;


        // todo: see if payments get pulled to get last payment
        //todo:  are frames pulled ??? to get perhaps latest expiration date
        if (isset($results['License']) && count($results['License']) > 0){
            $licensesExist = true;

            foreach( $results['License'] as $item){
                $license = array(
                    'product_name' => $item['Product']['name'],
                    'product_version' => $item['Version']['name'],
                    'license_id' => bin2hex($item['License']['id']),
                    'product_description' => $item['Product']['description'],
                    'license_expiration' => $item['License']['expiration_date'],
                    'last_payment' => (new DateTime('now', new DateTimeZone('UTC')))
                );
                array_push($licenses, $license);
            }
        }


        $this->set(
            'licenses',
            ($licensesExist == true ? $licenses : null) );

        //todo: see message views to get inspired for  the table format. also use popup
        //License['']

    }

    public function extend(){
        //make use of licenseFrame
    }

    public function renew(){
        //make use of licenseFrame
    }

    public function inventory(){

        if ($this->request->is('post')) {
            // make use of licenseFrame
            // forward to purchase

            if (isset($this->request->data['Version']['id'])){

                $id = pack("H*", $this->request->data['Version']['id']);

                if (!$this->Version->exists($id)){
                    throw new InvalidArgumentException("Provide Version id does not exist: <br />". $id);
                }
            }

            $options = array(
                'recursive' => 1,
                'conditions' => array(
                    'Version.'.$this->Version->primaryKey => $id
                )
            );

            $result = $this->Version->find('first', $options);

            $item = array( //queued item
                'title' => $result['Product']['name'].' '. $result['Version']['name']. ' Edition' . ' ' . $result['Version']['build'],
                'description' => $result['Version']['description'],
                'price' => $result['Version']['price'],
                'context' => '' //license frame id
            );

            $this->Session->write(self::$_sessionKey, $item);

            $href = Router::url(
                array(
                    "controller" => "Payments",
                    "action" => "cashier"),
                true);
            unset($this->request->data);

            $this->redirect($href);
        }

        $options = array(
            'recursive' => 1,
            'conditions' => array(
                'Version.available' => true
            )
        );

        $foundVersions = $this->Version->find('all', $options);

        $licenseOptions = array(
            'recursive' => 1,
            'conditions' => array(
                'License.user_id' => $this->Auth->user('id')
            )
        );

        $userLicenses = $this->License->find('all', $licenseOptions);
        $userLicenseVersions = array();
        $arrayLength = count($foundVersions) - 1;

        for($i = $arrayLength; $i >= 0; $i--){
            $inUse = false;

            foreach ($userLicenses as $item) {

                if ( $foundVersions[$i]['Version']['id'] == $item['Version']['id'] ){
                    $inUse = true;
                    break;
                }
            }

            if (!$inUse)
                $foundVersions[$i]['Version']['inUser'] = true;
        }
        $this->set('versions', $foundVersions);
    }

    public function purchase(){
        //make use of licenseFrame
        /*
         * GET:  display purchaseable licenses
         *
         * POST: validate inputs, create frame but do not modify license table
         *      put frame in unaproved state.
         *
         *      create 4 client-side encrypted session vars: one to signal authentic origins.
         *                                 on the other-end, licenseFrame should be queried to validate id
         *                             second is string defining controller and action to call
         *                             third : $amount
         *                             fourth: description
         *
         *
         */

    }

    public function admin_index(){
        //see list of currently purchased licenses
    }

    public function admin_view(){
        //see the detail frames for each license
    }


    public function beforeFilter(){
        parent::beforeFilter();

        //$this->Auth->allow();
    }
}