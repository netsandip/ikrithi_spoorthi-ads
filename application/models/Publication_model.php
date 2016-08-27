<?php

class Publication_Model extends MY_Model {


    function __construct() {
        parent::__construct();

        $this->_tablename = "publications";
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
    
    public function find_not_in($column,$data,$limit = NULL, $offset = NULL) {
        if ($limit != NULL && $offset != NULL) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where_not_in($column, $data);
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
    
    public function get_editions($id = NULL) {
//        $this->db->select('edition_id');
        $this->db->select('editions.id AS edition_id,editions.name AS edition_name');
        $this->db->where('publication_id', $id);
        $this->db->join('editions', 'editions.id = publication_to_edition.edition_id', 'left');
        $query = $this->db->get('publication_to_edition');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }
    
    public function get_packages($id = NULL, $ad_type_id = NULL) {
//        $this->db->select('edition_id');
        $this->db->select('packages.id AS package_id,packages.name AS package_name');
        $this->db->where('publication_id', $id);
        $this->db->where('ad_type_id', $ad_type_id);
        $query = $this->db->get('packages');

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function get_view($data) {
        $columns = array('', 'name', '');
        $this->db->select($this->_tablename . '.id,' . $this->_tablename . '.name AS publication_name,editions.name AS edition_name');

        if (isset($data['search']) && $data['search'] != '') {
            $this->db->like($this->_tablename . '.name', $data['search']);
        }
        if (isset($data['sort']) && $data['sort'] != '') {
            $this->db->order_by($this->_tablename . '.' . $columns[$data['sort']], strtoupper($data['order']));
        }
        $this->db->join('publication_to_edition', 'publication_to_edition.publication_id = ' . $this->_tablename . '.id', 'left');
        $this->db->join('editions', 'editions.id = publication_to_edition.edition_id', 'left');

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
            'created' => date('Y-m-d H:i:s', time())
        );
        $this->db->insert($this->_tablename, $data);

        if ($this->db->affected_rows() > 0) {
            $insert_id = $this->db->insert_id();
            foreach ($this->input->post('editions[]') as $edition) {
                $data = array('publication_id' => $insert_id, 'edition_id' => $edition);
                $this->db->insert('publication_to_edition', $data);
            }
            return $insert_id;
        }
        return FALSE;
    }

    public function update($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'modified' => date('Y-m-d H:i:s', time())
        );

        $this->db->where('id', $id);
        $this->db->update($this->_tablename, $data);

        $affected_rows = $this->db->affected_rows();

        $this->db->where('publication_id', $id);
        $this->db->delete('publication_to_edition');
        foreach ($this->input->post('editions[]') as $edition) {
            $data = array('publication_id' => $id, 'edition_id' => $edition);
            $this->db->insert('publication_to_edition', $data);
        }
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
