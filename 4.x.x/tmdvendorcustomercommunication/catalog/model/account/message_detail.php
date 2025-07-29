<?php
namespace Opencart\Catalog\Model\Extension\Tmdvendorcustomercommunication\account;
class messagedetail extends \Opencart\System\Engine\Model {

	public function getEnquiry($inquiry_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry WHERE inquiry_id='".(int)$inquiry_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getTmdMessage($inquiry_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message WHERE inquiry_id='".(int)$inquiry_id."' ORDER BY message_id ASC";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function addMessage($data) {
    // Handle file data
    $filenamesdata = '';
    if (!empty($data['filename'])) {
        $filenamesdata = serialize($data['filename']);
    }

    // Get vendor_id from the inquiry if not provided
    $enquiry_info = $this->getEnquiry($data['inquiry_id']);
    $vendor_id = $enquiry_info['vendor_id'] ?? 0;

  $this->db->query("INSERT INTO `" . DB_PREFIX . "vendor_inquiry_message` SET 
    `inquiry_id` = '" . (int)$data['inquiry_id'] . "', 
    `vendor_id` = '" . (int)$vendor_id . "',
    `customer_id` = '" . (int)$this->customer->getId() . "', 
    `message` = '" . $this->db->escape(strip_tags($data['message'] ?? '')) . "',
    `filename` = '" . $this->db->escape($filenamesdata) . "',
    `status` = '1',
    `data_added` = NOW()");
    $message_id = $this->db->getLastId();

    $this->load->model('catalog/product');
    $this->load->model('extension/tmdmultivendor/vendor/vendor');
    $product_info = $this->model_catalog_product->getProduct($enquiry_info['product_id']);

    $vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($vendor_id);
    $v_email = $vendor_info['email'] ?? '';
    $v_first = $vendor_info['firstname'] ?? '';
    $v_last = $vendor_info['lastname'] ?? '';

    $customer_info = $this->getCustomer($this->customer->getId());
    $c_email = $customer_info['email'] ?? '';

    $module_laguage = $this->config->get('module_tmdcommunication_setting_language');
    $c_subject = $module_laguage[$this->config->get('config_language_id')]['v_message'] ?? '';
    $c_message = $module_laguage[$this->config->get('config_language_id')]['v_message'] ?? '';

    if (!empty($customer_info['firstname'])) {
        $firstname = $customer_info['firstname'];
    } else {
        $firstname = '';
    }

    if (!empty($customer_info['lastname'])) {
        $lastname = $customer_info['lastname'];
    } else {
        $lastname = '';
    }

    $customername = $firstname.' '.$lastname;
    $vendornamename = $v_first.' '.$v_last;
    $pname = $product_info['name'] ?? '';

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
        'contact_name' => $enquiry_info['name'] ?? '',
        'customername' => $customername,
        'product' => $pname,
        'vendor' => $vendornamename,
        'message' => html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'),
        'date' => $cdate,
    );
     
    $subject = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $c_subject))));
    $message = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $c_message))));

    if ($this->config->get('config_mail_engine')) {
        if(VERSION>='4.0.2.0'){        
            $mail_option = [
                'parameter' => $this->config->get('config_mail_parameter'),
                'smtp_hostname' => $this->config->get('config_mail_smtp_hostname'),
                'smtp_username' => $this->config->get('config_mail_smtp_username'),
                'smtp_password' => html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8'),
                'smtp_port' => $this->config->get('config_mail_smtp_port'),
                'smtp_timeout' => $this->config->get('config_mail_smtp_timeout')
            ];
            
            $mail = new \Opencart\System\Library\Mail($this->config->get('config_mail_engine'), $mail_option);
        } else {
            $mail = new \Opencart\System\Library\Mail($this->config->get('config_mail_engine'));
        }        
        
        $mail->setFrom($c_email);
        $mail->setTo($v_email);
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
		 // "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message WHERE message_id = '" .(int)$message_id . "'";
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message WHERE message_id = '" .(int)$message_id . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row;
	}
}
?>
