<?php
class Crud_model extends CI_model{

    private $table_cruds = cruds_table::sql_tbl_crud;
    // private $table_cutomers = cruds_table::sql_tbl_customers;

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
        // $update['modified_on']      = date('Y-m-d H:i:s');
        // $update['modified_by']      = $this->session->userdata('user_id');

        // if($status == '-1')
        // {
        //     $this->db->where('id',$id);
        //     return $this->db->delete($this->table_cruds);
        // }
        $this->db->where('id', $id);
        // $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->update($this->table_cruds, $update);

        return $this->db->affected_rows();
    }

    // function create($formArray)
    // {
    //     $this->db->insert('crud_heaven',$formArray);

    // }
    function all() {
        // $this->db->select('*');
        // $this->db->from($this->table_cruds);
        // $this->db->where('id', $id);
        // $this->db->where('status !=', '-1');
        $users = $this->db->get($this->table_cruds);
          return $users->result();
        
        }
 
    //  function getUser($Id){
    //     $this->db->where('id',$Id);
    //    return $user =  $this->db->get('crud_heaven')->row_array();
    //  }
    //  function fetchSingleData($data,$table,$where)
    // {
    //     $query = $this->db->select($data)
    //                   ->from($table)
    //                   ->where($where)
    //                   ->get();
    //     return $query->row_array();
    // }

    //  function updateUser($Id,$formArray){
    //     $this->db->where('id',$Id);
    //     $this->db->update('crud_heaven',$formArray);
    // }

    //     function get_data($conditions=[], $limit='', $offset=0, $allcount='')
    //     {
    //         $order          = '';
    //         $where          = '1=1';
    //         $like_sql       = '';
    //         $limit_offset   = '';

    //         // Like
    //         if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
    //         {
    //             $term       = $_GET['search'];
    //             $like_sql   = ' AND
    //                             (
    //                                 c.name LIKE "%'.$term.'%" ESCAPE "!"
    //                                  OR c.email LIKE "%'.$term.'%" ESCAPE "!"
    //                                 OR c.mobile LIKE "%'.$term.'%" ESCAPE "!"
    //                                 OR c.pincode LIKE "%'.$term.'%" ESCAPE "!"
    //                                 OR c.address LIKE "%'.$term.'%" ESCAPE "!"
    //                                 OR c.created_on LIKE "%'.$term.'%" ESCAPE "!"
    //                             )
    //                         ';
    //         }

    //         // Where
    //         if(!empty($conditions))
    //         {
    //             foreach ($conditions as $key => $value) {
    //                 $where .= ' AND '.$key.'='.$value;
    //             }
    //         }

    //         // Custom Filter
    //         if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
    //         {
    //             $from_date      = '';
    //             $to_date        = '';
    //             $status         = isset($_GET['custom_search']['status']) ? $_GET['custom_search']['status'] : '';

    //             if(isset($_GET['custom_search']['from_date']) && !empty($_GET['custom_search']['from_date']))
    //             {
    //                 $from_date  = date("Y-m-d", strtotime($_GET['custom_search']['from_date'])).' 00:00:00';
    //             }

    //             if(isset($_GET['custom_search']['to_date']) && !empty($_GET['custom_search']['to_date']))
    //             {
    //                 $to_date    = date("Y-m-d", strtotime($_GET['custom_search']['to_date'])).' 23:59:59';
    //             }

    //             if(!empty($from_date) && !empty($to_date))
    //             {
    //                 $where      .= ' AND c.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
    //             }
    //             else if(!empty($from_date) && empty($to_date))
    //             {
    //                 $where      .= ' AND c.created_on >= "'.$from_date.'"';
    //             }
    //             else if(empty($from_date) && !empty($to_date))
    //             {
    //                 $where      .= ' AND c.created_on <= "'.$to_date.'"';
    //             }

    //             if($status != '')
    //             {
    //                 $where      .= ' AND c.status IN ('.implode(',', $status).')';
    //             }
    //         }

    //         if(!empty($like_sql))
    //         {
    //             $where          .= ' '.$like_sql;
    //         }

    //         // Order
    //         if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
    //         {
    //             if($_GET['sort'] == 'created_on')
    //             {
    //                 $sort_by = 'c.created_on';
    //             }
    //             else if($_GET['sort'] == 'name')
    //             {
    //                 $sort_by = 'c.name';
    //             }
    //          /*   else if($_GET['sort'] == 'member_id')
    //             {
    //                 $sort_by = 'c.member_id';
    //             }*/
    //             else if($_GET['sort'] == 'mobile')
    //             {
    //                 $sort_by = 'c.mobile';
    //             }
    //             else if($_GET['sort'] == 'email')
    //             {
    //                 $sort_by = 'c.email';
    //             }
    //             else if($_GET['sort'] == 'pincode')
    //             {
    //                 $sort_by = 'c.pincode';
    //             }
    //             else if($_GET['sort'] == 'address')
    //             {
    //                 $sort_by = 'c.address';
    //             }
    //             else
    //             {
    //                 $sort_by = 'c.id';
    //             }

    //             if(isset($_GET['order']) && !empty($_GET['order']))
    //             {
    //                 $by      = $_GET['order'];
    //             }
    //             else
    //             {
    //                 $by      = 'DESC';
    //             }
    //             $order       = $sort_by.' '.$by;
    //         } 
    //         else
    //         {
    //             $order       = 'c.id DESC';
    //         }

    //         // Limit
    //         if(empty($allcount))
    //         {
    //             if(isset($_GET['limit']) && $_GET['limit'] != -1)
    //             {
    //                 $offset = $_GET['offset'];
    //                 $limit  = $_GET['limit'];
    //             }
    //             else if($limit)
    //             {
    //                 $limit  = $limit;
    //             }
    //             $offset     = !empty($offset) ? $offset : 0;

    //             if($limit > 0)
    //             {
    //                 $limit_offset = !empty($limit) ? $limit.', '.$offset : '';
    //             }
    //         }

    //         $this->db->select('c.*');
    //         //$this->db->from($this->table_customers.' c');
    //         $this->db->from("crud_heaven".' c');
    //         $this->db->where($where);
    //         $this->db->order_by($order);
    //         if($allcount != 'allcount')
    //         {
    //             if($limit > 0 && $offset > 0)
    //             {
    //                 $this->db->limit($limit, $offset);
    //             }
    //             else
    //             {
    //                 if(!empty($limit))
    //                 {
    //                     $this->db->limit($limit);
    //                 }
    //             }
    //         }
    //         $query = $this->db->get();

    //         // echo "<pre>";print_r($this->db->last_query());exit;

    //         if($allcount == 'allcount')
    //         {
    //             return $query->num_rows();
    //         }
    //         else
    //         {
    //             return $query->result();
    //         }
    //     }
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