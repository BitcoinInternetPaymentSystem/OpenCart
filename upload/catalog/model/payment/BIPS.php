<?php 
class ModelPaymentBIPS extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('payment/BIPS');

		$status = true;

		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'       => 'BIPS',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('BIPS_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>