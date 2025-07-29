<?php
class ModelExtensionTmdCommunication extends Model {
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
}
