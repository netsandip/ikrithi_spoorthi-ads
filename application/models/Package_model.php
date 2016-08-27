<?php

class Package_Model extends CI_Model {

    private $_tablename;

    function __construct() {
        parent::__construct();

        $this->_tablename = "packages";
    }

    public function total_records() {
        return $this->db->count_all($this->_tablename);
    }

    public function find_all($limit = NULL, $offset = NULL) {
        if ($limit != NULL && $offset != NULL) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get($this->_tablename);

        if ($query->num_rows() > 0) {
            return $query->result();
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
        $columns = array('',
            $this->_tablename . '.name',
            'publications.name',
            'ad_types.name',
            $this->_tablename . '.paid',
            $this->_tablename . '.free',
            ''
        );
        $this->db->select($this->_tablename . '.id,' . $this->_tablename . '.name AS package_name,publications.name AS publication_name,ad_types.name AS ad_type_name,paid,free');

        if (isset($data['search']) && $data['search'] != '') {
            $this->db->like($this->_tablename . '.name', $data['search']);
        }
        if (isset($data['sort']) && $data['sort'] != '') {
            $this->db->order_by($columns[$data['sort']], strtoupper($data['order']));
        }
        $this->db->join('publications', 'publications.id = ' . $this->_tablename . '.publication_id', 'left');
        $this->db->join('ad_types', 'ad_types.id = ' . $this->_tablename . '.ad_type_id', 'left');

        $db_count = clone $this->db;

        $this->db->limit($data['limit'], $data['offset']);
        $query = $this->db->get($this->_tablename);
//        echo $query = $this->db->get_compiled_select($this->_tablename);
        $count = $db_count->count_all_results($this->_tablename);

        $return = array('query' => $query, 'count' => $count);

        if ($query->num_rows() > 0) {
            return $return;
        }
        return FALSE;
    }

    public function find_by_query($data) {
        $this->db->where($data);

        if ($limit != NULL && $offset != NULL) {
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
            'publication_id' => $this->input->post('publication'),
            'ad_type_id' => $this->input->post('ad_type'),
            'paid' => $this->input->post('paid'),
            'free' => $this->input->post('free'),
            'description' => $this->input->post('description'),
            'created' => date('Y-m-d H:i:s', time())
        );
        $this->db->insert($this->_tablename, $data);

        if ($this->db->affected_rows() > 0) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    public function update($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'publication_id' => $this->input->post('publication'),
            'ad_type_id' => $this->input->post('ad_type'),
            'paid' => $this->input->post('paid'),
            'free' => $this->input->post('free'),
            'description' => $this->input->post('description'),
            'modified' => date('Y-m-d H:i:s', time())
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
