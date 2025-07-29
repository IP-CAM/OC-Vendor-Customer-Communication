<?php
class ModelVendorMessageDetail extends Model {

	public function getEnquiry($inquiry_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry WHERE inquiry_id='".(int)$inquiry_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getTmdEnquiryMessage($inquiry_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message WHERE inquiry_id='".(int)$inquiry_id."'";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function addMessage($data) {

		$this->db->query("INSERT INTO `" . DB_PREFIX . "vendor_inquiry_message` SET vendor_id='".(int)$this->vendor->getId()."', inquiry_id = '" . (int)$data['inquiry_id'] . "', message = '" . $this->db->escape($data['message']) . "',filename = '" . $data['filename'] . "', status = '1', data_added = NOW()");
		$message_id = $this->db->getLastId();

		$this->load->model('catalog/product');
		$this->load->model('vendor/vendor');
		$enquiry_info 	= $this->getEnquiry($data['inquiry_id']);
		$product_info 	= $this->model_catalog_product->getProduct($enquiry_info['product_id']);

		$vendor_info  	= $this->model_vendor_vendor->getVendor($enquiry_info['vendor_id']);
		$v_email		= !empty($vendor_info['email'])?$vendor_info['email']:'';
		$v_first		= !empty($vendor_info['firstname'])?$vendor_info['firstname']:'';
		$v_last			= !empty($vendor_info['lastname'])?$vendor_info['lastname']:'';

		$customer_info	= $this->getCustomer($enquiry_info['customer_id']);
		$c_email		= !empty($customer_info['email'])?$customer_info['email']:'';

		$module_laguage =  $this->config->get('tmdcommunication_setting_language');
		
		$c_subject    	=  !empty($module_laguage[$this->config->get('config_language_id')]['c_message'])?$module_laguage[$this->config->get('config_language_id')]['c_subject']:'';
		$c_message    	=  !empty($module_laguage[$this->config->get('config_language_id')]['c_message'])?$module_laguage[$this->config->get('config_language_id')]['c_message']:'';

		if(!empty($data['inquiry_id'])){

			if(!empty($customer_info['firstname'])) {
				$firstname = $customer_info['firstname'];
			} else {
				$firstname ='';
			}

			if(!empty($customer_info['lastname'])) {
				$lastname = $customer_info['lastname'];
			} else {
				$lastname ='';
			}

			$customername 	= $firstname.' '.$lastname;
			$vendornamename = $v_first.' '.$v_last;

			if(!empty($product_info['name'])) {
				$pname = $product_info['name'];
			} else {
				$pname ='';
			}

			$find = array(
				'{contact_name}',
				'{customername}',
				'{product}',
				'{vendor}',
				'{message}',
				'{date}',
			);
			$cdate = date('d-M-Y');
			$replace = array(
				'contact_name' 	=> $enquiry_info['name'],
				'customername' 	=> $customername,
				'product' 		=> $pname,
				'vendor'        => $vendornamename,
				'message' 		=> html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'),
				'date' 		    => $cdate,
			);
			 
			$subject    = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $c_subject))));
			$message 	= str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $c_message))));

			if(version_compare(VERSION,'3.0.0.0','>=')) {
				$mail                = new Mail($this->config->get('config_mail_engine'));
				$mail->parameter     = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port     = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
			} else {
				$mail                = new Mail();
				$mail->protocol      = $this->config->get('config_mail_protocol');
				$mail->parameter     = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port     = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
			}
			$mail->setFrom($v_email);
			$mail->setTo($c_email);
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setHtml(html_entity_decode($message));
			$mail->send();
		}
		return $message_id;
	}	

	public function getLastMessage($message_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message WHERE message_id='".(int)$message_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getMessageDownload($message_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message WHERE message_id = '" .(int)$message_id . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getCustomer($customer_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" .(int)$customer_id . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}
}
?>
