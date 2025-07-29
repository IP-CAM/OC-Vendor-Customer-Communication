<?php
class ControllerExtensionModuleTmdCommunicationSetting extends Controller {
	private $error = array();

	public function install() {
		$this->load->model('extension/tmd_communication');
		$this->model_extension_tmd_communication->install();
	}	
	public function uninstall() {
		$this->load->model('extension/tmd_communication');
		$this->model_extension_tmd_communication->uninstall();
	}
	
	public function index() {
		$this->load->language('extension/module/tmdcommunication_setting');

		$this->document->setTitle($this->language->get('heading_title1'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('tmdcommunication_setting', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if(isset($this->request->get['status'])) {
			$this->response->redirect($this->url->link('extension/module/tmdcommunication_setting','token=' . $this->session->data['token'],true));
			} else {
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			}

			
		}

		$data['heading_title'] 	    = $this->language->get('heading_title');

		$data['text_edit'] 		 	= $this->language->get('text_edit');
		$data['text_enabled'] 	 	= $this->language->get('text_enabled');
		$data['text_disabled']   	= $this->language->get('text_disabled');
		$data['text_yes'] 	 	    = $this->language->get('text_yes');
		$data['text_no']   	        = $this->language->get('text_no');

		$data['entry_status'] 	 	= $this->language->get('entry_status');
		$data['entry_v_info'] 	 	= $this->language->get('entry_v_info');
		$data['entry_c_info'] 	 	= $this->language->get('entry_c_info');
		$data['entry_subject'] 	 	= $this->language->get('entry_subject');
		$data['entry_admin_email']  = $this->language->get('entry_admin_email');

		$data['button_save'] 	 	= $this->language->get('button_save');
		$data['button_stay']  	 	= $this->language->get('button_stay');
		$data['button_shortcut'] 	= $this->language->get('button_shortcut');
		$data['button_cancel'] 	 	= $this->language->get('button_cancel');

		$data['tab_email']       	= $this->language->get('tab_email');
		$data['tab_setting']     	= $this->language->get('tab_setting');



		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tmdcommunication_setting', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tmdcommunication_setting', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['action'] = $this->url->link('extension/module/tmdcommunication_setting', 'token=' . $this->session->data['token'], true);
		$data['staysave'] = $this->url->link('extension/module/tmdcommunication_setting', '&status=1&'.'token=' . $this->session->data['token'],true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['tmdcommunication_setting_language'])) {
			$data['tmdcommunication_setting_language'] = $this->request->post['tmdcommunication_setting_language'];
		} else {
			$data['tmdcommunication_setting_language'] = $this->config->get('tmdcommunication_setting_language');
		}
		
		if (isset($this->request->post['tmdcommunication_setting_status'])) {
			$data['tmdcommunication_setting_status'] = $this->request->post['tmdcommunication_setting_status'];
		} else {
			$data['tmdcommunication_setting_status'] = $this->config->get('tmdcommunication_setting_status');
		}

		if (isset($this->request->post['tmdcommunication_setting_v_info'])) {
			$data['tmdcommunication_setting_v_info'] = $this->request->post['tmdcommunication_setting_v_info'];
		} else {
			$data['tmdcommunication_setting_v_info'] = $this->config->get('tmdcommunication_setting_v_info');
		}

		if (isset($this->request->post['tmdcommunication_setting_c_info'])) {
			$data['tmdcommunication_setting_c_info'] = $this->request->post['tmdcommunication_setting_c_info'];
		} else {
			$data['tmdcommunication_setting_c_info'] = $this->config->get('tmdcommunication_setting_c_info');
		}


		$data['heading_title'] = $this->language->get('heading_title');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tmdcommunication_setting', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tmdcommunication_setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
