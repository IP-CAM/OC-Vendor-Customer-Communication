<?php
class ControllerVendorMessage  extends Controller {
	private $error = array();

	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('vendor/message', '', true);
			$this->response->redirect($this->url->link('vendor/login', '', true));
		}
		$this->load->language('vendor/message');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vendor/message');

		$this->getList();
	}

	protected function getList() {
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('vendor/message')
		);

		$data['reset'] = $this->url->link('vendor/message');
		$data['enquires'] = array();

		$filter_data = array(
			'vendor_id' 		=> $this->vendor->getId(),
			'filter_inquiry_id' => $filter_inquiry_id,
			'filter_productvalue'=> $filter_productvalue,
			'filter_product'    => $filter_product,
			'filter_customer'   => $filter_customer,
			'filter_enqname'    => $filter_enqname,
			'filter_date_added' => $filter_date_added,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);

		$this->load->model('vendor/product');
		$this->load->model('vendor/message');
		$review_total = $this->model_vendor_message->getTotalgetEnquiries($filter_data);
		$results = $this->model_vendor_message->getEnquiries($filter_data);
		$vendor_id= $this->vendor->getId();		
		foreach ($results as $result) {
			$product_info = $this->model_vendor_product->getProduct($result['product_id'], $vendor_id);
			if(!empty($product_info)){
				$pname = $product_info['name'];
			} else {
				$pname = '';
			}

			$customer_info = $this->model_vendor_message->getCustomer($result['customer_id']);

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
				'customer_id'   => $result['customer_id'],
				'name'         => $result['name'],
				'email'        => $cemail,
				'telephone'    => $ctelephone,
				'pname'        => $pname,
				'cname'        => $cname,
				'description'  => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'status'       => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'   => $result['date_added'],
				'view'         => $this->url->link('vendor/message_detail', '&inquiry_id=' . $result['inquiry_id']),
				'producturl'   =>  $this->url->link('product/product','product_id=' . $result['product_id'] . $url, true)
			);
		}
		
		$data['module_status'] = $this->config->get('tmdcommunication_setting_status');
		if($data['module_status']==1) {
			$data['customer_info'] = $this->config->get('tmdcommunication_setting_v_info');
		}

		$data['heading_title']      = $this->language->get('heading_title');

		$data['text_select']        = $this->language->get('text_select');
		$data['text_list']          = $this->language->get('text_list');
		$data['text_no_results']    = $this->language->get('text_no_results');
		$data['text_confirm']       = $this->language->get('text_confirm');
		$data['text_enabled']       = $this->language->get('text_enabled');
		$data['text_disabled']      = $this->language->get('text_disabled');
		$data['text_none']          = $this->language->get('text_none');

		$data['text_filter']        = $this->language->get('text_filter');
		$data['text_reset']         = $this->language->get('text_reset');
		$data['text_view'] 		    = $this->language->get('text_view');
		$data['text_select'] 	    = $this->language->get('text_select');


		$data['column_name']	    = $this->language->get('column_name');
		$data['column_email']	    = $this->language->get('column_email');
		$data['column_product']     = $this->language->get('column_product');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_customer']    = $this->language->get('column_customer');
		$data['column_seller'] 	    = $this->language->get('column_seller');
		$data['column_status'] 	    = $this->language->get('column_status');
		$data['column_date_added']  = $this->language->get('column_date_added');
		$data['column_inquiry_id']  = $this->language->get('column_inquiry_id');
		$data['column_action'] 	    = $this->language->get('column_action');

		$data['entry_name']	        = $this->language->get('entry_name');
	    $data['entry_inquiry_id']   = $this->language->get('entry_inquiry_id');
		$data['entry_email']	    = $this->language->get('entry_email');
		$data['entry_product']      = $this->language->get('entry_product');
		$data['entry_description']  = $this->language->get('entry_description');
		$data['entry_customer']     = $this->language->get('entry_customer');
		$data['entry_seller'] 	    = $this->language->get('entry_seller');
		$data['entry_status'] 	    = $this->language->get('entry_status');
		$data['entry_date_added']   = $this->language->get('entry_date_added');	
		
		$data['button_add'] 	    = $this->language->get('button_add');
		$data['button_edit'] 	    = $this->language->get('button_edit');
		$data['button_delete'] 	    = $this->language->get('button_delete');
		$data['button_filter'] 	    = $this->language->get('button_filter');
		$data['button_reset'] 	    = $this->language->get('button_reset');
		$data['button_view'] 	    = $this->language->get('button_view');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

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

		$data['sort_name']       = $this->url->link('vendor/message', 'sort=name' . $url, true);
		$data['sort_inquiry_id'] = $this->url->link('vendor/message', 'sort=inquiry_id' . $url, true);
		$data['sort_email']      = $this->url->link('vendor/message', 'sort=email' . $url, true);
		$data['sort_product']    = $this->url->link('vendor/message','sort=product' . $url, true);
		$data['sort_customer']   = $this->url->link('vendor/message','sort=customer' . $url, true);
		$data['sort_status']     = $this->url->link('vendor/message','sort=status' . $url, true);
		$data['sort_date_added'] = $this->url->link('vendor/message','sort=date_added' . $url, true);

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

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('vendor/message',$url . 'page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($review_total - $this->config->get('config_limit_admin'))) ? $review_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $review_total, ceil($review_total / $this->config->get('config_limit_admin')));
		$vendor_id= $this->vendor->getId();
		
		$data['filter_product']    = $filter_product;
		$data['filter_inquiry_id'] = $filter_inquiry_id;
		$data['filter_customer']   = $filter_customer;
		$data['filter_enqname']    = $filter_enqname;
		$data['filter_status']     = $filter_status;
		$data['filter_date_added'] = $filter_date_added;
		
		$this->load->model('vendor/product');
				
		$this->load->model('vendor/product');
		if(isset($data['filter_product'])){
			$products_info = $this->model_vendor_product->getProduct($data['filter_product'],$vendor_id);
		}

		if(isset($products_info['name'])){
			$names = $products_info['name'];
		} else {
			$names = '';
		}
		$data['productname'] = $names;

		$data['sort']            = $sort;
		$data['order']           = $order;
		$data['vendor2customer'] = $this->config->get('vendor_vendor2customer');
		$data['header']          = $this->load->controller('vendor/header');
		$data['column_left']     = $this->load->controller('vendor/column_left');
		$data['footer']          = $this->load->controller('vendor/footer');

		
		$this->response->setOutput($this->load->view('vendor/message', $data));
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
		$this->load->model('vendor/message');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		'filter_enqname' => $filter_enqname,
		'start'            => 0,
		'limit'            => 5
		);
		$enqnames = $this->model_vendor_message->getEnquiries($filter_data);
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

}
