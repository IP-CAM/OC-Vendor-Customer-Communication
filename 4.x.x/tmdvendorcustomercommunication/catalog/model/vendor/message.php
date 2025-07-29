<?php
namespace Opencart\Catalog\Model\Extension\Tmdvendorcustomercommunication\Vendor;
class message extends \Opencart\System\Engine\Model {
	
	public function getEnquiries($data = array()){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry WHERE vendor_id='".(int)$this->vendor->getId()."'";

		if (!empty($data['filter_inquiry_id'])) {
			$sql .= " AND inquiry_id='" . (int)$data['filter_inquiry_id'] . "'";
		}

		if (!empty($data['filter_enqname'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_enqname']) . "%'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_product_id'])) {
			$sql .= " AND product_id='" . (int)$data['filter_product_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND date_added LIKE '" . $this->db->escape($data['filter_date_added']) . "%'";
		}
		
		$sort_data = array(
			'name',
			'email',
			'date_added'
			
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
	
	public function getTotalgetEnquiries($data = array()){
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vendor_inquiry WHERE vendor_id='".(int)$this->vendor->getId()."'";

		if (!empty($data['filter_inquiry_id'])) {
			$sql .= " AND inquiry_id='" . (int)$data['filter_inquiry_id'] . "'";
		}

		if (!empty($data['filter_enqname'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_enqname']) . "%'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_product_id'])) {
			$sql .= " AND product_id='" . (int)$data['filter_product_id'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND date_added LIKE '" . $this->db->escape($data['filter_date_added']) . "%'";
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}


	public function getCustomer($customer_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id='".(int)$customer_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getProductVendor($product_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_to_product WHERE product_id ='".(int)$product_id. "'";
								
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getProduct($product_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "product WHERE product_id='".(int)$product_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}	
	public function getVendors($data){
			$sql="select * from " . DB_PREFIX . "vendor v LEFT JOIN " . DB_PREFIX . "vendor_description vd on(v.vendor_id = vd.vendor_id) where v.vendor_id<>0  AND v.approved!=0  AND v.status!=0  AND vd.language_id = '" . (int)$this->config->get('config_language_id') . "' order by v.vendor_id desc ";
			
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query=$this->db->query($sql);
		return $query->rows;
	}
	
}
?>