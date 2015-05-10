<?php

/*
  Pagination class sem sækjir upplýsingar úr töflu í gagnagrunni til notkunar fyrir pagination 
*/

class pagination {
    private $_db,
            $_data,
            $_totalMovies;
    public function __construct($getTable = null, $page = null, $limit = null) {
    	$this->_db = DB::getInstance();
    	$this->get_limit($getTable, $page, $limit);
    	$this->get_total($getTable);
    }  
    /* Sækjir úr gagnagrunni allar upplýsingar úr töflu */
	public function get_total($getTable = null) {
		$getTotal = $this->_db->getView("{$getTable}");
		if ($getTotal->count()) {
			$this->_totalMovies = $getTotal->results();
			return true;
		}
		return false;
	}
	public function get_limit($getTable = null, $page = null, $limit = null) {
        if ($page) {
            //$field = (is_numeric($page)) ? 'page' : 'pageid';
            $getPage = ($page - 1) * $limit;
            $data  = $this->_db->getView("{$getTable} ORDER BY id ASC LIMIT {$getPage}, {$limit}");
            if ($data->count()) {
                $this->_data = $data->results();
                return true;
            }
            return false;
        }
	}

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }
    public function getPages(){
        return $this->_totalMovies;
    }
}