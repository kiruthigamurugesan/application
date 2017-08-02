<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Areatable extends CI_Controller
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

                $this->form_validation->set_rules('Area_name', 'Area name', 'trim|required');
                $this->form_validation->set_rules('Pincode', 'Pincode', 'trim|required');          
                if ($this->form_validation->run() == TRUE)
                {
                    if($this->input->post('Area_id')=="")
                        {

                            $tabledata = array(
                                    'Area_name' => $this->input->post('Area_name'),
                                    'Pincode' => $this->input->post('Pincode'),
                                    'City_id'  => $this->input->post('City_id')                                   
                                              ); 
                                print_r($tabledata);                  
                            $result=$this->Cat_model->insert($tabledata);

                                if($result)
                                {
                                $this->session->set_flashdata('res', 'success');
                                redirect(base_url("/index.php/Areatable"));
                                }
                        }

                   else
                        {
                            $field_list = array('Area_name' => $this->input->post('Area_name'),
                                    'Pincode' => $this->input->post('Pincode'),
                                    'City_id'  => $this->input->post('City_id') );
                            $where = array('Area_id'        =>    $this->input->post('Area_id'));
                            $result=$this->Cat_model->update('area',$field_list,$where);

                                if($result)
                                {
                                    $this->session->set_flashdata('res', 'success');
                                    redirect(base_url("/index.php/Areatable"));
                                }

                        } 
                }                         
            }

            $viewdata['success']   =   $this->session->flashdata('res');
            $field_list            =   array('Area_id','City_id','Area_name','Pincode','status');
            $where                 = array ('');  
            $viewdata['tablelist'] =   $this->Cat_model->join();
            $viewdata['dropdown']  =   $this->Cat_model->get_dropdown();               
            $this->load->view('Area_form',$viewdata);
        }

    function edit($Area_id)
        {
            $field_list            =   array('Area_id','Area_name','Pincode','status');
            $where                  =array('Area_id' =>  $Area_id);          
            $viewdata['tabledata'] =   $this->Cat_model->get_data('area',$field_list,$where);
            $viewdata['tablelist'] =   $this->Cat_model->join();       
            $viewdata['dropdown']  =   $this->Cat_model->get_dropdown();
            $this->load->view('Area_form',$viewdata);
        }

    function list()
        {

            //set table id in table open tag
            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
            $this->table->set_template($tmpl);

            $this->table->set_heading('Area Name', 'Pincode', 'status','Action');

            $this->load->view('Area_form');
            //$this->data['table']=$this->Common_model->getdata();
            //$this->load->view('Datatable',$this->data);
        }

    function datatable()
        {
            $this->datatables->select('Area_name,Pincode,status,Area_id')
            ->from('area');

            // $this->datatables->unset_column('s_no');
            $this->datatables->edit_column('Area_id', '$1', 'get_buttons(Area_id)');
            echo $this->datatables->generate();
        }

    function delete($Area_id)
        {
            $where = array('Area_id' =>$Area_id);
            $result=$this->Cat_model->delete('area',$where);
                if($result)
                {
                $this->session->set_flashdata('res', 'deleted successfully');
                redirect(base_url("/index.php/Areatable"));

                }
            $viewdata['success']   =  $this->session->flashdata('res');
            $viewdata['tablelist'] =  $this->Cat_model->get_data('area',$field_list,'');
            $this->load->view('Area_form',$viewdata);

        } 

}

?>