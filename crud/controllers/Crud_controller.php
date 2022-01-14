<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Crud_controller extends MY_Controller {

        function __construct() 
        {
            parent::__construct();

        //    $this->load->model('Crud_model');
           $this->load->model('crud_model', 'crud');
        }
        

        function index()
        {
            $data['meta_title']             = "Crud";
            $data['meta_description']       = "Crud";
            $data['meta_keywords']          = "Crud";
            $data['page_title']             = "Crud";
            $data['module']                 = "Crud";
            $data['menu']                   = "crud";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Crud', cruds_constants::crud_form_url);
            $this->breadcrumbs->unshift(2, 'Add',  cruds_constants::crud_add_url);
            $this->breadcrumbs->unshift(3, 'List', '#');


            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "crud/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            // $condition          = ['c.status !' => '-1', 'c.user_id' => $this->session->userdata('user_id')];
            $list               = $this->crud->all();
            $tabledata          = [];
            // $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on = 'NA';
                }

                $status         = '';
                $customer_id    = $value->id;

                if($value->status == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$customer_id.', 0, this);" data-type="customer" data-function="'.base_url().cruds_constants::crud_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$customer_id.', 1, this);" data-type="customer" data-function="'.base_url().cruds_constants::crud_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }
                else if($value->status == '-1')
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$customer_id.', -1, this);" data-type="customer" data-function="'.base_url().cruds_constants::crud_status_url.'"><span class="badge badge-info">Deleted</span></a>';
                }

                $action = '
                            <span class="dropdown action-dropdown d-flex justify-content-center">
                                <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">';
                                $action .= '<a class="dropdown-item" title="Edit" href="'.base_url().cruds_constants::crud_edit_url.'/'.$value->id.'">Edit</a>';
                                $action .= '<a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="customer" data-function="'.base_url().cruds_constants::crud_status_url.'">Delete</a>';
                                $action .= '</span>
                            </span>
                        ';

                $view   = '<a class="" href="'.base_url().cruds_constants::crud_edit_url.'/'.$value->id.'" title="Edit '.$value->name.'">'.$value->name.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                // $row['member_id']                               = $value->member_id;
                $row['name']                                    = $view;
                $row['email']                                   = $value->email;
                $row['mobile']                                  = $value->mobile;
                $row['pincode']                                 = $value->pincode;
                $row['address']                                 = $value->address;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        // "total"      => $this->crud->all(),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('user_id', 'USER Id', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('name', 'Name', 'required|max_length[191]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'required|max_length[10]|trim|xss_clean|strip_tags|callback_custom_mobile[mobile]|callback_unique_mobile[mobile]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[50]|trim|xss_clean|strip_tags|callback_custom_email[email]|callback_unique_email[email]');
            if(isset($_POST['pincode']) && !empty($_POST['pincode']))
            {
                $this->form_validation->set_rules('pincode', 'Pincode', 'min_length[6]|max_length[6]trim|xss_clean|strip_tags');
            }
            $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean|strip_tags');
            // $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|strip_tags');
        }

        function add()
        {
            $data['meta_title']             = "Add";
            $data['meta_description']       = "Add";
            $data['meta_keywords']          = "Add";
            $data['page_title']             = "Add";
            $data['module']                 = "Crud";
            $data['menu']                   = "Crud";
            $data['submenu']                = "add";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['status']    = 1;


        //    $this->form_validation_rules($data);
          

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }  

            // if($this->form_validation->run($this) === TRUE)
            // {
                if($this->input->post())
                {
                   $response               = $this->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().cruds_constants::crud_form_url);
                }
            // }
            

            $this->breadcrumbs->unshift(1, 'Crud', cruds_constants::crud_form_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "crud/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($id))
            {
                $data['meta_title']         = "Edit Customer";
                $data['meta_description']   = "Edit Customer";
                $data['meta_keywords']      = "Edit Customer";
                $data['page_title']         = "Edit Customer";
                $data['module']             = "Customers";
                $data['menu']               = "customers";
                $data['submenu']            = "add";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                // $this->form_validation_rules($data);

                // if($this->form_validation->run($this) === TRUE)
                // {
                    if($this->input->post())
                    {
                        $response           = $this->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().cruds_constants::crud_form_url);
                    }
                // }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->crud->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Customer not found']);
                        redirect(base_url().cruds_constants::crud_form_url);
                    }
                }

                $this->breadcrumbs->unshift(1, 'Crud', cruds_constants::crud_form_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']            = "crud/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().cruds_constants::crud_form_url);
            }
        }

        private function save($id, $post_data)
        {
            $response                                   = ['error' => 1, 'message' => 'Access denied'];

            if(!empty($post_data))
            {
                // $save['member_id']                      = htmlentities($post_data['member_id']);
                $save['name']                           = htmlentities($post_data['name']);
                $save['email']                          = htmlentities($post_data['email']);
                $save['mobile']                         = htmlentities($post_data['mobile']);
                $save['address']                        = $post_data['address'];
                $save['pincode']                        = htmlentities($post_data['pincode']);
                $save['status']                         = htmlentities($post_data['status']);
                $save['user_id']                        = htmlentities($post_data['user_id']);

                $response                           = $this->crud->save($id, $save);
                // if(empty($id))
                // {
                //     if(isset($post_data['password']) && !empty($post_data['password']))
                //     {
                //         $password                       = $post_data['password'];
                //     }
                //     else
                //     {
                //         $password                       = $this->common_lib->generatePassword();
                //     }

                //     $save['user_id']                    = $this->session->userdata('user_id');
                //     $save['password']                   = password_hash($password, PASSWORD_DEFAULT);
                //     $save['created_on']                 = date('Y-m-d H:i:s');
                //     $save['created_by']                 = $this->session->userdata('user_id');

                //     $response                           = $this->customers->save($id, $save);
                //     if($response['error'] == 0 && empty($id))
                //     {
                //         $save['password']               = $password;
                //     }
                // }
                // else
                // {
                //     $save['modified_on']                = date('Y-m-d H:i:s');
                //     $save['modified_by']                = $this->session->userdata('user_id');
                //     $response                           = $this->customers->save($id, $save);
                // }
            }
            return $response;
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Invalid request'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $type       = isset($_POST['type']) ? $_POST['type'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->crud->get_details($id);

                if(!empty($details))
                {
                    if($status == '-1')
                    {
                        $message = 'deleted';
                    }
                    else if($status == 1)
                    {
                        $message = 'activated';
                    }
                    else if($status == 0)
                    {
                        $message = 'in-activated';
                    }

                    if($this->crud->change($id, $status))
                    {
                        $response   = ['error' => 0, 'message' => ucfirst($type).' successfully '.$message];
                    }
                    else
                    {
                        $response   = ['error' => 1, 'message' => 'Unable to perform this action'];
                    }
                }
                else
                {
                    $response   = ['error' => 1, 'message' => 'No '.$type.' found'];
                }
            }
            echo json_encode($response);
        }

        function check_unique_mobile()
        {
            if($this->input->post())
            {
                $result = $this->unique_mobile($this->input->post('mobile'), '');
                echo $result;exit;
            }
        }

        function check_unique_email()
        {
            if($this->input->post())
            {
                $result = $this->unique_email($this->input->post('email'), '');
                echo $result;exit;
            }
        }

        function unique_mobile($str, $func)
        {
            $id             = '';
            $conditions     = ['status !=' => '-1', 'mobile' => $str];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'mobile' => $str, 'id !=' => $_POST['id']];
            }

            $this->form_validation->set_message('unique_mobile', 'Mobile already exist');
            $result         = $this->crud->check_unique($conditions);
            return $result;
        }

        function unique_email($str, $func)
        {
            $id             = '';
            $conditions     = ['status !=' => '-1', 'email' => $str];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'email' => $str, 'id !=' => $_POST['id']];
            }

            $this->form_validation->set_message('unique_email', 'Email already exist');
            $result         = $this->crud->check_unique($conditions);
            return $result;
        }

}

            
?>
