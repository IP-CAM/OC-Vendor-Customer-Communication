<?php
namespace Opencart\Admin\Controller\Extension\Tmdvendorcustomercommunication\Vendor;

class Contact extends \Opencart\System\Engine\Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/tmdvendorcustomercommunication/vendor/contact');

		$this->document->setTitle($this->language->get('heading_title1'));

		$this->load->model('extension/tmdvendorcustomercommunication/vendor/contact');
		$this->getList();
	}

	public function delete() {
		$this->load->language('extension/tmdvendorcustomercommunication/vendor/contact');

		$this->document->setTitle($this->language->get('heading_title1'));

		$this->load->model('extension/tmdvendorcustomercommunication/vendor/contact');


		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $inquiry_id) {
				$this->model_extension_tmdvendorcustomercommunication_vendor_contact->deleteContact($inquiry_id);
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

			$this->response->redirect($this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . $url, true));
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
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['reset'] = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'], '', true);
		$data['delete'] = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact|delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['inquires'] = array();

		$filter_data = array(
			'filter_enqname' => $filter_enqname,
			'filter_customer' => $filter_customer,
			'filter_product' => $filter_product,
			'filter_name' => $filter_name,
			'sort'  => $sort,
			'order' => $order,
			'start'           => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination')
		);
		
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/product');	
		$review_total = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getTotalContact($filter_data);
		$results = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getContacts($filter_data);

		foreach ($results as $result) {
			
			$sellers = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getVendor($result['vendor_id']);
			if(isset($sellers['sname'])){
				$sname = $sellers['sname'];
			} else {
				$sname ='';
			}
			$customers = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getCustomer($result['customer_id']);
			if(isset($customers['customername'])){
				$cname = $customers['customername'];
			} else {
				$cname ='Guest';
			}

			$products = $this->model_extension_tmdvendorcustomercommunication_vendor_product->getProduct($result['product_id']);
			
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
				'edit'        => $this->url->link('extension/tmdmultivendor/vendor|edit', 'user_token=' . $this->session->data['user_token'] . '&inquiry_id=' . $result['inquiry_id'] . $url, true),
				'view'        => $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact|view', 'user_token=' . $this->session->data['user_token'] . '&inquiry_id=' . $result['inquiry_id'] . $url, true),
				'producturl'  => $this->url->link('extension/tmdmultivendor/vendor/product|form', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];
		
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

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

		$data['sort_name']     = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_email']    = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . '&sort=email' . $url, true);
		$data['sort_product']  = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . '&sort=product' . $url, true);
		$data['sort_seller']   = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . '&sort=seller' . $url, true);
		$data['sort_customer'] = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . '&sort=customer' . $url, true);
		$data['sort_status']   = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);
		$data['sort_date']     = $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . '&sort=date' . $url, true);

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

		$data['pagination'] = $this->load->controller('common/pagination', [
		    'total' => $review_total, 
		    'page'  => $page,
		    'limit' => $this->config->get('config_pagination_admin'),
		    'url'   => $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);
		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $this->config->get('config_pagination')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination')) > ($review_total - $this->config->get('config_pagination'))) ? $review_total : ((($page - 1) * $this->config->get('config_pagination')) + $this->config->get('config_pagination')), $review_total, ceil($review_total / $this->config->get('config_pagination')));
		
		$data['filter_enqname']    = $filter_enqname;
		$data['filter_customer']   = $filter_customer;
		$data['filter_product']    = $filter_product;
		$data['filter_name'] 	   = $filter_name;
		$data['sort'] 			  = $sort;
		$data['order'] 			  = $order;

		if(isset($data['filter_name'])){
			$sellers = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getVendor($data['filter_name']);
		}

		if(!empty($sellers['sname'])){
			$data['sellername'] = $sellers['sname'];
		} else {
			$data['sellername'] ='';
		}

		if(isset($data['filter_customer'])){
			$customers = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getCustomer($data['filter_customer']);
		}
		if(isset($customers['firstname'])){
			$data['customername'] = $customers['firstname'].' '.$customers['lastname'];
		} else {
			$data['customername'] ='';
		}
		
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/product');
		if(isset($data['filter_product'])){
			$products_info = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getProduct($data['filter_product']);
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


		$this->response->setOutput($this->load->view('extension/tmdvendorcustomercommunication/vendor/contact_list', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/tmdvendorcustomercommunication/vendor/contact')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return !$this->error;
	}
	
	public function view() {
		$this->load->language('extension/tmdvendorcustomercommunication/vendor/contact');
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/contact');	
		
		$url = '';
				
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		$data['tmdmessages']=array();
		
		$message_show = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getTmdMessages($this->request->get['inquiry_id']);
		foreach($message_show as $messagesinfo){
			$data['tmdmessages'][]=array(
				'message_id'   => $messagesinfo['message_id'],
				'vendor_id'    => $messagesinfo['vendor_id'],
				'customer_id'  => $messagesinfo['customer_id'],
				'message'      => html_entity_decode($messagesinfo['message'], ENT_QUOTES, 'UTF-8'),
				'filename'     => $messagesinfo['filename'],
				'hreflink'     => $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact|download','user_token=' . $this->session->data['user_token'].'&message_id=' . $messagesinfo['message_id'].$url, true),
				'data_added'   => date('d-M-Y', strtotime($messagesinfo['data_added'])),
			);
		}
				
		$this->document->setTitle($this->language->get('heading_view1'));
		$data['user_token'] = $this->session->data['user_token'];
				
		if (isset($this->request->get['inquiry_id'])) {
			$inquiry_info=$this->model_extension_tmdvendorcustomercommunication_vendor_contact->getContact($this->request->get['inquiry_id']);
		}
		
		if(isset($inquiry_info['description'])){
			$data['description'] = strtoupper($this->language->get('entry_subject').' : '.$inquiry_info['description']);
		} else {
			$data['description'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/tmdvendorcustomercommunication/vendor/contact_view', $data));
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
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/contact');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		'filter_enqname' => $filter_enqname,
		'start'            => 0,
		'limit'            => 5
		);
		$enqnames = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getContacts($filter_data);
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

	public function customerautocomplete(){
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
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
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/contact');

			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		'filter_customer' => $filter_customer,
		'start'            => 0,
		'limit'            => 5
		);
		$enqnames = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getCustomers($filter_data);
		foreach ($enqnames as $enqname) {

		$json[] = array(
		'customer_id'  => $enqname['customer_id'],
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
	    $this->load->model('tool/upload');		
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/contact');

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

		$message_info = $this->model_extension_tmdvendorcustomercommunication_vendor_contact->getMessageDownload($message_id);
		if (empty($message_info)) {
	        exit('No messages found.');
	    }

	    $zip = new \ZipArchive();
	    $tmpZipPath = tempnam(sys_get_temp_dir(), 'rma_zip_');

	    if ($tmpZipPath === false) {
	        exit('Failed to create temporary file.');
	    }

	    if ($zip->open($tmpZipPath, \ZipArchive::OVERWRITE) !== true) {
	        exit('Unable to create ZIP file: ' . $zip->getStatusString());
	    }

	    if (empty($message_info)) {
	        exit('No messages found.');
	    }

	    $zip = new \ZipArchive();
	    $tmpZipPath = tempnam(sys_get_temp_dir(), 'rma_zip_');

	    if ($tmpZipPath === false) {
	        exit('Failed to create temporary file.');
	    }

	    if ($zip->open($tmpZipPath, \ZipArchive::OVERWRITE) !== true) {
	        exit('Unable to create ZIP file: ' . $zip->getStatusString());
	    }

        if (isset($message_info['filename'])) {
            $msgfilename = @unserialize($message_info['filename']);

            if (!is_array($msgfilename)) {
                $msgfilename = array($msgfilename);
            }

            foreach ($msgfilename as $fileCode) {
                $uploadInfo = $this->model_tool_upload->getUploadByCode($fileCode);
                if ($uploadInfo) {
                    $filePath = DIR_UPLOAD . $uploadInfo['filename'];
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, $uploadInfo['name']);
                    } else {
                        continue;
                    }
                }
            }
        }

	    $zip->close();

	    if (file_exists($tmpZipPath)) {
	        header('Content-Type: application/zip');
	        header('Content-Disposition: attachment; filename="return_files_' . $message_id . '.zip"');
	        header('Content-Length: ' . filesize($tmpZipPath));
	        readfile($tmpZipPath);
	        unlink($tmpZipPath);
	        exit;
	    } else {
	        exit('ZIP file was not created.');
	    }
	}

}