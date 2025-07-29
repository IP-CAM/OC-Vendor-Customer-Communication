<?php
class ControllerVendorMessageDetail  extends Controller {
	private $error = array();
	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('vendor/message', '', true);
			$this->response->redirect($this->url->link('vendor/login', '', true));
		}

		$this->load->language('vendor/message_detail');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('vendor/message_detail');	
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_message'),
			'href' => $this->url->link('vendor/message')
		);

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

		if(isset($this->request->get['inquiry_id'])) {
			$inquiry_id = $this->request->get['inquiry_id'];
		} else {
			$inquiry_id = 0;
		}
		
		$data['inquiry_id'] = $inquiry_id;
		
		$this->load->model('vendor/message_detail');
		$enquiry_info = $this->model_vendor_message_detail->getEnquiry($inquiry_id);
		
		$description = !empty($enquiry_info['description'])?$enquiry_info['description']:'';
		$data['description'] = strtoupper($this->language->get('entry_subject').' : '.$description);
				
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['tmdmessage']=array();
				
		$this->load->model('vendor/message_detail');
		$vendormessages = $this->model_vendor_message_detail->getTmdMessage($inquiry_id);
		foreach($vendormessages as $messagesinfo){
			$data['tmdmessage'][]=array(
				'message_id'   => $messagesinfo['message_id'],
				'vendor_id'    => $messagesinfo['vendor_id'],
				'customer_id'  => $messagesinfo['customer_id'],
				'message'      => html_entity_decode($messagesinfo['message'], ENT_QUOTES, 'UTF-8'),
				'filename'     => $messagesinfo['filename'],
				'hreflink'     => $this->url->link('vendor/message_detail/download','&message_id=' . $messagesinfo['message_id']),
				'data_added'   => date('d-M-Y', strtotime($messagesinfo['data_added'])),
			);
		}
		
		$data['header']      = $this->load->controller('vendor/header');
		$data['column_left'] = $this->load->controller('vendor/column_left');
		$data['footer']      = $this->load->controller('vendor/footer');
		
		$this->response->setOutput($this->load->view('vendor/message_detail', $data));
	}

	public function sendDetailMessage() {
		$json = array();
		
		$this->load->language('vendor/message_detail');	
		$this->load->model('vendor/message_detail');
		$this->load->model('tool/image');
		$data['text_wait'] = $this->language->get('text_wait');		  
		if(($this->request->server['REQUEST_METHOD'] == 'POST')) {

			if(empty($this->request->post['message'])) {
				$json['error']=$this->language->get('text_error');	
			} 
			if(!$json){
				$message_id = $this->model_vendor_message_detail->addMessage($this->request->post);
				
				$msg_info = $this->model_vendor_message_detail->getLastMessage($message_id);
				$json['message'] = !empty($msg_info['message'])?$msg_info['message']:'';
				$json['date_added'] = date('d-M-Y', strtotime($msg_info['data_added']));
				$json['filename'] = !empty($msg_info['filename'])?$msg_info['filename']:'';
				$json['hreflink'] = $this->url->link('vendor/message_detail/download','&message_id=' . $message_id);
				$json['success'] = $this->language->get('text_success2');
			}
		
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	
	public function upload() {
		$this->load->language('tool/upload');

		$json = array();

		if (!$json) {
			if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
				$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
					$json['error'] = $this->language->get('error_filename');
				}
				$allowed = array();

				$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

				$filetypes = explode("\n", $extension_allowed);

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				$allowed = array();

				$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

				$filetypes = explode("\n", $mime_allowed);

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array($this->request->files['file']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				$content = file_get_contents($this->request->files['file']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = $this->language->get('error_filetype');
				}
				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!$json) {
			$file = $filename;
			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
			$json['filename'] = $file;
			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function download() {
		$this->load->language('tool/download');
		
		if(isset($this->session->data['token'])){
			$tokenexchange 		= 'token=' . $this->session->data['token'];
			$data['token'] 		= $this->session->data['token'];
		} else{
			$tokenexchange 		='user_token=' . $this->session->data['user_token'];
			$data['user_token'] = $this->session->data['user_token'];
		}

		
		$this->load->model('vendor/message_detail');

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

		$message_info = $this->model_vendor_message_detail->getMessageDownload($message_id,$inquiry_id);
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

?>