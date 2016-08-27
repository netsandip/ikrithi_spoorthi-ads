<?phpdefined('BASEPATH') or die('No direct script access allowed');class Daily_Report_Model extends MY_Model {    function __construct() {        parent::__construct();        $this->_tablename = 'daily_reports';    }    public function total_records() {        return $this->db->count_all($this->_tablename);    }        public function get_daily_reports() {        $this->db->select('clients.name AS client_name,daily_reports.*');        $this->db->join('clients', 'clients.id=daily_reports.client_id', 'left');        $this->db->order_by('daily_reports.created', 'DESC');        $query = $this->db->get($this->_tablename);        if ($query->num_rows() > 0) {            return $query->result();        }        return FALSE;    }    public function find_all($limit = NULL, $offset = NULL, $order = array()) {        if ($limit != NULL && $offset != NULL) {            $this->db->limit($limit, $offset);        }        if (!empty($order)) {            $this->db->order_by($order['column'], $order['dir']);        }        $query = $this->db->get($this->_tablename);        if ($query->num_rows() > 0) {            return $query->result();        }        return FALSE;    }    public function find_all_array($limit = NULL, $offset = NULL, $order = array()) {        if ($limit != NULL && $offset != NULL) {            $this->db->limit($limit, $offset);        }        if (!empty($order)) {            $this->db->order_by($order['column'], $order['dir']);        }        $query = $this->db->get($this->_tablename);        if ($query->num_rows() > 0) {            return $query->result_array();        }        return FALSE;    }    public function find_by_id($id = NULL) {        $this->db->where('id', $id);        $query = $this->db->get($this->_tablename);        if ($query->num_rows() > 0) {            return $query->row();        }        return FALSE;    }    public function get_view($data) {        $columns = array('', 'name', '');        $this->db->select('id,name');        if (isset($data['search']) && $data['search'] != '') {            $this->db->like('name', $data['search']);        }        if (isset($data['sort']) && $data['sort'] != '') {            $this->db->order_by($columns[$data['sort']], strtoupper($data['order']));        }        $db_count = clone $this->db;        $this->db->limit($data['limit'], $data['offset']);        $query = $this->db->get($this->_tablename);        $count = $db_count->count_all_results($this->_tablename);        $return = array('query' => $query, 'count' => $count);        if ($query->num_rows() > 0) {            return $return;        }        return FALSE;    }    public function find_by_query($data) {        $this->db->where($data);        if ($limit != NULL && $offset != NULL) {            $this->db->limit($limit, $offset);        }        $query = $this->db->get($this->_tablename);        if ($query->num_rows() > 0) {            return $query->result();        }        return FALSE;    }    public function create() {        $data = array(            'user_id' => $this->session->userdata('user_id'),            'client_id' => $this->input->post('client'),            'address' => $this->input->post('address'),            'discussion' => $this->input->post('discussion'),            'status' => $this->input->post('status'),            'created' => date('Y-m-d H:i:s', time())        );        $this->db->insert($this->_tablename, $data);        if ($this->db->affected_rows() > 0) {            return $this->db->insert_id();        }        return FALSE;    }    public function update($id) {        $data = array(            'client_id' => $this->input->post('client'),            'address' => $this->input->post('address'),            'discussion' => $this->input->post('discussion'),            'status' => $this->input->post('status'),            'modified' => date('Y-m-d H:i:s', time())        );        $this->db->where('id', $id);        $this->db->update($this->_tablename, $data);        $affected_rows = $this->db->affected_rows();        if ($affected_rows > 0) {            return $affected_rows;        }        return FALSE;    }    public function delete($id) {        $this->db->where('id', $id);        $this->db->delete($this->_tablename);        $affected_rows = $this->db->affected_rows();        if ($affected_rows > 0) {            return $affected_rows;        }        return FALSE;    }}