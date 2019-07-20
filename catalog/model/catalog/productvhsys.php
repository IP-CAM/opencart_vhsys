<?php	
class ModelCatalogProductVhsys extends Model {	
	//PLUGIN
	
	/*SELECIONA TODOS OS PRODUTOS */
	public function getAllProduct(){
		$select_all  = "SELECT p.product_id,p.model,p.image,p.sku,p.quantity,p.price,p.weight,p.length,";
		$select_all .= "p.width,p.height,p.status,p.date_added,p.date_modified,pd.name,";
		$select_all .= "pd.description FROM " . DB_PREFIX . "product p INNER JOIN " . DB_PREFIX . "product_description pd ON p.product_id = ";
		$select_all .= "pd.product_id LEFT JOIN " . DB_PREFIX . "product_attribute pa ON p.product_id = pa.product_id";
		$select_all .= " GROUP BY p.product_id";
		$query = $this->db->query($select_all);
		return $query->rows;
	}
	
	//QUANTIDADE DE PRODUTOS
	public function getCountProduct(){
		$cont_product = "SELECT COUNT(product_id) as NrProducts FROM " . DB_PREFIX . "product ";
		$query = $this->db->query($cont_product);
		return $query->rows;
	}
	
	//PRODUTOS COM FILTRO
	public function getAllProductFilters($filters){
		$InstSql = "" ;
		if(isset($filters['product_id'])){$InstSql .= " AND p.product_id = '".$filters['product_id']."' ";}
		if(isset($filters['sku'])){ $InstSql .= " AND p.sku LIKE '%".$filters['sku']."%' ";}	
		if(isset($filters['status'])){ $InstSql .= " AND p.status = '".$filters['status']."' ";}	
		if(isset($filters['date_added'])){ $InstSql .= " AND p.date_added = '".$filters['date_added']."' ";}		
		if(isset($filters['date_modified'])){ $InstSql .= " AND p.date_modified = '".$filters['date_modified']."' ";}		
		if(isset($filters['name'])){ $InstSql .= " AND pd.name LIKE '%".$filters['name']."%' ";}		
		
		$select_all_filter  = " SELECT p.product_id,p.model,p.sku,p.quantity,p.price,p.weight,p.length,";
		$select_all_filter .= " p.width,p.height,p.status,p.date_added,p.date_modified,pd.name,";
		$select_all_filter .= " pd.description FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = ";
		$select_all_filter .= " pd.product_id LEFT JOIN " . DB_PREFIX . "product_attribute pa ON p.product_id = pa.product_id WHERE p.product_id > 0 ";
		$select_all_filter .= " ".$InstSql."  GROUP BY p.product_id";
		$query = $this->db->query($select_all_filter);
		return $query->rows;
	}
}
?>
