<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gender_table extends CI_Controller
{
    function __construct()
        {
            parent::__construct();
            $this->load->model('Cat_model');
        }

    function index()
        {
            if(!empty($_POST))
            {

                $this->form_validation->set_rules('gender_name', 'gender name', 'trim|required');
                      
                if ($this->form_validation->run() == TRUE)
                {
                    if($this->input->post('gender_id')=="")
                        {

                            $tabledata = array(
                                                'gender_name' => $this->input->post('gender_name')
                                              ); 
                                print_r($tabledata);                  
                            $result=$this->Cat_model->insert($tabledata);

                              if($result)
                                {
                                $this->session->set_flashdata('res', 'success');
                                redirect(base_url("/index.php/Gender_table"));
                                }
                        }

                   else
                        {
                            $field_list = array(
                                                'gender_name' => $this->input->post('gender_name')
                                                ); 
                            $where = array('gender_id'  => $this->input->post('gender_id'));
                            $result=$this->Cat_model->update('gender',$field_list,$where);

                                if($result)
                                {
                                    $this->session->set_flashdata('res', 'success');
                                    redirect(base_url("/index.php/gender_table"));
                                }

                        } 
                }                         
            }

            $viewdata['success']   =   $this->session->flashdata('res');
            $field_list            =   array('gender_id','gender_name','status');
            $where                 = array ('');  
           
           $viewdata['tablelist']=$this->Cat_model->get_data('gender', $field_list,$where);               
            $this->load->view('gender_form',$viewdata);
        }

    function edit($gender_id)
        {
            $field_list            =   array('gender_id','gender_name','status');
            $where = array('gender_id'  => $gender_id);     
            $viewdata['tabledata'] =   $this->Cat_model->get_data('gender',$field_list,$where);
            $viewdata['tablelist']=$this->Cat_model->get_data('gender', $field_list,$where);      
            $this->load->view('gender_form',$viewdata);
        }

    function list()
        {

            //set table id in table open tag
            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
            $this->table->set_template($tmpl);

            $this->table->set_heading('gender_name','status','Action');

            $this->load->view('gender_form');
            //$this->data['table']=$this->Common_model->getdata();
            //$this->load->view('Datatable',$this->data);
        }

    function datatable()
        {
            $this->datatables->select('gender_name','status','Action')
            ->from('gender');

            // $this->datatables->unset_column('s_no');
            $this->datatables->edit_column('gender_id', '$1', 'get_buttons(gender_id)');
            echo $this->datatables->generate();
        }

    function delete($gender_id)
        {
            $where = array('gender_id' =>$gender_id);
            $result=$this->Cat_model->delete('gender',$where);
                if($result)
                {
                $this->session->set_flashdata('res', 'deleted successfully');
                redirect(base_url("/index.php/Gender_table"));

                }
            $viewdata['success']   =  $this->session->flashdata('res');
            $viewdata['tablelist'] =  $this->Cat_model->get_data('gender',$field_list,'');
            $this->load->view('gender_form',$viewdata);

        } 

}

?>