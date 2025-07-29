<?php
class ModelVendorContact extends Model {
	public function deleteContact($inquiry_id) {
		$sql= "DELETE  FROM ". DB_PREFIX . "vendor_inquiry where inquiry_id='" .(int)$inquiry_id."'";
		$query=$this->db->query($sql);
		$sql1="DELETE FROM ". DB_PREFIX . "vendor_inquiry_message where inquiry_id='" .(int)$inquiry_id."'";
		$query=$this->db->query($sql1);
	}
	
	public function getContact($inquiry_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry where inquiry_id='".(int)$inquiry_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getVendor($vendor_id) {
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS sname FROM " . DB_PREFIX . "vendor where vendor_id='".(int)$vendor_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getCustomer($customer_id) {
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS customername FROM " . DB_PREFIX . "customer where customer_id='".(int)$customer_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getProduct($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product_description where product_id='". (int)$product_id."' AND language_id='".(int)$this->config->get('config_language_id')."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getContacts($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry where inquiry_id<>0";
				
		if (!empty($data['filter_name'])){
		 	$sql .=" and vendor_id='".(int)$data['filter_name']."'";
		}
		
		if (!empty($data['filter_customer'])){
		 	$sql .=" and customer_id='".(int)$data['filter_customer']."'";
		}
		
		if (!empty($data['filter_product'])){
		 	$sql .=" and product_id='".(int)$data['filter_product']."'";
		}
		
		if (!empty($data['filter_enqname'])){
		 	$sql .=" and name like '".$this->db->escape($data['filter_enqname'])."%'";
		}
		
		$sort_data = array(
			'status',
			'inquiry_id'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY inquiry_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalContact($data) {
        $sql ="SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vendor_inquiry where inquiry_id<>0";
		
		if (!empty($data['filter_name'])){
		 	$sql .=" and vendor_id='".(int)$data['filter_name']."'";
		}
		
		if (!empty($data['filter_customer'])){
		 	$sql .=" and customer_id='".(int)$data['filter_customer']."'";
		}
		
		if (!empty($data['filter_product'])){
		 	$sql .=" and product_id='".(int)$data['filter_product']."'";
		}
		
		if (!empty($data['filter_enqname'])){
		 	$sql .=" and name like '".$this->db->escape($data['filter_enqname'])."%'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
		
	public function getTmdMessages($inquiry_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message where inquiry_id='".(int)$inquiry_id."' ORDER BY message_id ASC";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getMessageDownload($message_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry_message WHERE message_id = '" .(int)$message_id . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}
}
