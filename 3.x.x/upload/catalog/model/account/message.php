<?php
class ModelAccountMessage extends Model {
	
	public function getEnquiries($data = array()){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_inquiry WHERE customer_id='".(int)$this->customer->getId()."'";

		if (!empty($data['filter_enqname'])) {
			$sql .= " and name LIKE '" . $this->db->escape($data['filter_enqname']) . "%'";
		}


		if (!empty($data['filter_inquiry_id'])) {
			$sql .= " and inquiry_id='" . (int)$data['filter_inquiry_id'] . "'";
		}

		if (!empty($data['filter_vendor'])) {
			$sql .= " and vendor_id= '" . (int)$data['filter_vendor']. "'";
		}

		if (!empty($data['filter_product'])) {
			$sql .= " and product_id= '" .(int)$data['filter_product']. "'";
		}


		if (!empty($data['filter_date_added'])) {
			$sql .= " and date_added LIKE '" . $this->db->escape($data['filter_date_added']) . "%'";
		}

		$sort_data = array(
			'name',
			'email',
			'date_added',
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
	public function getTotalgetEnquiries($data = array()){
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "vendor_inquiry WHERE customer_id='".(int)$this->customer->getId()."'";

		if (!empty($data['filter_enqname'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_enqname']) . "%'";
		}

		if (!empty($data['filter_inquiry_id'])) {
			$sql .= " AND inquiry_id='" . (int)$data['filter_inquiry_id'] . "'";
		}

		if (!empty($data['filter_vendor'])) {
			$sql .= " AND vendor_id= '" . (int)$data['filter_vendor']. "'";
		}

		if (!empty($data['filter_product'])) {
			$sql .= " AND product_id= '" .(int)$data['filter_product']. "'";
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

	public function getVendor($vendor_id) {
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS sname FROM " . DB_PREFIX . "vendor where vendor_id='".(int)$vendor_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}
	

	public function getProductVendor($product_id){
		$sql = "SELECT * FROM " . DB_PREFIX . "vendor_to_product WHERE product_id ='".(int)$product_id. "'";
								
		$query = $this->db->query($sql);
		return $query->row;
	}
		
	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
						
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (!empty($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status'])){
		 	$sql .=" and status like '".$this->db->escape($data['filter_status'])."%'";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
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
	
}
?>