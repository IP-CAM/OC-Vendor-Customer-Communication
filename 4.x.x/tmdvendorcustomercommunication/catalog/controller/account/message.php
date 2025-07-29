<?php
namespace Opencart\Catalog\Controller\Extension\Tmdvendorcustomercommunication\Account;
class Message extends \Opencart\System\Engine\Controller {
    public function index() {

        $this->load->language('extension/tmdvendorcustomercommunication/account/message');
        $this->load->model('extension/tmdvendorcustomercommunication/account/message');
        
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/message', '', true);
            $this->response->redirect($this->url->link('account/login', '', true));
        }

        if (isset($this->request->get['filter_inquiry_id'])) {
            $filter_inquiry_id = $this->request->get['filter_inquiry_id'];
        } else {
            $filter_inquiry_id = '';
        }

        if (isset($this->request->get['filter_product'])) {
            $filter_product = $this->request->get['filter_product'];
        } else {
            $filter_product = '';
        }

        if (isset($this->request->get['filter_product_id'])) {
            $filter_product_id = $this->request->get['filter_product_id'];
        } else {
            $filter_product_id = '';
        }


        if (isset($this->request->get['filter_customer'])) {
            $filter_customer = $this->request->get['filter_customer'];
        } else {
            $filter_customer = '';
        }
        
        if (isset($this->request->get['filter_productvalue'])) {
            $filter_productvalue = $this->request->get['filter_productvalue'];
        } else {
            $filter_productvalue = '';
        }
        
        
        if (isset($this->request->get['filter_enqname'])) {
            $filter_enqname = $this->request->get['filter_enqname'];
        } else {
            $filter_enqname = '';
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = '';
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = '';
        }

        $url = '';

        if (isset($this->request->get['filter_productvalue'])) {
            $url .= '&filter_productvalue=' . urlencode(html_entity_decode($this->request->get['filter_productvalue'], ENT_QUOTES, 'UTF-8'));
        }   

        if (isset($this->request->get['filter_enqname'])) {
            $url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
        }


        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product'])) {
            $url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product_id'])) {
            $url .= '&filter_product_id=' . urlencode(html_entity_decode($this->request->get['filter_product_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        $this->document->setTitle($this->language->get('heading_title'));
        


        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'language=' . $this->config->get('config_language'))
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/tmdvendorcustomercommunication/account/message', 'language=' . $this->config->get('config_language'))
        ];

        $data['language'] = $this->config->get('config_language');
        
        $data['list'] = $this->getList();

        $data['reset'] = $this->url->link('extension/tmdvendorcustomercommunication/account/message', 'language=' . $this->config->get('config_language'));

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['footer'] = $this->load->controller('common/footer');

        
        $this->response->setOutput($this->load->view('extension/tmdvendorcustomercommunication/account/message', $data));
    }

    public function list(): void {
        $this->load->language('extension/tmdvendorcustomercommunication/account/message');

        $this->response->setOutput($this->getList());
    }

    protected function getList() {
        if (isset($this->request->get['filter_inquiry_id'])) {
            $filter_inquiry_id = $this->request->get['filter_inquiry_id'];
        } else {
            $filter_inquiry_id = '';
        }

        if (isset($this->request->get['filter_product_id'])) {
            $filter_product_id = $this->request->get['filter_product_id'];
        } else {
            $filter_product_id = '';
        }

        if (isset($this->request->get['filter_product'])) {
            $filter_product = $this->request->get['filter_product'];
        } else {
            $filter_product = '';
        }

        if (isset($this->request->get['filter_customer'])) {
            $filter_customer = $this->request->get['filter_customer'];
        } else {
            $filter_customer = '';
        }
        
        if (isset($this->request->get['filter_productvalue'])) {
            $filter_productvalue = $this->request->get['filter_productvalue'];
        } else {
            $filter_productvalue = '';
        }
                
        if (isset($this->request->get['filter_enqname'])) {
            $filter_enqname = $this->request->get['filter_enqname'];
        } else {
            $filter_enqname = '';
        } 
        if (isset($this->request->get['filter_vendor'])) {
            $filter_vendor = $this->request->get['filter_vendor'];
        } else {
            $filter_vendor = '';
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = '';
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = '';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'r.date_added';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit']) && (int)$this->request->get['limit']) {
            $limit = (int)$this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_pagination');
        }

        $url = '';

        if (isset($this->request->get['filter_productvalue'])) {
            $url .= '&filter_productvalue=' . urlencode(html_entity_decode($this->request->get['filter_productvalue'], ENT_QUOTES, 'UTF-8'));
        }   

        if (isset($this->request->get['filter_enqname'])) {
            $url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_vendor'])) {
            $url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
        }


        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product'])) {
            $url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product_id'])) {
            $url .= '&filter_product_id=' . urlencode(html_entity_decode($this->request->get['filter_product_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }


        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'language=' . $this->config->get('config_language'))
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/tmdvendorcustomercommunication/account/message', 'language=' . $this->config->get('config_language'))
        ];

        $data['reset'] = $this->url->link('extension/tmdvendorcustomercommunication/account/message', 'language=' . $this->config->get('config_language'));

        $data['enquires'] = array();

        $filter_data = array(
            'vendor_id'         => $this->vendor->getId(),
            'filter_inquiry_id' => $filter_inquiry_id,
            'filter_productvalue'=> $filter_productvalue,
            'filter_product_id'    => $filter_product_id,
            'filter_product'    => $filter_product,
            'filter_customer'   => $filter_customer,
            'filter_enqname'    => $filter_enqname,
            'filter_vendor'    => $filter_vendor,
            'filter_date_added' => $filter_date_added,
            'sort'              => $sort,
            'order'             => $order,
            'start'               => ($page - 1) * $limit,
            'limit'               => $limit
        );

        $this->load->model('extension/tmdmultivendor/vendor/product');
        $this->load->model('extension/tmdvendorcustomercommunication/account/message');
        $review_total = $this->model_extension_tmdvendorcustomercommunication_account_message->getTotalgetEnquiries($filter_data);
        $results = $this->model_extension_tmdvendorcustomercommunication_account_message->getEnquiries($filter_data);
        $vendor_id= $this->vendor->getId();     
        foreach ($results as $result) {
            $product_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($result['product_id'], $vendor_id);
            if(!empty($product_info)){
                $pname = $product_info['name'];
            } else {
                $pname = '';
            }

            $customer_info = $this->model_extension_tmdvendorcustomercommunication_account_message->getCustomer($result['customer_id']);

            if(!empty($customer_info['firstname'])){
                $cname = $customer_info['firstname'].' '.$customer_info['lastname'];
            } else {
                $cname = $this->language->get('text_guest');
            }

            if(isset($customer_info['email'])){
                $cemail = $customer_info['email'];
            } else {
                $cemail ='';
            }

            if(isset($customer_info['telephone'])){
                $ctelephone = $customer_info['telephone'];
            } else {
                $ctelephone ='';
            }


         

            $data['enquires'][] = array(
                'inquiry_id'   => $result['inquiry_id'],
                'customer_id'  => $result['customer_id'],
                'name'         => $result['name'],
                'email'        => $cemail,
                'telephone'    => $ctelephone,
                'pname'        => $pname,
                'cname'        => $cname,
                'description'  => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
                'status'       => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                'date_added'   => $result['date_added'],
                'view'         => $this->url->link('extension/tmdvendorcustomercommunication/account/message_detail','&inquiry_id=' . $result['inquiry_id']),
                'producturl'   =>  $this->url->link('product/product', 'language=' . $this->config->get('config_language') . '&product_id=' . $result['product_id'])
            );
            // print_r($data['enquires']);die();
        }

        $data['module_status'] = $this->config->get('module_tmdcommunication_setting_status');
        if($data['module_status']==1) {
            $data['customer_info'] = $this->config->get('module_tmdcommunication_setting_v_info');
        }

        $data['language'] = $this->config->get('config_language');
       
        
        $data['heading_title'] = $this->language->get('heading_title');

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';
        if (isset($this->request->get['filter_inquiry_id'])) {
            $url .= '&filter_inquiry_id=' . urlencode(html_entity_decode($this->request->get['filter_inquiry_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product'])) {
            $url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }
        
        
        if (isset($this->request->get['filter_productvalue'])) {
            $url .= '&filter_productvalue=' . urlencode(html_entity_decode($this->request->get['filter_productvalue'], ENT_QUOTES, 'UTF-8'));
        }
        
        
        if (isset($this->request->get['filter_enqname'])) {
            $url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_vendor'])) {
            $url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
        }
        


        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


        $url = '';
        if (isset($this->request->get['filter_inquiry_id'])) {
            $url .= '&filter_inquiry_id=' . urlencode(html_entity_decode($this->request->get['filter_inquiry_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product'])) {
            $url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_productvalue'])) {
            $url .= '&filter_productvalue=' . urlencode(html_entity_decode($this->request->get['filter_productvalue'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_enqname'])) {
            $url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
        } 
         if (isset($this->request->get['filter_vendor'])) {
            $url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
        }
        

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $data['pagination'] = $this->load->controller('common/pagination', [
            'total' => $review_total,
            'page'  => $page,
            'limit' => $limit,
            'url'   => $this->url->link('extension/tmdvendorcustomercommunication/account/message', 'language=' . $this->config->get('config_language') .  $url . '&page={page}')
        ]);

        $data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($review_total - $limit)) ? $review_total : ((($page - 1) * $limit) + $limit), $review_total, ceil($review_total / $limit));


        $vendor_id= $this->vendor->getId();
        
        $data['filter_product'] = $filter_product;
        $data['filter_product_id'] = $filter_product_id;
        $data['filter_inquiry_id'] = $filter_inquiry_id;
        $data['filter_customer'] = $filter_customer;
        $data['filter_enqname'] = $filter_enqname;
        $data['filter_vendor'] = $filter_vendor;
        $data['filter_status'] = $filter_status;
        $data['filter_date_added'] = $filter_date_added;
        
                
        $this->load->model('extension/tmdmultivendor/vendor/product');
        if(isset($data['filter_product'])){
            $products_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($data['filter_product'],$vendor_id);
        }

        if(isset($products_info['name'])){
            $names = $products_info['name'];
        } else {
            $names = '';
        }
        $data['productname'] = $names;

        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['vendor2customer'] = $this->config->get('vendor_vendor2customer');
        

        return $this->load->view('extension/tmdvendorcustomercommunication/vendor/message_list', $data);
    }

    public function autocomplete(){
        
        if (isset($this->request->get['filter_enqname'])) {
            $filter_enqname = $this->request->get['filter_enqname'];
        } else {
            $filter_enqname = '';
        }
    
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->load->model('extension/tmdvendorcustomercommunication/account/message');
            
        $filter_data = array(
        'sort'  => $sort,
        'order' => $order,
        'filter_enqname' => $filter_enqname,
        'start'            => 0,
        'limit'            => 5
        );
        $enqnames = $this->model_extension_tmdvendorcustomercommunication_account_message->getEnquiries($filter_data);
        foreach ($enqnames as $enqname) {

        $json[] = array(
        'inquiry_id'  => $enqname['inquiry_id'],
        'name'              => strip_tags(html_entity_decode($enqname['name'], ENT_QUOTES, 'UTF-8'))
        );
        }
        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }  
    public function vendorautocomplete() {
        $json = array();
        if (isset($this->request->get['filter_vendor'])) {
            $filter_vendor = $this->request->get['filter_vendor'];
        } else {
            $filter_vendor = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $this->load->model('extension/tmdvendorcustomercommunication/vendor/message');
        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'filter_vendor' => $filter_vendor,
            'start' => 0,
            'limit' => 5
        );
        $results = $this->model_extension_tmdmultivendorcommunication_vendor_message->getVendors($filter_data);
        foreach ($results as $result) {
            $json[] = array(
                'vendor_id' => $result['vendor_id'],
                'name' => strip_tags(html_entity_decode($result['firstname'] . ' ' . $result['lastname'], ENT_QUOTES, 'UTF-8'))
            );
        }


        $sort_order = array();
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    public function Accountaccountmenu(string &$route, array &$args, mixed &$output): void{
        $this->load->language('extension/tmdvendorcustomercommunication/account/message');
        $args['messagedetail'] = $this->url->link('extension/tmdvendorcustomercommunication/account/message', '', true);
        // TMD Vendor Communication
            $template_buffer = $this->getTemplateBuffer($route,$output);
        $find='{{ content_bottom }}</div>';
        $replace='<!-- TMD Vendor Communication-->
          <h2>{{ text_my_messagedetail }}</h2>
          <ul class="list-unstyled">
            <li><a href="{{ messagedetail }}">{{ text_messagedetail }}</a></li>
          </ul>
          <!-- TMD Vendor Communication-->
          {{ content_bottom }}</div>';
        $output = str_replace( $find, $replace, $template_buffer ); 

            
    }
    protected function getTemplateBuffer( $route, $event_template_buffer ) {
        // if there already is a modified template from view/*/before events use that one
        if ($event_template_buffer) {
            return $event_template_buffer;
        }

        // load the template file (possibly modified by ocmod and vqmod) into a string buffer
        
            if ($this->config->get('config_theme') == 'default') {
                $theme = $this->config->get('theme_default_directory');
            } else {
                $theme = $this->config->get('config_theme');
            }
              $dir_template = DIR_TEMPLATE ;
            
        
        $template_file = $dir_template . $route . '.twig';
        if (file_exists( $template_file ) && is_file( $template_file )) {
            
            return file_get_contents( $template_file );
        }
        
        $dir_template = DIR_TEMPLATE . 'default/template/';
        $template_file = $dir_template . $route . '.twig';
        if (file_exists( $template_file ) && is_file( $template_file )) {
            
            return file_get_contents( $template_file );
        }
        trigger_error("Cannot find template file for route '$route'");
        exit;
    }
    
   

}
