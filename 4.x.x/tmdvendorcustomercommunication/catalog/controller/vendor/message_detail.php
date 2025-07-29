<?php
namespace Opencart\Catalog\Controller\Extension\Tmdvendorcustomercommunication\vendor;
class Messagedetail extends \Opencart\System\Engine\Controller {

	public function index() {
	
		if (!$this->vendor->isLogged() ) {
			$this->session->data['redirect'] = $this->url->link('extension/tmdvendorcustomercommunication/vendor/message', 'language=' . $this->config->get('config_language'));

			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', 'language=' . $this->config->get('config_language')));
		}

		$this->load->language('extension/tmdvendorcustomercommunication/vendor/message_detail');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/message_detail');	
		
		$data['language'] = $this->config->get('config_language');

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'language=' . $this->config->get('config_language'))
		];
		$data['customer_token'] = $this->session->data['customer_token']?? '';

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_message'),
			'href' => $this->url->link('extension/tmdvendorcustomercommunication/vendor/message', 'language=' . $this->config->get('config_language') . '&customer_token=' . $data['customer_token'])
		];

		
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
		
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/message_detail');
		$enquiry_info = $this->model_extension_tmdvendorcustomercommunication_vendor_message_detail->getEnquiry($inquiry_id);
		
		$description = !empty($enquiry_info['description'])?$enquiry_info['description']:'';
		$data['description'] = strtoupper($this->language->get('entry_subject').' : '.$description);
				
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['tmdmessage']=[];
				
		$this->load->model('extension/tmdvendorcustomercommunication/vendor/message_detail');
		$vendormessages = $this->model_extension_tmdvendorcustomercommunication_vendor_message_detail->getTmdMessage($inquiry_id);
		foreach($vendormessages as $messagesinfo){
			$data['tmdmessage'][]=[
				'message_id'   => $messagesinfo['message_id'],
				'vendor_id'    => $messagesinfo['vendor_id'],
				'customer_id'  => $messagesinfo['customer_id'],
				'message'      => html_entity_decode($messagesinfo['message'], ENT_QUOTES, 'UTF-8'),
				'filename'     => $messagesinfo['filename'],
				'hreflink'     => $this->url->link('extension/tmdvendorcustomercommunication/vendor/message_detail|download', 'language=' . $this->config->get('config_language') . '&message_id=' . $messagesinfo['message_id']),
				'data_added'   => date('d-M-Y', strtotime($messagesinfo['data_added'])),
			];
		}

		$data['reset'] = $this->url->link('extension/tmdvendorcustomercommunication/vendor/message', 'language=' . $this->config->get('config_language'));
		
		
		$data['header']      = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer']      = $this->load->controller('extension/tmdmultivendor/vendor/footer');
		
		$this->response->setOutput($this->load->view('extension/tmdvendorcustomercommunication/vendor/message_detail', $data));
	}

	public function sendDetailMessage() {
	    $json = [];
	    
	    $this->load->language('extension/tmdvendorcustomercommunication/vendor/message_detail');    
	    $this->load->model('extension/tmdvendorcustomercommunication/vendor/message_detail');
	    $this->load->model('extension/tmdvendorcustomercommunication/account/message_detail');
	    $this->load->model('tool/image');
	    $data['text_wait'] = $this->language->get('text_wait');   
	    if(($this->request->server['REQUEST_METHOD'] == 'POST')) {
	        if(empty($this->request->post['message'])) {
	            $json['error'] = $this->language->get('text_error');    
	        } if(empty($this->request->post['message'])) {
	            $json['error'] = $this->language->get('text_error');    
	        } 


	        $filenamesdata = '';
			if(!empty($this->request->post['filename'])){
	         $filenamesdata = serialize($this->request->post['filename']);
			}
	        if(!$json) {
	            $message_id = $this->model_extension_tmdvendorcustomercommunication_vendor_message_detail->addMessage($this->request->post);
	            
	            $msg_info = $this->model_extension_tmdvendorcustomercommunication_vendor_message_detail->getLastMessage($message_id);
	            
	            // Improved filename handling
	            $json['message'] = !empty($msg_info['message']) ? $msg_info['message'] : '';
	            $json['date_added'] = date('d-M-Y', strtotime($msg_info['data_added']));
	            $json['filename'] = $filenamesdata;
	            
	            $json['hreflink'] = $this->url->link('extension/tmdvendorcustomercommunication/vendor/message_detail|download', 'language=' . $this->config->get('config_language') . '&message_id=' . $message_id);
	            $json['success'] = $this->language->get('text_success2');
	        }

	        $this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($json));
	    }
	}
	
	public function upload() {
	    $this->load->language('extension/tmdvendorcustomercommunication/vendor/message_detail');
	    $this->load->language('tool/upload');
	    
	    if (isset($this->request->get['return_id'])) {
	        $return_id = $this->request->get['return_id'];
	    } else {
	        $return_id = 0;
	    }

	    $json = [];

	    if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
	        // Sanitize the filename
	        $filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

	        if(VERSION>='4.0.2.0'){
	            // Validate the filename length
	            if ((oc_strlen($filename) < 3) || (oc_strlen($filename) > 64)) {
	                $json['error'] = $this->language->get('error_filename');
	            }
	        } else {
	            // Validate the filename length
	            if (Helper\Utf8\strlen(trim(($filename) < 3)) || (Helper\Utf8\strlen(trim(($filename) > 64)))) {
	                $json['error'] = $this->language->get('error_filename');
	            }
	        } 

	        // Allowed file extension types
	        $allowed = array();
	        $extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));
	        $filetypes = explode("\n", $extension_allowed);

	        foreach ($filetypes as $filetype) {
	            $allowed[] = trim($filetype);
	        }

	        if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
	            $json['error'] = $this->language->get('error_filetype');
	        }

	        // Allowed file mime types
	        $allowed = [];
	        $mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));
	        $filetypes = explode("\n", $mime_allowed);

	        foreach ($filetypes as $filetype) {
	            $allowed[] = trim($filetype);
	        }

	        if (!in_array($this->request->files['file']['type'], $allowed)) {
	            $json['error'] = $this->language->get('error_filetype');
	        }

	        // Check to see if any PHP files are trying to be uploaded
	        $content = file_get_contents($this->request->files['file']['tmp_name']);

	        if (preg_match('/\<\?php/i', $content)) {
	            $json['error'] = $this->language->get('error_filetype');
	        }

	        // Return any upload error
	        if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
	            $json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
	        }
	    } else {
	        $json['error'] = $this->language->get('error_upload');
	    }

	    if (!$json) {

	        if(VERSION>='4.0.2.0'){
	            $file = $filename . '.' . oc_token(32);
	        } else {
	            $file = $filename . '.' . Helper\General\token(32);
	        }

	        move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file);

	        // Hide the uploaded file name so people cannot link to it directly.
	        $this->load->model('tool/upload');

	        $json['filename'] = $this->model_tool_upload->addUpload($filename, $file);
	        $file = $filename;
	        $json['filenames'] = $file;

	        $json['success'] = $this->language->get('text_upload');
	    }

	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
	public function download() {
	    $this->load->model('extension/tmdvendorcustomercommunication/vendor/message_detail');
	    $this->load->language('tool/download');
	    $this->load->model('tool/upload');

	    $message_id = isset($this->request->get['message_id']) ? (int)$this->request->get['message_id'] : 0;

	    $message_info = $this->model_extension_tmdvendorcustomercommunication_vendor_message_detail->getMessageDownload($message_id);

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
	                $msgfilename = array($msgfilename); // Convert to array if it's a single string
	            }

	            foreach ($msgfilename as $fileCode) {
	                $uploadInfo = $this->model_tool_upload->getUploadByCode($fileCode);
	                if ($uploadInfo) {
	                    $filePath = DIR_UPLOAD . $uploadInfo['filename'];
	                    if (file_exists($filePath)) {
	                        $zip->addFile($filePath, $uploadInfo['name']);
	                    } else {
	                        // File missing, skip it
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


?>