<?php
class Crud_model extends CI_model{

    private $table_cruds = cruds_table::sql_tbl_crud;
   

    public function __construct()
    {
        parent::__construct();
    }

        function insert($id='',$save_data=[]){
            $this->db->insert($this->table_cruds, $save_data);
            return $id       = $this->db->insert_id();
        }
    
    function save($id='', $save_data=[])
    {
        $response         = ['error' => 1, 'message' => 'Invalid request'];

        if(!empty($save_data))
        {
            if(!empty($id))
            {
                $this->db->where('id', $id);
                $this->db->update($this->table_cruds, $save_data);
            }
            else
            {
                $this->db->insert($this->table_cruds, $save_data);
                $id       = $this->db->insert_id();
            }

            if($this->db->affected_rows())
            {
                $response = ['error' => 0, 'message' => 'Customer successfully saved'];
            }
            else
            {
                $response = ['error' => 1, 'message' => 'Unable to save a customer'];
            }
        }
        return $response;
    }

    function get_details($id='')
    {
        $this->db->select('*');
        $this->db->from($this->table_cruds);
        // $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('id', $id);
        $this->db->where('status !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }
    function change($id='', $status)
    {
        $update['status']           = $status;
       
        $this->db->where('id', $id);
        // $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->update($this->table_cruds, $update);

        return $this->db->affected_rows();
    }

   
    function all() {
        // $this->db->select('*');
        // $this->db->from($this->table_cruds);
        // $this->db->where('id', $id);
        // $this->db->where('status !=', '-1');
        $users = $this->db->get($this->table_cruds);
          return $users->result();
        
        }
 
   
    function check_unique($conditions=[])
    {
        $this->db->select('*');
        $this->db->from($this->table_customers);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        $data  = $query->row_array();
        if(!empty($data))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}
?>
