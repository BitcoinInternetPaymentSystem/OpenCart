<?php
class ControllerPaymentBIPS extends Controller
{
	protected function index()
	{
		$this->language->load('payment/BIPS');
		
		$this->load->model('checkout/order');

		$this->data['BIPSfunction'] = $this->url->link('payment/BIPS/pay');
		$this->data['BIPSpay'] = $this->language->get('BIPSpay');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/BIPS.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/BIPS.tpl';
		} else {
			$this->template = 'default/template/payment/BIPS.tpl';
		}

		$this->render();
	}

	public function pay()
	{
		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$titles = '';
		
		foreach ($this->cart->getProducts() as $product)
		{
			$titles .= $product['name'] . ', ';
		}

		$titles = substr($titles, 0, -2);
		
		if (in_array('curl', get_loaded_extensions()))
		{
			$ch = curl_init();
			curl_setopt_array($ch, array(
			CURLOPT_URL => 'https://bips.me/api/v1/invoice',
			CURLOPT_USERPWD => $this->config->get('BIPS_api'),
			CURLOPT_POSTFIELDS => 'price=' . number_format($this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false), 2, '.', '') . '&currency=' . $order_info['currency_code'] . '&item=' . $titles . '&custom=' . json_encode(array('orderid' => $order_info['order_id'], 'returnurl' => rawurlencode($this->url->link('checkout/success')), 'cancelurl' => rawurlencode($this->url->link('account/order/info&order_id=' . $order_info['order_id'])))),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC));
			$response = curl_exec($ch);
			curl_close($ch);

			header('Location: ' . $response);
		}
		else
		{
			print "cURL is not installed on this server, please inform the store owner.";
		}

		exit;
	}
	
	public function callback()
	{
		$BIPS = $_POST;
		$hash = hash('sha512', $BIPS['transaction']['hash'] . $this->config->get('BIPS_secret'));

		header('HTTP/1.1 200 OK');
		print '1';

		$this->load->model('checkout/order');

		if ($BIPS['hash'] == $hash && $BIPS['status'] == 1)
		{
			$this->model_checkout_order->confirm($BIPS["custom"]["orderid"], 2);
		}
		else
		{
			$this->model_checkout_order->confirm($BIPS["custom"]["orderid"], 8);
		}
	}
}
?>
