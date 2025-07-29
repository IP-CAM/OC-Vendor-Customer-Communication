<?php
namespace Opencart\Admin\Model\Extension\Tmdvendorcustomercommunication\tmd;

class Tmdcommunication extends \Opencart\System\Engine\Model {

	public function install() {
    $this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."vendor_inquiry_message` (
     `message_id` int(11) NOT NULL AUTO_INCREMENT,      
     `inquiry_id` int(11) NOT NULL,    
     `customer_id` int(11) NOT NULL,    
     `vendor_id` int(11) NOT NULL,    
     `status` int(11) NOT NULL,    
     `message` text NOT NULL,
     `filename` varchar(255) NOT NULL,
     `data_added` date NOT NULL,    
     PRIMARY KEY (`message_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
  }

  public function uninstall() {
    $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."vendor_inquiry_message`");
  }

  public function getSeoUrls($value): array {
    $product_seo_url_data = [];

    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'route' AND `value` = '".$this->db->escape($value)."'");

    foreach ($query->rows as $result) {
      $product_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
    }

    return $product_seo_url_data;
  }
  
  public function saveSeoUrls($data,$value): void {
    $query = $this->db->query("delete FROM `" . DB_PREFIX . "seo_url` WHERE `key` = 'route' AND `value` = '".$this->db->escape($value)."'");
  
    foreach ($data[$data['urlformat']] as $store_id => $language) {
        foreach ($language as $language_id => $keyword) {
          
          $this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET `store_id` = '" . (int)$store_id . "', `language_id` = '" . (int)$language_id . "', `key` = 'route', `value` = '" . $this->db->escape($value) . "', `keyword` = '" . $this->db->escape($keyword) . "',sort_order='-1'");
        }
      }
    
  }
}
