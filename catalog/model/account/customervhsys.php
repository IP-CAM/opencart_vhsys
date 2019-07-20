<?php
class ModelAccountCustomerVhsys extends Model {
	/* PLUGIN */
	public function getCustomerAll($filters){	
		
		$InstSql = "" ;
		if(isset($filters['customer_id'])){$InstSql .= " AND oc.customer_id = '".$filters['customer_id']."' ";}
		
		$select_customer = "SELECT oc.customer_id,oc.firstname,oc.lastname,oc.email,oc.telephone,oc.date_added,oa.company,oa.address_1,oa.address_2,oa.city,oa.postcode, ";
		$select_customer.= " oc.fax,oc.custom_field,oz.name as estado_cliente,oz.code as code_estado_cliente FROM " . DB_PREFIX . "customer oc ";
		$select_customer.= " LEFT JOIN " . DB_PREFIX . "address oa ON oc.customer_id = oa.customer_id LEFT JOIN " . DB_PREFIX . "zone as oz ";
		$select_customer.= " ON oz.zone_id = oa.zone_id  WHERE oc.status = 1  ".$InstSql."  ";
		
		$query = $this->db->query($select_customer);
		return $query->rows;
	}
	
	public function getFieldsAll(){
		$select_campos = " SELECT custom_field_id FROM " . DB_PREFIX . "custom_field_description WHERE name = 'CPF' ";
		$query = $this->db->query($select_campos);
		return $query->rows;
	}
}
?>