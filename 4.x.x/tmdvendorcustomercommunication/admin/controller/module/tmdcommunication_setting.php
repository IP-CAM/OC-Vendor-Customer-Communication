<?php
namespace Opencart\Admin\Controller\Extension\Tmdvendorcustomercommunication\Module;
// Lib Include 
require_once(DIR_EXTENSION.'/tmdvendorcustomercommunication/system/library/tmd/system.php');
// Lib Include
class TmdcommunicationSetting extends \Opencart\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		$this->registry->set('tmd', new  \Tmdvendorcustomercommunication\System\Library\Tmd\System($this->registry));
		$keydata=[
		'code'=>'tmdkey_tmdcommunication_setting',
		'eid'=>'NDI3ODg=',
		'route'=>'extension/tmdvendorcustomercommunication/module/tmdcommunication_setting',
		];
		$tmdcommunication_setting=$this->tmd->getkey($keydata['code']);
		$data['getkeyform']=$this->tmd->loadkeyform($keydata);
		
		$this->load->language('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting');

		$this->document->setTitle($this->language->get('heading_title1'));
		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
		
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title1'),
			'href' => $this->url->link('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting', 'user_token=' . $this->session->data['user_token'])
		];

		if(VERSION>='4.0.2.0')
		{
			$data['save'] = $this->url->link('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting.save', 'user_token=' . $this->session->data['user_token']);
		}
		else{
			$data['save'] = $this->url->link('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting|save', 'user_token=' . $this->session->data['user_token']);
		}
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['module_tmdcommunication_setting_status'] = $this->config->get('module_tmdcommunication_setting_status');
		$data['module_tmdcommunication_setting_language'] = $this->config->get('module_tmdcommunication_setting_language');
		$data['module_tmdcommunication_setting_v_info'] = $this->config->get('module_tmdcommunication_setting_v_info');
		$data['module_tmdcommunication_setting_c_info'] = $this->config->get('module_tmdcommunication_setting_c_info');

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('extension/tmdvendorcustomercommunication/tmd/tmd_communication');
		$data['module_tmdcommunication_setting_seo_url'] = $this->model_extension_tmdvendorcustomercommunication_tmd_tmd_communication->getSeoUrls('extension/tmdvendorcustomercommunication/account/message');
		
		$data['module_tmdcommunication_setting_seo_url_details'] = $this->model_extension_tmdvendorcustomercommunication_tmd_tmd_communication->getSeoUrls('extension/tmdvendorcustomercommunication/account/message_detail');
		

		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$this->load->model('setting/store');

		$data['stores'] = [];

		$data['stores'][] = [
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		];

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = [
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			];
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting', $data));
	}

	/**
	 * @return void
	 */
	public function save(): void {
		$this->load->language('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdvendorcustomercommunication/module/tmdcommunication_setting')) {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$tmdcommunication_setting=$this->config->get('tmdkey_tmdcommunication_setting');
		if (empty(trim($tmdcommunication_setting))) {			
		$json['error'] ='Module will Work after add License key!';
		}

		if (!$json) {
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('module_tmdcommunication_setting', $this->request->post);

			$this->load->model('extension/tmdvendorcustomercommunication/tmd/tmd_communication');
			$this->request->post['urlformat']='module_tmdcommunication_setting_seo_url';
			$this->model_extension_tmdvendorcustomercommunication_tmd_tmd_communication->saveSeoUrls($this->request->post,'extension/tmdvendorcustomercommunication/account/message');

			$this->load->model('extension/tmdvendorcustomercommunication/tmd/tmd_communication');
			$this->request->post['urlformat']='module_tmdcommunication_setting_seo_url_details';
			$this->model_extension_tmdvendorcustomercommunication_tmd_tmd_communication->saveSeoUrls($this->request->post,'extension/tmdvendorcustomercommunication/account/message_detail');

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function keysubmit() {
		$json = []; 
		
      	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$keydata=[
			'code'=>'tmdkey_tmdcommunication_setting',
			'eid'=>'NDI3ODg=',
			'route'=>'extension/tmdvendorcustomercommunication/module/tmdcommunication_setting',
			'moduledata_key'=>$this->request->post['moduledata_key'],
			];
			$this->registry->set('tmd', new  \Tmdvendorcustomercommunication\System\Library\Tmd\System($this->registry));
		
            $json=$this->tmd->matchkey($keydata);       
		} 
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function install() {
		$this->load->model('extension/tmdvendorcustomercommunication/tmd/tmd_communication');
		$this->model_extension_tmdvendorcustomercommunication_tmd_tmd_communication->install();
		$this->load->model('user/user_group');

		// TMD admin menu events
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunication');
		if(VERSION>='4.0.2.0'){
			$eventaction='extension/tmdvendorcustomercommunication/module/tmdcommunication_setting.menu';
		}else{
			$eventaction='extension/tmdvendorcustomercommunication/module/tmdcommunication_setting|menu';
		}
		$eventrequest=[
			'code'=>'tmd_multivendorcommunication',
			'description'=>'TMD multivendor admin menus',
			'trigger'=>'admin/view/common/column_left/before',
			'action'=>$eventaction,
			'status'=>'1',
			'sort_order'=>'1',
		];
				
		if(VERSION=='4.0.0.0'){
			$this->model_setting_event->addEvent('tmd_multivendorcommunication', 'TMD multivendor admin menus', 'admin/view/common/column_left/before', 'extension/tmdvendorcustomercommunication/module/tmdcommunication_setting|menu', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}

		// TMD Front Account Twig events
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationAccount');
		if(VERSION>='4.0.2.0'){
			$eventaction='extension/tmdvendorcustomercommunication/account/message.AccountTwigEvent';
		}else{
			$eventaction='extension/tmdvendorcustomercommunication/account/message|AccountTwigEvent';
		}
		$eventrequest=[
			'code'=>'tmd_multivendorcommunicationAccount',
			'description'=>'TMD multivendor Front Account Twig events',
			'trigger'=>'catalog/view/account/account/before',
			'action'=>$eventaction,
			'status'=>'1',
			'sort_order'=>'1',
		];
				
		if(VERSION=='4.0.0.0'){
			$this->model_setting_event->addEvent('tmd_multivendorcommunicationAccount', 'TMD multivendor Front Account Twig events', 'catalog/view/account/account/before', 'extension/tmdvendorcustomercommunication/account/message|AccountTwigEvent', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}

		// TMD Front Account menu events
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationAccountMenu');
		if(VERSION>='4.0.2.0'){
			$eventaction='extension/tmdvendorcustomercommunication/account/message.AccountMenuTwigEvent';
		}else{
			$eventaction='extension/tmdvendorcustomercommunication/account/message|AccountMenuTwigEvent';
		}
		$eventrequest=[
			'code'=>'tmd_multivendorcommunicationAccountMenu',
			'description'=>'TMD multivendor Front Account menu events',
			'trigger'=>'catalog/view/extension/opencart/module/account/before',
			'action'=>$eventaction,
			'status'=>'1',
			'sort_order'=>'1',
		];

		if(VERSION=='4.0.0.0'){
			$this->model_setting_event->addEvent('tmd_multivendorcommunicationAccountMenu', 'TMD multivendor Front Account menu events', 'catalog/view/extension/opencart/module/account/before', 'extension/tmdvendorcustomercommunication/account/message|AccountMenuTwigEvent', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}

		// TMD Front Vendor menu events
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationVendorMenu');
		if(VERSION>='4.0.2.0'){
			$eventaction='extension/tmdvendorcustomercommunication/account/message.VendorMenuEvent';
		}else{
			$eventaction='extension/tmdvendorcustomercommunication/account/message|VendorMenuEvent';
		}

		$eventrequest=[
			'code'=>'tmd_multivendorcommunicationVendorMenu',
			'description'=>'TMD multivendor Front Vendor menu events',
			'trigger'=>'catalog/view/extension/tmdmultivendor/vendor/column_left/before',
			'action'=>$eventaction,
			'status'=>'1',
			'sort_order'=>'1',
		];

		if(VERSION=='4.0.0.0'){
			$this->model_setting_event->addEvent('tmd_multivendorcommunicationVendorMenu', 'TMD multivendor Front Vendor menu events', 'catalog/view/extension/tmdmultivendor/vendor/column_left/before', 'extension/tmdvendorcustomercommunication/account/message|VendorMenuEvent', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}


		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationAccountaccount');
		if(VERSION>='4.0.2.0'){
			$eventaction='extension/tmdvendorcustomercommunication/account/message.Accountaccountmenu';
		}else{
			$eventaction='extension/tmdvendorcustomercommunication/account/message|Accountaccountmenu';
		}
		$eventrequest=[
			'code'=>'tmd_multivendorcommunicationAccountaccount',
			'description'=>'TMD multivendor Front Account menu events',
			'trigger'=>'catalog/view/account/account/before',
			'action'=>$eventaction,
			'status'=>'1',
			'sort_order'=>'1',
		];

		if(VERSION=='4.0.0.0'){
			$this->model_setting_event->addEvent('tmd_multivendorcommunicationAccountaccount', 'TMD multivendor Front Account menu events', 'catalog/view/account/account/before', 'extension/tmdvendorcustomercommunication/account/message|Accountaccountmenu', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}

    $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdvendorcustomercommunication/vendor/contact');
	$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdvendorcustomercommunication/vendor/contact');
	 $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdvendorcustomercommunication/vendor/product');
	$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdvendorcustomercommunication/vendor/product');

	}	

	public function uninstall() {
		$this->load->model('extension/tmdvendorcustomercommunication/tmd/tmd_communication');
		$this->model_extension_tmdvendorcustomercommunication_tmd_tmd_communication->uninstall();

		$this->load->model('setting/event');
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunication');
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationAccount');
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationAccountMenu');
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationVendorMenu');
		$this->model_setting_event->deleteEventByCode('tmd_multivendorcommunicationAccountaccount');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdvendorcustomercommunication/vendor/contact');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdvendorcustomercommunication/vendor/contact');
		  $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdvendorcustomercommunication/vendor/product');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdvendorcustomercommunication/vendor/product');
	}

	public function menu(string&$route, array&$args, mixed&$output):void {
		$modulestatus=$this->config->get('module_tmdcommunication_setting_status');
		if(!empty($modulestatus)){
			
			$this->load->language('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting');

			$communication = [];

			if ($this->user->hasPermission('access', 'extension/tmdvendorcustomercommunication/module/tmdcommunication_setting')) {
				$communication[] = [
					'name'     => $this->language->get('text_communication'),
					'href'     => $this->url->link('extension/tmdvendorcustomercommunication/module/tmdcommunication_setting', 'user_token='.$this->session->data['user_token']),
					'children' => []
				];	
				$communication[] = [
					'name'     => $this->language->get('text_contactlist'),
					'href'     => $this->url->link('extension/tmdvendorcustomercommunication/vendor/contact', 'user_token='.$this->session->data['user_token']),
					'children' => []
				];
			}

			if ($communication) {
				$args['menus'][] = [
					'id'       => 'menu-communication',
					'icon'     => 'fa fa-phone-square',
					'name'     => $this->language->get('text_vendorcontact'),
					'href'     => '',
					'children' => $communication
				];
			}
		}
	}
}