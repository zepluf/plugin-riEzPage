<?php

namespace plugins\riEzPage;

use plugins\riCore\Collection;

class EzPages extends Collection{	
	
    protected $from = TABLE_EZPAGES;
		
	public function findByName($name, $limit = 20){
		global $db;
		$sql = "SELECT * 
		        FROM " . TABLE_EZPAGES . "
		 	    WHERE 
				languages_id = :languages_id
				AND pages_title like ':name%'";
		
		if($limit > 0) $sql .= " limit $limit";
		
		$sql = $db->bindVars($sql, ":languages_id", $_SESSION['languages_id'], 'integer');
		$sql = $db->bindVars($sql, ":name", $name, 'noquotestring');
		
		$result = $db->Execute($sql);
		
		if($result->RecordCount() > 0){
			$collection = array();
			while(!$result->EOF){
				$category = $this->container->get('riEzPage.EzPage');			
				$category->setArray($result->fields);	
				$collection[] = $category;
				$result->MoveNext();
			}		
			return $collection;
		}
		
		return false;
	}
	
	public function getResultClass(){
		
		
	}
	
	public function isFinal(){
		
	}
}