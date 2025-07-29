<?php
namespace Opencart\Admin\Controller\Extension\Tmdvendorcustomercommunication\Vendor;
class Product extends \Opencart\System\Engine\Controller { 
	public function index(): void {
		$data['VERSION2']= VERSION;
		
		$this->load->language('extension/tmdmultivendor/vendor/product');

		$this->document->setTitle($this->language->get('heading_title1'));

		$url = '';

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1=' . $this->request->get['filter_vendor1'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/product', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/product|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['copy'] = $this->url->link('extension/tmdmultivendor/vendor/product|copy', 'user_token=' . $this->session->data['user_token']);
		$data['delete']=$this->url->link('extension/tmdmultivendor/vendor/product|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/product ', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/product');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		$this->load->language('extension/tmdmultivendor/vendor/product');

		if (isset($this->request->get['filter_vendor'])) {
			$filter_vendor = $this->request->get['filter_vendor'];
		} else {
			$filter_vendor = '';
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$filter_vendor1 = $this->request->get['filter_vendor1'];
		} else {
			$filter_vendor1 = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = '';
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1=' . $this->request->get['filter_vendor1'];
		}


		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['products'] = [];

		$filter_data = [
			'filter_vendor'   => $filter_vendor,
			'filter_vendor1'  => $filter_vendor1,
			'filter_name'     => $filter_name,
			'filter_model'    => $filter_model,
			'filter_price'    => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'           => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/product');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('tool/image');

		$product_total = $this->model_extension_tmdmultivendor_vendor_product->getTotalProducts($filter_data);
		$results = $this->model_extension_tmdmultivendor_vendor_product->getProducts($filter_data);	

		foreach ($results as $result) {

			if(isset($result['image'])){ 
				if (is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
					$image = $this->model_tool_image->resize(html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'), 40, 40);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', 40, 40);
				}
			}


			$special = false;

			$product_specials = $this->model_extension_tmdmultivendor_vendor_product->getProductSpecials($result['product_id']);

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $this->currency->format($product_special['price'], $this->config->get('config_currency'));

					break;
				}
			}


			if (!$result['status'] || $result['status']==2) {
				$statuss = $this->url->link('extension/tmdmultivendor/vendor/product|status', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'] . $url, true);
			} else{
				$statuss = '';
			}

            if($result['status']==1) {
				$ddstatuss = $this->url->link('extension/tmdmultivendor/vendor/product|disstatus', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'] . $url, true);
			}else{
				$ddstatuss = '';
			}

					
			if($result['status']==2){
				$cstatus= "Approval Pending";
			} elseif($result['status']==1){ 
				$cstatus="Enabled";
			} elseif($result['status']==0){
				$cstatus="Disabled";
			} else {
				$cstatus='';
			}
			
			$sellers = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($result['vendor_id']);
			/* 19 02 2020 */
			if(!empty($sellers['firstname'])){
				$firstname = $sellers['firstname'];
			} else {
				$firstname ='';
			}
			if(!empty($sellers['lastname'])){
				$lastname = $sellers['lastname'];
			} else {
				$lastname ='';
			}
			
			$sellername = $firstname.' '.$lastname;

			$data['products'][] = [
				'product_id' => $result['product_id'],
				'image'      => $image,
				'cstatus'    => $cstatus,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => '$'.$result['price'], $this->config->get('config_currency'),
				'special'    => $special,
				'statuss'	 => $statuss,
				'ddstatuss'	 => $ddstatuss,
				/* 19 02 2020 */		
				'vendorstorename' => $result['vendorstorename'],
				/* 19 02 2020 */		
				'sellername' => $sellername,
				'quantity'   => $result['quantity'],
				'prostatus'   => $result['status'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'sellerpage'       => $this->url->link('extension/tmdmultivendor/vendor/vendor|form', 'user_token=' . $this->session->data['user_token'] . '&vendor_id=' . $result['vendor_id'] . $url, true),
				'edit'       => $this->url->link('extension/tmdmultivendor/vendor/product|form', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'] . $url),
			];
		}



		$url = '';

		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1=' . $this->request->get['filter_vendor1'];
		}

		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		$data['sort_vendor'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=v2p.vendor' . $url);
		$data['sort_storename'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=vd.vendorstorename' . $url);
		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.name' . $url);
		$data['sort_model'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.model' . $url);
		$data['sort_price'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.price' . $url);
		$data['sort_quantity'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.quantity' . $url);
		$data['sort_status'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.status' . $url);
		$data['sort_cstatus'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.cstatus' . $url);
		$data['sort_order'] = $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.sort_order' . $url);

		$url = '';

		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1=' . $this->request->get['filter_vendor1'];
		}


		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $product_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/product|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($product_total - $this->config->get('config_pagination_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $product_total, ceil($product_total / $this->config->get('config_pagination_admin')));


		$data['filter_vendor'] = $filter_vendor;
		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		if(isset($data['filter_vendor'])) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($data['filter_vendor']);
		}

		if(isset($vendor_info['vname'])) {
			$data['sellernme'] = $vendor_info['vname'];
		} else {
			$data['sellernme'] ='';
		}

		return $this->load->view('extension/tmdmultivendor/vendor/product_list', $data);
	}

	public function status(){
		$this->load->language('extension/tmdmultivendor/vendor/product');
		$this->document->setTitle($this->language->get('heading_title1'));
		$this->load->model('extension/tmdmultivendor/vendor/product');
		$statuss = [];
		if (isset($this->request->post['selected'])){
			$status = $this->request->post['selected'];
		} 
		elseif (isset($this->request->get['product_id'])){
			$statuss[] = $this->request->get['product_id'];
		}
		if ($statuss){
			foreach($statuss as $product_id){
				$this->model_extension_tmdmultivendor_vendor_product->status($product_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])){
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])){
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/product', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}
		$this->getList(); 
	}


	public function disstatus(){
		$this->load->language('extension/tmdmultivendor/vendor/product');
		$this->document->setTitle($this->language->get('heading_title1'));
		$this->load->model('extension/tmdmultivendor/vendor/product');

		$statuss = [];

		if (isset($this->request->post['selected'])){
			$status = $this->request->post['selected'];
		} 
		elseif (isset($this->request->get['product_id'])){
			$statuss[] = $this->request->get['product_id'];
		}
		if ($statuss){
			foreach($statuss as $product_id){
				$this->model_extension_tmdmultivendor_vendor_product->DisStatus($product_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['sort'])){
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])){
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/product', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}
		$this->getList(); 
	}

	public function form(): void {
		$data['VERSION2']= VERSION;
		$this->load->language('extension/tmdmultivendor/vendor/product');
		$this->load->model('extension/tmdmultivendor/vendor/product');

		$this->document->setTitle($this->language->get('heading_title1'));

		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['error_upload_size'] = sprintf($this->language->get('error_upload_size'), $this->config->get('config_file_max_size'));

		$data['config_file_max_size'] = ((int)$this->config->get('config_file_max_size') * 1024 * 1024);

		$url = '';

		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1=' . $this->request->get['filter_vendor1'];
		}


		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/product', 'user_token=' . $this->session->data['user_token'] . $url)
		];


		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/product|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/product', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['upload'] = $this->url->link('tool/upload|upload', 'user_token=' . $this->session->data['user_token']);

		if (isset($this->request->get['product_id'])) {
			$data['product_id'] = (int)$this->request->get['product_id'];
		} else {
			$data['product_id'] = 0;
		}

		// If master_id then we need to get the variant info
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		if ($product_id) {
			$this->load->model('extension/tmdmultivendor/vendor/product');

			$product_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($product_id);
		}


		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_extension_tmdmultivendor_vendor_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$data['product_description'] = [];
		}

		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($product_info)) {
			$data['model'] = $product_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($product_info)) {
			$data['upc'] = $product_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($product_info)) {
			$data['ean'] = $product_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($product_info)) {
			$data['jan'] = $product_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($product_info)) {
			$data['isbn'] = $product_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($product_info)) {
			$data['mpn'] = $product_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($product_info)) {
			$data['location'] = $product_info['location'];
		} else {
			$data['location'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = [];
		
		$data['stores'][] = [
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		];
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = [
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			];
		}
		
		if (isset($this->request->post['product_store'])) {
			$data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_store'] = $this->model_extension_tmdmultivendor_vendor_product->getProductStores($this->request->get['product_id']);
		} else {
			$data['product_store'] = [0];
		}

		if (!empty($product_info)) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (!empty($product_info)) {
			$data['price'] = $product_info['price'];
		} else {
			$data['price'] = '';
		}

		// Subscriptions
		$this->load->model('catalog/subscription_plan');
		$this->load->model('catalog/product');

		$data['subscription_plans'] = $this->model_catalog_subscription_plan->getSubscriptionPlans();

		if ($product_id) {
			$data['product_subscriptions'] = $this->model_catalog_product->getSubscriptions($product_id);
		} else {
			$data['product_subscriptions'] = [];
		}


		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (!empty($product_info)) {
			$data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (!empty($product_info)) {
			$data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (!empty($product_info)) {
			$data['quantity'] = $product_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (!empty($product_info)) {
			$data['minimum'] = $product_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (!empty($product_info)) {
			$data['subtract'] = $product_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (!empty($product_info)) {
			$data['stock_status_id'] = $product_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($product_info['status'])) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = true;
		}

		if (!empty($product_info)) {
			$data['weight'] = $product_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (!empty($product_info)) {
			$data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (!empty($product_info)) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}

		if (!empty($product_info)) {
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if (!empty($product_info)) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (!empty($product_info)) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');

		if (!empty($product_info)) {
			$data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		if (isset($product_info['vendor_id'])){
			$data['vendor_id'] = $product_info['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}
		/* 12 02 2020 vname */
		if(!empty($data['vendor_id'])){	
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			$vendor_info=$this->model_extension_tmdmultivendor_vendor_vendor->getVendor($data['vendor_id']);
			if(isset($vendor_info['vname'])){
				$data['vendor']=$vendor_info['vname'];
			} else {
				$data['vendor']='';
			}
		} else {
			$data['vendor']='';
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->get['product_id'])) {
			$categories = $this->model_extension_tmdmultivendor_vendor_product->getProductCategories($this->request->get['product_id']);
		} else {
			$categories = [];
		}

		$data['product_categories'] = [];

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['product_categories'][] = [
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				];
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->get['product_id'])) {
			$filters = $this->model_extension_tmdmultivendor_vendor_product->getProductFilters($this->request->get['product_id']);
		} else {
			$filters = [];
		}

		$data['product_filters'] = [];

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['product_filters'][] = [
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				];
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->get['product_id'])) {
			$product_attributes = $this->model_extension_tmdmultivendor_vendor_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$product_attributes = [];
		}

		$data['product_attributes'] = [];

		foreach ($product_attributes as $product_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);

			if ($attribute_info) {
				$data['product_attributes'][] = [
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
				];
			}
		}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->get['product_id'])) {
			$product_options = $this->model_extension_tmdmultivendor_vendor_product->getProductOptions($this->request->get['product_id']);
		} else {
			$product_options = [];
		}

		$data['product_options'] = [];

		foreach ($product_options as $product_option) {
			$product_option_value_data = [];

			if (isset($product_option['product_option_value'])) {
				foreach ($product_option['product_option_value'] as $product_option_value) {

					$option_value_info = $this->model_catalog_option->getValue($product_option_value['option_value_id']);
					$product_option_value_data[] = [
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'name'                    => $option_value_info['name'],

						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					];
				}
			}

			$data['product_options'][] = [
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => isset($product_option['value']) ? $product_option['value'] : '',
				'required'             => $product_option['required']
			];
		}

		$data['option_values'] = [];

		foreach ($data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($data['option_values'][$product_option['option_id']])) {
					$data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getValues($product_option['option_id']);
				}
			}
		}

      

  
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->get['product_id'])) {
			$product_discounts = $this->model_extension_tmdmultivendor_vendor_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$product_discounts = [];
		}

		$data['product_discounts'] = [];

		foreach ($product_discounts as $product_discount) {
			$data['product_discounts'][] = [
				'customer_group_id' => $product_discount['customer_group_id'],
				'quantity'          => $product_discount['quantity'],
				'priority'          => $product_discount['priority'],
				'price'             => $product_discount['price'],
				'date_start'        => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
				'date_end'          => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
			];
		}

		if (isset($this->request->get['product_id'])) {
			$product_specials = $this->model_extension_tmdmultivendor_vendor_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$product_specials = [];
		}

		$data['product_specials'] = [];

		foreach ($product_specials as $product_special) {
			$data['product_specials'][] = [
				'customer_group_id' => $product_special['customer_group_id'],
				'priority'          => $product_special['priority'],
				'price'             => $product_special['price'],
				'date_start'        => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
				'date_end'          => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
			];
		}
				
		// Image
		if (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Images
		if (isset($this->request->get['product_id'])) {
			$product_images = $this->model_extension_tmdmultivendor_vendor_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = [];
		}

		$data['product_images'] = [];

		foreach ($product_images as $product_image) {
			if (is_file(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
				$thumb = $product_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['product_images'][] = [
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $product_image['sort_order']
			];
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->get['product_id'])) {
			$product_downloads = $this->model_extension_tmdmultivendor_vendor_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$product_downloads = [];
		}

		$data['product_downloads'] = [];

		foreach ($product_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['product_downloads'][] = [
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				];
			}
		}

		if (isset($this->request->get['product_id'])) {
			$products = $this->model_extension_tmdmultivendor_vendor_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = [];
		}

		$data['product_relateds'] = [];

		foreach ($products as $product_id) {
			$related_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($product_id);

			if ($related_info) {
				$data['product_relateds'][] = [
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				];
			}
		}

		if (!empty($product_info)) {
			$data['points'] = $product_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->get['product_id'])) {
			$data['product_reward'] = $this->model_extension_tmdmultivendor_vendor_product->getProductRewards($this->request->get['product_id']);
		} else {
			$data['product_reward'] = [];
		}

		if (isset($this->request->get['product_id'])) {
			$data['product_layout'] = $this->model_extension_tmdmultivendor_vendor_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$data['product_layout'] = [];
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();
		/* new code 09/08/2019 */
		if (isset($this->request->post['product_seo_url'])) {
			$data['product_seo_url'] = $this->request->post['product_seo_url'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_seo_url'] = $this->model_extension_tmdmultivendor_vendor_product->getProductSeoUrls($this->request->get['product_id']);
		} else {
			$data['product_seo_url'] = [];
		}
		/* new code 09/08/2019 */

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/product_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/product');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/product')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if (!isset($this->request->post['vendor_id']) || $this->request->post['vendor_id'] == '') {
			$json['error']['vendor'] = $this->language->get('error_vendor');
		}

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 255)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}

			if ((strlen(trim($value['meta_title'])) < 1) || (strlen($value['meta_title']) > 255)) {
				$json['error']['meta_title_' . $language_id] = $this->language->get('error_meta_title');
			}
		}

		if ((strlen($this->request->post['model']) < 1) || (strlen($this->request->post['model']) > 64)) {
			$json['error']['model'] = $this->language->get('error_model');
		}

		$this->load->model('extension/tmdmultivendor/vendor/product');

		if ($this->request->post['master_id']) {
			$product_options = $this->model_extension_tmdmultivendor_vendor_product->getOptions($this->request->post['master_id']);

			foreach ($product_options as $product_option) {
				if (isset($this->request->post['override']['variant'][$product_option['product_option_id']]) && $product_option['required'] && empty($this->request->post['variant'][$product_option['product_option_id']])) {
					$json['error']['option_' . $product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}
		}

		if ($this->request->post['product_seo_url']) {
			$this->load->model('design/seo_url');

			foreach ($this->request->post['product_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if ($keyword) {
						$seo_url_info = $this->model_design_seo_url->getSeoUrlByKeyword($keyword, $store_id, $language_id);

						if ($seo_url_info && ($seo_url_info['key'] != 'product_id' || !isset($this->request->post['product_id']) || $seo_url_info['value'] != (int)$this->request->post['product_id'])) {
							$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_keyword');
						}
					} else {
						$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_seo');
					}
				}
			}
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}
		if (!$json) {
			if (!$this->request->post['product_id']) {
					// Normal product add
					$json['product_id'] = $this->model_extension_tmdmultivendor_vendor_product->addProduct($this->request->post);				
			} else {
					// Normal product edit
				$this->model_extension_tmdmultivendor_vendor_product->editProduct($this->request->post['product_id'], $this->request->post);
			}			

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/product');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}
		
		

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/product')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/product');

			foreach ($selected as $product_id) {
				$this->model_extension_tmdmultivendor_vendor_product->deleteProduct($product_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function copy(): void {
		$this->load->language('extension/tmdmultivendor/vendor/product');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/product')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/product');

			foreach ($selected as $product_id) {
				$this->model_extension_tmdmultivendor_vendor_product->copyProduct($product_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function report(): void {
		$this->load->language('extension/tmdmultivendor/vendor/product');

		$this->response->setOutput($this->getReport());
	}

	public function getReport(): string {
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['reports'] = [];

		$this->load->model('extension/tmdmultivendor/vendor/product');
		$this->load->model('customer/customer');
		$this->load->model('setting/store');

		$results = $this->model_extension_tmdmultivendor_vendor_product->getReports($product_id, ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$store_info = $this->model_setting_store->getStore($result['store_id']);

			if ($store_info) {
				$store = $store_info['name'];
			} elseif (!$result['store_id']) {
				$store = $this->config->get('config_name');
			} else {
				$store = '';
			}

			$data['reports'][] = [
				'ip'         => $result['ip'],
				'store'      => $store,
				'country'    => $result['country'],
				'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added']))
			];
		}

		$report_total = $this->model_extension_tmdmultivendor_vendor_product->getTotalReports($product_id);

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $report_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/product|report', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $product_id . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($report_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($report_total - 10)) ? $report_total : ((($page - 1) * 10) + 10), $report_total, ceil($report_total / 10));

		return $this->load->view('extension/tmdmultivendor/vendor/product_report', $data);
	}

	public function autocomplete(): void {
		$json = [];

		if (isset($this->request->get['filter_vendor'])) {
			$filter_vendor = $this->request->get['filter_vendor'];
		} else {
			$filter_vendor = '';
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$filter_vendor1 = $this->request->get['filter_vendor1'];
		} else {
			$filter_vendor1 = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = 5;
		}

		$frequencies = [
			'day'        => $this->language->get('text_day'),
			'week'       => $this->language->get('text_week'),
			'semi_month' => $this->language->get('text_semi_month'),
			'month'      => $this->language->get('text_month'),
			'year'       => $this->language->get('text_year'),
		];

		$filter_data = [
			'filter_vendor'=> $filter_vendor,
			'filter_vendor1'=> $filter_vendor1,
			'filter_name'  => $filter_name,
			'filter_model' => $filter_model,
			'start'        => 0,
			'limit'        => $limit
		];

		$this->load->model('extension/tmdmultivendor/vendor/product');
		$this->load->model('catalog/option');
		$this->load->model('catalog/product');
		$this->load->model('catalog/subscription_plan');

		$results = $this->model_extension_tmdmultivendor_vendor_product->getProducts($filter_data);

		foreach ($results as $result) {
			$option_data = [];

			$product_options = $this->model_catalog_product->getOptions($result['product_id']);

			foreach ($product_options as $product_option) {
				$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

				if ($option_info) {
					$product_option_value_data = [];

					foreach ($product_option['product_option_value'] as $product_option_value) {
						$option_value_info = $this->model_catalog_option->getValue($product_option_value['option_value_id']);

						if ($option_value_info) {
							$product_option_value_data[] = [
								'product_option_value_id' => $product_option_value['product_option_value_id'],
								'option_value_id'         => $product_option_value['option_value_id'],
								'name'                    => $option_value_info['name'],
								'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
								'price_prefix'            => $product_option_value['price_prefix']
							];
						}
					}

					$option_data[] = [
						'product_option_id'    => $product_option['product_option_id'],
						'product_option_value' => $product_option_value_data,
						'option_id'            => $product_option['option_id'],
						'name'                 => $option_info['name'],
						'type'                 => $option_info['type'],
						'value'                => $product_option['value'],
						'required'             => $product_option['required']
					];
				}
			}

			$subscription_data = [];

			$product_subscriptions = $this->model_catalog_product->getSubscriptions($result['product_id']);

			foreach ($product_subscriptions as $product_subscription) {
				$subscription_plan_info = $this->model_catalog_subscription_plan->getSubscriptionPlan($product_subscription['subscription_plan_id']);

				if ($subscription_plan_info) {
					$subscription_data[] = [
						'subscription_plan_id' => $subscription_plan_info['subscription_plan_id'],
						'name'                 => $subscription_plan_info['name']
					];
				}
			}
			$json[] = [
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				];
			}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
