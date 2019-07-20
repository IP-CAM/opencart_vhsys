<?php

class ControllerExtensionFeedRestApi extends Controller {

	private $debugIt = false;
	
	public function products() {
		$this->checkPlugin();
		$this->load->model('catalog/productvhsys');
		$products = $this->model_catalog_productvhsys->getAllProduct();
				
		if(count($products)){
			foreach ($products as $product) {

			$aProducts[] = array(
								'id'			=> $product['product_id'],
								'model'			=> $product['model'],
								'sku'			=> $product['sku'],
								'quantity'		=> $product['quantity'],
								'price'			=> $product['price'],
								'weight'		=> $product['weight'],
								'length'		=> $product['length'],
								'width'			=> $product['width'],
								'height'		=> $product['height'],
								'status'		=> $product['status'],
								'date_added'	=> $product['date_added'],
								'date_modified'	=> $product['date_modified'],
								'name'			=> $product['name'],
								'description'	=> $product['description'],
								'image'			=> $product['image'],
							);
			}
			$json['success'] 	= true;
			$json['products'] 	= $aProducts;
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Problema em Listar os Produtos";
		}
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);			
			echo '</pre>';
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}
	
	
	public function count_products(){
		$this->checkPlugin();
		$this->load->model('catalog/productvhsys');
		
		$filters =  $this->getParameter();
		$products = $this->model_catalog_productvhsys->getCountProduct();

		foreach ($products as $product) {
			if($product['NrProducts'] > 0){
				$json['success'] 	= true;
				$json['products'] 	= $product['NrProducts'];
			}else {
				$json['success'] 	= false;
				$json['error'] 	= "Problems in contar os Produtos.";
			}
		}
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}
	
	
	public function products_filters() {
		$this->checkPlugin();
		$this->load->model('catalog/productvhsys');
		
		$filters =  $this->getParameter('produtos');
		$products = $this->model_catalog_productvhsys->getAllProductFilters($filters);
		
		if(count($products)){
			foreach ($products as $product) {
				$aProducts[] = array(
								'id'			=> $product['product_id'],
								'model'			=> $product['model'],
								'sku'			=> $product['sku'],
								'quantity'		=> $product['quantity'],
								'price'			=> $product['price'],
								'weight'		=> $product['weight'],
								'length'		=> $product['length'],
								'width'			=> $product['width'],
								'height'		=> $product['height'],
								'status'		=> $product['status'],
								'date_added'	=> $product['date_added'],
								'date_modified'	=> $product['date_modified'],
								'name'			=> $product['name'],
								'description'	=> $product['description'],
								);
			}
			$json['success'] 	= true;
			$json['products'] 	= $aProducts;
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Sua busca n&atilde;o retornou nenhum resultado!";
		}
	
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}
			
	public function orders() {	
		$this->checkPlugin();
		$this->load->model('account/ordervhsys');
				
		$results = $this->model_account_ordervhsys->getAllOrders();

		foreach($results as $result){
			
			$orders[] = array(
				'order_id' => $result['order_id'],
				'firstname' => $result['firstname'],
				'lastname' => $result['lastname'],
				'customer_id' => $result['customer_id'] ,
				'email' => $result['email'],
				'telephone' => $result['telephone'],
				'total' => $result['total'],
				'currency_code' => $result['currency_code'],
				'date_added' => $result['date_added'],
				'payment_firstname' => $result['payment_firstname'],
				'payment_lastname' => $result['payment_lastname'],
				'payment_company' => $result['payment_company'],
				'payment_address_1' => $result['payment_address_1'],
				'payment_address_2' => $result['payment_address_2'],
				'payment_city' => $result['payment_city'],
				'payment_zone' => $result['payment_zone'],
				'status_ped' => $result['status_ped'],
			);
		}

		if(count($results)){
			$json['success'] 	= true;
			$json['orders'] 	= $orders;			
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Nenhum Pedido encontrado";
		}
		
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';

		} else {
			$this->response->setOutput(json_encode($json));
		}
	}		
	
	public function order_product(){
		
		$this->checkPlugin();
		$this->load->model('account/ordervhsys');
		$filters = $this->getParameter('id_pedido');
		
		$produtos = $this->model_account_ordervhsys->getAllOrdersProduct($filters);		
		
		foreach($produtos as $array_produtos){
			$orders_product[] = array(
				'product_id' => $array_produtos['product_id'],
				'name' => $array_produtos['name'],
				'price' => $array_produtos['price'],
				'quantity' => $array_produtos['quantity'],
				'total' => $array_produtos['total'],
				'sku' => $array_produtos['sku'],
				'image' => $array_produtos['image'],
				'estoque' => $array_produtos['estoque']
			);
		}
		
		if(count($produtos)){
			$json['success'] 	= true;
			$json['order_product'] 	= $orders_product;			
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Nenhum Produto encontrado para esse pedido";
		}
		
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';

		} else {
			$this->response->setOutput(json_encode($json));
		}
	}
	
	public function orders_filters() {
		$this->checkPlugin();
		$filters =  $this->getParameter('pedidos');
		$this->load->model('account/ordervhsys');	
		
		$results = $this->model_account_ordervhsys->getAllOrdersFilters($filters);
		
		foreach($results as $result){
			$orders[] = array(
				'order_id' => $result['order_id'],
				'firstname' => $result['firstname'],
				'lastname' => $result['lastname'],
				'customer_id' => $result['customer_id'] ,
				'email' => $result['email'],
				'telephone' => $result['telephone'],
				'total' => $result['total'],
				'currency_code' => $result['currency_code'],
				'date_added' => $result['date_added'],
				'date_modified' => $result['date_modified'],
				'payment_firstname' => $result['payment_firstname'],
				'payment_lastname' => $result['payment_lastname'],
				'payment_company' => $result['payment_company'],
				'payment_address_1' => $result['payment_address_1'],
				'payment_address_2' => $result['payment_address_2'],
				'payment_city' => $result['payment_city'],
				'payment_zone' => $result['payment_zone'],
				'status_ped' => $result['status_ped'],
			);
		}
		
		if(count($results)){
			$json['success'] 	= true;
			$json['orders'] 	= $orders;			
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Nenhum Pedido encontrado!";
		}
	
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';
	
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}

	public function orders_total() {
		$this->checkPlugin();
		$filters =  $this->getParameter('id_pedido');
		$this->load->model('account/ordervhsys');	
		
		$results = $this->model_account_ordervhsys->getAllOrdersTotal($filters);
		
		foreach($results as $result){
			$array[$result['code']] = $result['value'];
		}
		$orders[] = $array;
		if(count($results)){
			$json['success'] 	= true;
			$json['orders'] 	= $orders;			
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Nenhum Pedido encontrado!";
		}
	
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';
	
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}

	
	public function customers(){
		
		$this->checkPlugin();
		$filters =  $this->getParameter('cliente');
		$this->load->model('account/customervhsys');	
		$resultado = $this->model_account_customervhsys->getCustomerAll($filters);
		
		foreach($resultado as $result){
			$customers[] = array(
				'customer_id' => $result['customer_id'],
				'firstname' => $result['firstname'],
				'lastname' => $result['lastname'],
				'email' => $result['email'],
				'telephone' => $result['telephone'],
				'fax' => $result['fax'],
				'date_added' => $result['date_added'],
				'city' => $result['city'],
				'company' => $result['company'],
				'address_1' => $result['address_1'],
				'address_2' => $result['address_2'],
				'postcode' => $result['postcode'],
				'estado_cliente' => $result['estado_cliente'],
				'code_estado_cliente' => $result['code_estado_cliente'],
				'custom_field' => $result['custom_field']
			);
		}
		
		if(count($resultado)){
			$json['success'] 	= true;
			$json['customers'] 	= $customers;			
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Nenhum Cliente encontrado.";
		}
	
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';
	
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}
	
	public function fields(){
		
		$this->checkPlugin();	
		$this->load->model('account/customervhsys');	
		$resultado = $this->model_account_customervhsys->getFieldsAll();
		
		foreach($resultado as $result){
			$customers_fields[] = array(
				'custom_field_id' => $result['custom_field_id'],
			);
		}
		
		if(count($resultado)){
			$json['success'] 	= true;
			$json['customers_fields'] 	= $customers_fields;			
		}else {
			$json['success'] 	= false;
			$json['error'] 	= "Nenhum Campo encontrado.";
		}
	
		if ($this->debugIt) {
			echo '<pre>';
			print_r($json);
			echo '</pre>';
	
		} else {
			$this->response->setOutput(json_encode($json));
		}
	}
	
	
	public function estoque(){
		
		$this->checkPlugin();
		$this->load->model('catalog/productestoquevhsys');
		$produto = json_decode(stripcslashes($_POST['Produto']));
		$resultado = $this->model_catalog_productestoquevhsys->setAllEstoque($produto);
		if($resultado === true){
			$json['success'] = true;
			$json['retorno'] = "ATUALIZADO";			
		}else {
			$json['success'] = false;
			$json['retorno'] = "Falha ao Atualizar Estoque lokao!";
		}
		
		$this->response->setOutput(json_encode($json));	
	}
	
	
	private function getParameter($tipo){
		
		if(isset($this->request->get['parametro']) && !empty($this->request->get['parametro'])){
			if($tipo == "produtos"){
				if(isset($this->request->get['product_id'])){$parametro['product_id'] = $this->request->get['product_id'];}	
				if(isset($this->request->get['sku'])){$parametro['sku'] = $this->request->get['sku'];}	
				if(isset($this->request->get['status'])){$parametro['status'] = $this->request->get['status'] ;}	
				if(isset($this->request->get['date_added'])){$parametro['date_added'] =  $this->request->get['date_added'] ;}		
				if(isset($this->request->get['date_modified'])){$parametro['date_modified'] =  $this->request->get['date_modified'] ;}		
				if(isset($this->request->get['name'])){$parametro['name'] =  $this->request->get['name'] ;}		
			}
			if($tipo == "pedidos"){
				if(isset($this->request->get['order_id'])){$parametro['order_id'] = $this->request->get['order_id'];}	
				if(isset($this->request->get['offset'])){$parametro['offset'] = $this->request->get['offset'];}	
				if(isset($this->request->get['limit'])){$parametro['limit'] = $this->request->get['limit'] ;}
				if(isset($this->request->get['date_modified'])){$parametro['date_modified'] = $this->request->get['date_modified'] ;}	
			}
			if($tipo == "id_pedido"){
				if(isset($this->request->get['order_id'])){$parametro['order_id'] = $this->request->get['order_id'];}	
			}
			if($tipo == "cliente"){
				if(isset($this->request->get['customer_id'])){$parametro['customer_id'] = $this->request->get['customer_id'];}	
			}
		}else{
			$parametro = null;			
		}		
	
		return $parametro;
	}

	public function authenticationApi(){
		$this->checkPlugin();
		$json['success'] 	= false;
		$json['error'] 	= "Autenticado";
		$this->response->setOutput(json_encode($json));
	}
	
	private function checkPlugin() {

		$json = array("success"=>false);

		/*check rest api is enabled*/
		if (!$this->config->get('rest_api_status')) {
			$json["error"] = 'API não habilitada!';
		}
		
		/*validate api security key*/
		if ($this->config->get('rest_api_key') && (!isset($this->request->get['key']) || $this->request->get['key'] != $this->config->get('rest_api_key'))) {
			$json["error"] = 'Codigo key Invalido';
		}
		
		if(isset($json["error"])){
			$this->response->addHeader('Content-Type: application/json');
			echo(json_encode($json));
			exit;
		}else {
			$this->response->setOutput(json_encode($json));			
		}	
	}	
}

