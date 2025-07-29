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
			$this->model_setting_setting->editSetting('module_tmdcommunication_setting', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if(isset($this->request->get['status'])) {
				$this->response->redirect($this->url->link('extension/module/tmdcommunication_setting','user_token=' . $this->session->data['user_token'],true));
			} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			}
		}


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tmdcommunication_setting', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/tmdcommunication_setting', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		$data['action'] = $this->url->link('extension/module/tmdcommunication_setting', 'user_token=' . $this->session->data['user_token'], true);
		$data['staysave'] = $this->url->link('extension/module/tmdcommunication_setting', '&status=1&'.'user_token=' . $this->session->data['user_token'],true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['module_tmdcommunication_setting_language'])) {
			$data['module_tmdcommunication_setting_language'] = $this->request->post['module_tmdcommunication_setting_language'];
		} else {
			$data['module_tmdcommunication_setting_language'] = $this->config->get('module_tmdcommunication_setting_language');
		}
		
		if (isset($this->request->post['module_tmdcommunication_setting_status'])) {
			$data['module_tmdcommunication_setting_status'] = $this->request->post['module_tmdcommunication_setting_status'];
		} else {
			$data['module_tmdcommunication_setting_status'] = $this->config->get('module_tmdcommunication_setting_status');
		}

		if (isset($this->request->post['module_tmdcommunication_setting_v_info'])) {
			$data['module_tmdcommunication_setting_v_info'] = $this->request->post['module_tmdcommunication_setting_v_info'];
		} else {
			$data['module_tmdcommunication_setting_v_info'] = $this->config->get('module_tmdcommunication_setting_v_info');
		}

		if (isset($this->request->post['module_tmdcommunication_setting_c_info'])) {
			$data['module_tmdcommunication_setting_c_info'] = $this->request->post['module_tmdcommunication_setting_c_info'];
		} else {
			$data['module_tmdcommunication_setting_c_info'] = $this->config->get('module_tmdcommunication_setting_c_info');
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
