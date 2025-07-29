<?php
class ControllerVendorContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('vendor/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vendor/contact');

		$this->getList();
	}

	public function delete() {
		$this->load->language('vendor/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vendor/contact');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $inquiry_id) {
				$this->model_vendor_contact->deleteContact($inquiry_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
		
	protected function getList() {
		if (isset($this->request->get['filter_enqname'])) {
			$filter_enqname = $this->request->get['filter_enqname'];
		} else {
			$filter_enqname = '';
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}
	
		if (isset($this->request->get['filter_product'])) {
			$filter_product = $this->request->get['filter_product'];
		} else {
			$filter_product = null;
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}
						
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'inquiry_id';
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

		$url = '';
		
		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . $this->request->get['filter_enqname'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . $this->request->get['filter_product'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
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
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['reset'] = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'], '', true);
		$data['delete'] = $this->url->link('vendor/contact/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['inquires'] = array();

		$filter_data = array(
			'filter_enqname' => $filter_enqname,
			'filter_customer'=> $filter_customer,
			'filter_product' => $filter_product,
			'filter_name'    => $filter_name,
			'sort'           => $sort,
			'order'          => $order,
			'start'          => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'          => $this->config->get('config_limit_admin')
		);
		
		$this->load->model('vendor/product');	
		$review_total = $this->model_vendor_contact->getTotalContact($filter_data);
		$results      = $this->model_vendor_contact->getContacts($filter_data);

		foreach ($results as $result) {
			
			$sellers = $this->model_vendor_contact->getVendor($result['vendor_id']);
			/* 11 02 2020 sname */
			if(isset($sellers['sname'])){
				$sname = $sellers['sname'];
			} else {
				$sname ='';
			}
			$customers = $this->model_vendor_contact->getCustomer($result['customer_id']);
			if(isset($customers['customername'])){
				$cname = $customers['customername'];
			} else {
				$cname ='Guest';
			}

			$products = $this->model_vendor_product->getProduct($result['product_id']);
			
			if(isset($products['name'])){
				$pname = $products['name'];
			} else {
				$pname ='';
			}

			$data['inquires'][] = array(
				'inquiry_id'  => $result['inquiry_id'],
				'customer_id' => $result['customer_id'],
				'name'  	  => $result['name'],
				'email'   	  => $result['email'],
				'pname'       => $pname,
				'sname'       => $sname,
				'cname'       => $cname,
				'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'status'      => ($result['status'] ? $this->language->get('text_enable') : $this->language->get('text_disable')),
				'date_added'  => $result['date_added'],
				'edit'        => $this->url->link('vendor/contact/edit', 'token=' . $this->session->data['token'] . '&inquiry_id=' . $result['inquiry_id'] . $url, true),
				'view'        => $this->url->link('vendor/contact/view', 'token=' . $this->session->data['token'] . '&inquiry_id=' . $result['inquiry_id'] . $url, true),
				'producturl'        => $this->url->link('vendor/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$data['heading_title'] 	= $this->language->get('heading_title');
		$data['token'] 			= $this->session->data['token'];
		$data['text_list'] 		= $this->language->get('text_list');
		$data['text_view'] 		= $this->language->get('text_view');
		$data['text_no_results']= $this->language->get('text_no_results');
		$data['text_confirm'] 	= $this->language->get('text_confirm');
		$data['text_enable'] 	= $this->language->get('text_enable');
		$data['text_disable'] 	= $this->language->get('text_disable');
		$data['text_select'] 	= $this->language->get('text_select');
		$data['text_none'] 		= $this->language->get('text_none');

		$data['column_name']	= $this->language->get('column_name');
		$data['column_email']	= $this->language->get('column_email');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_customer']= $this->language->get('column_customer');
		$data['column_seller'] 	= $this->language->get('column_seller');
		$data['column_status'] 	= $this->language->get('column_status');
		$data['column_date'] 	= $this->language->get('column_date');
		$data['column_action'] 	= $this->language->get('column_action');	
		
		$data['button_add'] 	= $this->language->get('button_add');
		$data['button_edit'] 	= $this->language->get('button_edit');
		$data['button_delete'] 	= $this->language->get('button_delete');
		$data['button_filter'] 	= $this->language->get('button_filter');
		$data['button_reset'] 	= $this->language->get('button_reset');
		$data['button_view'] 	= $this->language->get('button_view');


		$data['token'] 			= $this->session->data['token'];
		
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

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . $this->request->get['filter_product'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name']     = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_email']    = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . '&sort=email' . $url, true);
		$data['sort_product']  = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . '&sort=product' . $url, true);
		$data['sort_seller']   = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . '&sort=seller' . $url, true);
		$data['sort_customer'] = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_status']   = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);
		$data['sort_date']     = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . '&sort=date' . $url, true);

		$url = '';
		
		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . $this->request->get['filter_enqname'];
		}
		
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}
		
		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . $this->request->get['filter_product'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
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
		$pagination->url = $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($review_total - $this->config->get('config_limit_admin'))) ? $review_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $review_total, ceil($review_total / $this->config->get('config_limit_admin')));
		
		$data['filter_enqname']   = $filter_enqname;
		$data['filter_customer']  = $filter_customer;
		$data['filter_product']   = $filter_product;
		$data['filter_name'] 	  = $filter_name;
		$data['sort'] 			  = $sort;
		$data['order'] 			  = $order;

		if(isset($data['filter_name'])){
			$sellers = $this->model_vendor_contact->getVendor($data['filter_name']);
		}

		if(isset($sellers['sname'])){
			$data['sellername'] = $sellers['sname'];
		} else {
			$data['sellername'] ='';
		}

		if(isset($data['filter_customer'])){
			$customers = $this->model_vendor_contact->getCustomer($data['filter_customer']);
		}
		if(isset($customers['firstname'])){
			$data['customername'] = $customers['firstname'].' '.$customers['lastname'];
		} else {
			$data['customername'] ='';
		}
		
		$this->load->model('vendor/product');
		if(isset($data['filter_product'])){
			$products_info = $this->model_vendor_product->getProduct($data['filter_product']);
		}
		if(isset($products_info['name'])){
			$names = $products_info['name'];
		} else {
			$names = '';
		}
		$data['productname'] = $names;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('vendor/contact_list', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'vendor/contact')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return !$this->error;
	}
	
	public function view() {
		$this->load->language('vendor/contact');
		$this->load->model('vendor/contact');	
		
		$url = '';
				
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('vendor/contact', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$data['tmdmessages']=array();
		
		$message_show = $this->model_vendor_contact->getTmdMessages($this->request->get['inquiry_id']);
		foreach($message_show as $messagesinfo){
			$data['tmdmessages'][]=array(
				'vendor_id'    => $messagesinfo['vendor_id'],
				'customer_id'  => $messagesinfo['customer_id'],
				'message_id'   => $messagesinfo['message_id'],
				'message'      => html_entity_decode($messagesinfo['message'], ENT_QUOTES, 'UTF-8'),
				'filename'     => $messagesinfo['filename'],
				'hreflink'     => $this->url->link('vendor/contact/download','token=' . $this->session->data['token'].'&message_id=' . $messagesinfo['message_id'].$url, true),
				'data_added'   => date('d-M-Y', strtotime($messagesinfo['data_added'])),
			);
		}
		
		$this->document->setTitle($this->language->get('heading_view'));
		$data['heading_view'] 	= $this->language->get('heading_view');
		$data['text_view'] 		= $this->language->get('text_view');
		$data['text_download']  = $this->language->get('text_download');
		$data['token'] 			= $this->session->data['token'];
				
		if (isset($this->request->get['inquiry_id'])) {
			$inquiry_info=$this->model_vendor_contact->getContact($this->request->get['inquiry_id']);
		}
		
		if(isset($inquiry_info['description'])){
			$data['description'] = strtoupper($this->language->get('entry_subject').' : '.$inquiry_info['description']);
		} else {
			$data['description'] = '';
		}

		$url = '';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('vendor/contact_view', $data));
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
		$this->load->model('vendor/contact');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		'filter_enqname' => $filter_enqname,
		'start'            => 0,
		'limit'            => 5
		);
		$enqnames = $this->model_vendor_contact->getContacts($filter_data);
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

	public function download() {
		$this->load->language('tool/download');
		
		$this->load->model('vendor/contact');

		if (isset($this->request->get['inquiry_id'])) {
			$inquiry_id = $this->request->get['inquiry_id'];
		} else {
			$inquiry_id = 0;
		}

		if (isset($this->request->get['message_id'])) {
			$message_id = $this->request->get['message_id'];
		} else {
			$message_id = 0;
		}

		$message_info = $this->model_vendor_contact->getMessageDownload($message_id,$inquiry_id);
		if ($message_info) {
			$file = DIR_DOWNLOAD . $message_info['filename'];
			$mask = '';
			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					if (ob_get_level()) {
						ob_end_clean();
					}
					readfile($file, 'rb');
				}
			} else {
				exit('Error: Headers already sent out!');
			} 
		}
	}

}