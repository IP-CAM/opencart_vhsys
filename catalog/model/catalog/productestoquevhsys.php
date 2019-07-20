<?php
class ModelCatalogProductEstoqueVhsys extends Model {
	//PLUGIN
		
	/* ATUALIZA O ESTOQUE DOS PRODUTOS */
	public function setAllEstoque($produto){
		foreach($produto as $array_produtos){
			
			/* VERIFICA SE EXISTE O PRODUTO */
			$texto_select = "SELECT product_id FROM " . DB_PREFIX . "product WHERE product_id = '".$array_produtos->id_produto_opencart."'";
			$query = $this->db->query($texto_select);
			if($query->row > 0){
				$texto_update  = "UPDATE " . DB_PREFIX . "product SET quantity = '".$array_produtos->estoque_produto."' ";
				$texto_update .= " WHERE product_id = '".$array_produtos->id_produto_opencart."' ";
				if($this->db->query($texto_update)){
					$erro = true;	
				} else {
					$erro = false;
					exit();	
				}
			}
		}
		return $erro;
	}
}
?>