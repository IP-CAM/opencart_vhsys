<?php
class ModelAccountOrderVhsys extends Model {
	
	//PLUGIN ALTERADO EM 02/12/2015
	
	//BUSCAR TODOS OS PEDIDOS
	public function getAllOrders() {
		$select_pedidos  = " SELECT o.order_id, o.firstname, o.lastname,o.email, o.telephone, o.total, o.currency_code, o.currency_value,";
		$select_pedidos .= " o.customer_id,o.date_added,o.payment_firstname,o.payment_lastname,o.payment_company,o.payment_address_1,o.payment_address_2,";
		$select_pedidos .= " o.payment_city,o.payment_postcode,o.payment_country,o.payment_zone,o.payment_method,o.payment_code,o.shipping_firstname,";
		$select_pedidos .= " o.shipping_lastname,o.shipping_company,o.shipping_address_1,o.shipping_address_2,o.shipping_city,o.shipping_postcode,";
		$select_pedidos .= " o.shipping_country,o.shipping_zone,o.shipping_method,o.shipping_code,o.comment,os.name as status_ped FROM " . DB_PREFIX . "order o ";
		$select_pedidos .= " LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id) LEFT JOIN " . DB_PREFIX . "order_history oh ";
		$select_pedidos .= " ON  oh.order_id = o.order_id WHERE o.order_status_id > '0' GROUP BY o.order_id ORDER BY o.order_id DESC " ;
		$query = $this->db->query($select_pedidos);
		return $query->rows;
	}
	
	
	//BUSCAR TODOS OS PEDIDOS COM FILTROS
	public function getAllOrdersFilters($filters) {
		
		$InstSql = "" ;
		if(isset($filters['order_id'])){$InstSql .= " AND o.order_id = '".$filters['order_id']."' ";}
		if(isset($filters['date_modified'])){$InstSql .= " AND o.date_modified >= '".$filters['date_modified']."' ";}
		
		$select_pedidos  = " SELECT o.order_id, o.firstname, o.lastname, o.email, o.telephone, o.total, o.currency_code, o.currency_value,";
		$select_pedidos .= " o.customer_id,o.date_added,o.payment_firstname,o.payment_lastname,o.payment_company,o.payment_address_1,o.payment_address_2,";
		$select_pedidos .= " o.payment_city,o.payment_postcode,o.payment_country,o.payment_zone,o.payment_method,o.payment_code,o.shipping_firstname,";
		$select_pedidos .= " o.shipping_lastname,o.shipping_company,o.shipping_address_1,o.shipping_address_2,o.shipping_city,o.date_modified,";
		$select_pedidos .= " o.shipping_postcode,o.shipping_country,o.shipping_zone,o.shipping_method,o.shipping_code,o.comment,os.name as status_ped ";
		$select_pedidos .= " FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id)";
		$select_pedidos .= " LEFT JOIN " . DB_PREFIX . "order_history oh ON  oh.order_id = o.order_id WHERE o.order_id > 0 ";
		$select_pedidos .= "  AND o.order_status_id > 0 ".$InstSql." GROUP BY o.order_id ";
		$query = $this->db->query($select_pedidos);		
		return $query->rows;
					
	}
	//BUSCA OS DADOS DO PRODUTO DE ACORDO COM O PEDIDO
	public function getAllOrdersProduct($filters){
		$InstSql = "" ;
		if(isset($filters['order_id'])){$InstSql .= " AND op.order_id = '".$filters['order_id']."' ";}
		
		$select_produtos  = " SELECT op.*,o.sku,o.image,o.quantity as estoque FROM " . DB_PREFIX . "order_product op INNER JOIN " . DB_PREFIX . "product o ";
		$select_produtos .= " ON op.product_id = o.product_id INNER JOIN " . DB_PREFIX . "order_history oh ON oh.order_id = op.order_id	";
		$select_produtos .= " WHERE op.order_id > 0 ".$InstSql." GROUP BY op.product_id";

		$query = $this->db->query($select_produtos);		
		return $query->rows;
		
	}
	
	//BUSCA OS DADOS ADICIONAIS DO PEDIDO 
	public function getAllOrdersTotal($filters){
		$InstSql = "" ;
		if(isset($filters['order_id'])){$InstSql .= " AND order_id = '".$filters['order_id']."' ";}
		$select_produtos  = "SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id > 0 ".$InstSql."";
		$query = $this->db->query($select_produtos);		
		return $query->rows;
	}
}
?>