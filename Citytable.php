<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Citytable extends CI_Controller
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
           
            $this->form_validation->set_rules('City_name', 'City Name', 'trim|required');

            if ($this->form_validation->run() == TRUE)
            {
                if($this->input->post('City_id')=="")
                {              

                    $tabledata = array('City_name' => $this->input->post('City_name')                               
                                      );                   
                    $result=$this->Cat_model->insert($tabledata);              
               
                    if($result)
                    {
                        $this->session->set_flashdata('res', 'success');
                        redirect(base_url("/index.php/Citytable"));
                    }
                }
               else
                {
                    $field_list = array('City_name' =>   $this->input->post('City_name'));
                    $where = array('City_id'        =>    $this->input->post('City_id'));
                    $result=$this->Cat_model->update('city',$field_list,$where);

                    if($result)
                    {
                        $this->session->set_flashdata('res', 'success');
                        redirect(base_url("/index.php/Citytable"));
                    }

                }                
              
            }          

        }
        $viewdata['success']=$this->session->flashdata('res');
        $field_list= array('City_id','City_name','status');
        $where       = array ('');
        $viewdata['tablelist']=$this->Cat_model->get_data('city', $field_list,$where);
        $this->load->view('City_form',$viewdata);
       
    }

    function edit($City_id)
    {
        $field_list            =   array('City_id','City_name','status');
        $where=array('City_id' =>  $City_id);          
        $viewdata['tabledata'] =   $this->Cat_model->get_data('city',$field_list,$where);
        $viewdata['tablelist'] =    $this->Cat_model->get_data('city',$field_list,'');
        $this->load->view('City_form',$viewdata);
    
    }

    function delete($City_id)
        {
            $where = array('City_id' =>$City_id);
            $result=$this->Cat_model->delete('city',$where);
            if($result)
            {
                $this->session->set_flashdata('res', 'deleted successfully');
                redirect(base_url("/index.php/Citytable"));

            }
            $viewdata['success']   =  $this->session->flashdata('res');
            $viewdata['tablelist'] =  $this->Cat_model->select('city',$field_list,'');
            $this->load->view('City_form',$viewdata);

        } 

    public function list()
        {

            //set table id in table open tag
            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
            $this->table->set_template($tmpl);

            $this->table->set_heading('City Name','Status','Action');

            $this->load->view('City_form');



            //$this->data['table']=$this->Common_model->getdata();


            //$this->load->view('Datatable',$this->data);

        }

        function datatable()
        {
            $this->datatables->select('City_name,status,City_id')
                ->from('city');
           
           // $this->datatables->unset_column('s_no');
            $this->datatables->edit_column('City_id', '$1', 'get_buttons(City_id)');
            echo $this->datatables->generate();
        }

        

}

?>