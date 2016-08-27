<?php

class Edition_Model extends CI_Model {

    private $_tablename;

    function __construct() {
        parent::__construct();

        $this->_tablename = "editions";
    }

    public function total_records() {
        return $this->db->count_all($this->_tablename);
    }

    public function find_all($limit=NULL,$offset=NULL,$order = array()) {
        if($limit != NULL && $offset != NULL) {
            $this->db->limit($limit, $offset);
        }
        if(!empty($order)) {
            $this->db->order_by($order['column'],$order['dir']);
        }
        $query = $this->db->get($this->_tablename);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    
    public function find_all_array($limit=NULL,$offset=NULL,$order = array()) {
        if($limit != NULL && $offset != NULL) {
            $this->db->limit($limit, $offset);
        }
        if(!empty($order)) {
            $this->db->order_by($order['column'],$order['dir']);
        }
        $query = $this->db->get($this->_tablename);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function find_by_id($id = NULL) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->_tablename);

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function get_view($data) {
        $columns = array('','name','');
        $this->db->select('id,name');

        if(isset($data['search']) && $data['search'] != '') {
            $this->db->like('name',$data['search']);
        }
        if(isset($data['sort']) && $data['sort'] != '') {
            $this->db->order_by($columns[$data['sort']], strtoupper($data['order']));
        }
        
        $db_count = clone $this->db;

        $this->db->limit($data['limit'],$data['offset']);
        $query = $this->db->get($this->_tablename);
        $count = $db_count->count_all_results($this->_tablename);
        
        $return = array('query' => $query, 'count' => $count);
        
        if ($query->num_rows() > 0) {
            return $return;
        }
        return FALSE;
    }

    public function find_by_query($data) {
        $this->db->where($data);

        if($limit != NULL && $offset != NULL) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get($this->_tablename);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function create() {
        $data = array(
            'name' => $this->input->post('name'),
            'created' => date('Y-m-d H:i:s',time())
        );
        $this->db->insert($this->_tablename, $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function update($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'modified' => date('Y-m-d H:i:s',time())
        );

        $this->db->where('id', $id);
        $this->db->update($this->_tablename, $data);

        $affected_rows = $this->db->affected_rows();
        if ($affected_rows > 0) {
            return $affected_rows;
        }
        return FALSE;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_tablename);

        $affected_rows = $this->db->affected_rows();

        if ($affected_rows > 0) {
            return $affected_rows;
        }
        return FALSE;
    }

}
