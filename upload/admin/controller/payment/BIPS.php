<?php
class ControllerPaymentBIPS extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/BIPS');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('BIPS', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_api'] = $this->language->get('entry_api');
		$this->data['entry_secret'] = $this->language->get('entry_secret');

		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['entry_ipn_text'] = $this->language->get('entry_ipn_text');
		$this->data['entry_ipn_url'] = str_replace('admin/', '', $this->url->link('payment/BIPS/callback')); // 'http://' . $_SERVER["HTTP_HOST"] . '/system/payment/ipn.php';

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['api'])) {
			$this->data['error_api'] = $this->error['api'];
		} else {
			$this->data['error_api'] = '';
		}

 		if (isset($this->error['secret'])) {
			$this->data['error_secret'] = $this->error['secret'];
		} else {
			$this->data['error_secret'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/BIPS', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/BIPS', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['BIPS_api'])) {
			$this->data['BIPS_api'] = $this->request->post['BIPS_api'];
		} else {
			$this->data['BIPS_api'] = $this->config->get('BIPS_api');
		}

		if (isset($this->request->post['BIPS_secret'])) {
			$this->data['BIPS_secret'] = $this->request->post['BIPS_secret'];
		} else {
			$this->data['BIPS_secret'] = $this->config->get('BIPS_secret');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['BIPS_status'])) {
			$this->data['BIPS_status'] = $this->request->post['BIPS_status'];
		} else {
			$this->data['BIPS_status'] = $this->config->get('BIPS_status');
		}
		
		if (isset($this->request->post['BIPS_sort_order'])) {
			$this->data['BIPS_sort_order'] = $this->request->post['BIPS_sort_order'];
		} else {
			$this->data['BIPS_sort_order'] = $this->config->get('BIPS_sort_order');
		}

		$this->template = 'payment/BIPS.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/BIPS')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['BIPS_api']) {
			$this->error['api'] = $this->language->get('error_api');
		}

		if (!$this->request->post['BIPS_secret']) {
			$this->error['secret'] = $this->language->get('error_secret');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>