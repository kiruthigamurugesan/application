<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class student_table extends CI_Controller
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

                $this->form_validation->set_rules('name', 'name', 'trim|required');
                $this->form_validation->set_rules('father_name', 'fathername', 'trim|required'); 
                $this->form_validation->set_rules('dob', 'dob', 'trim|required');
                $this->form_validation->set_rules('gender', 'gender', 'trim|required');  
                $this->form_validation->set_rules('course_name', 'Area name', 'trim|required');
                $this->form_validation->set_rules('address_line1', 'address', 'trim|required'); 
                $this->form_validation->set_rules('address_line2', 'address', 'trim|required');
                $this->form_validation->set_rules('Pincode', 'Pincode', 'trim|required');  

                if ($this->form_validation->run() == TRUE)
                {
                    if($this->input->post('student_id')=="")
                        {

                            $tabledata = array(
                                                'name'          => $this->input->post('name'),
                                                'father_name'   => $this->input->post('father_name'),
                                                'dob'           => $this->input->post('dob'),
                                                'gender_name'   => $this->input->post('gender_name'),
                                                'course_name'   => $this->input->post('course_name'),
                                                'address_line1'  => $this->input->post('address_line1'),
                                                'address_line2'  => $this->input->post('address_line2'),
                                                                               
                                              ); 
                                print_r($tabledata);                  
                            $result=$this->Cat_model->insert($tabledata);

                                if($result)
                                {
                                $this->session->set_flashdata('res', 'success');
                                redirect(base_url("/index.php/student_table"));
                                }
                        }

                      else
                        {
                            $field_list = arrayarray(
                                                'name'          => $this->input->post('name'),
                                                'father_name'   => $this->input->post('father_name'),
                                                'dob'           => $this->input->post('dob'),
                                                'gender_name'   => $this->input->post('gender_name'),
                                                'course_name'   => $this->input->post('course_name'),
                                                'address_line1' => $this->input->post('address_line1'),
                                                'address_line2' => $this->input->post('address_line2'),
                                                                               
                                              ); 
                            $where = array('student_id'         =>    $this->input->post('student_id'));

                            $result=$this->Cat_model->update('student_detail',$field_list,$where);

                                if($result)
                                {
                                    $this->session->set_flashdata('res', 'success');
                                    redirect(base_url("/index.php/student_table"));
                                }

                        } 
                }                         
            }

            $viewdata['success']   =   $this->session->flashdata('res');
            $field_list            =   array('student_id','name','father_name','dob','gender','course_name','address_line1','address_line2','status');
            $where                 = array ('');
             $viewdata['tablelist']=$this->Cat_model->get_data('student_detail', $field_list,$where);*/    
                          
            $this->load->view('student_form');
        }

    function edit($student_id)
        {
          $field_list = array  (
                                 'student_id','name','father_name','dob','gender_name','course_name','address_line1','address_line2','status'
                               );

            $where  =array('student_id' =>  $student_id);          
            $viewdata['tabledata'] =   $this->Cat_model->get_data('student_detail',$field_list,$where);
             $viewdata['tablelist']=$this->Cat_model->get_data('student_detail', $field_list,$where);     
           
            $this->load->view('student_form',$viewdata);
        }

    function list()
        {

            //set table id in table open tag
            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
            $this->table->set_template($tmpl);

            $this->table->set_heading('student_id','name','father_name','dob',
                                       'gender_name','course_name','address_line1',
                                       'address_line2','status','Action');

            $this->load->view('student_form');
            //$this->data['table']=$this->Common_model->getdata();
            //$this->load->view('Datatable',$this->data);
        }

    function datatable()
        {
            $this->datatables->select('student_id','name','father_name','dob',
                                       'gender_name','course_name','address_line1',
                                       'address_line2','status','Action')
            ->from('student_form');

            // $this->datatables->unset_column('s_no');
            $this->datatables->edit_column('student_id', '$1', 'get_buttons(student_id)');
            echo $this->datatables->generate();
        }

    function delete($student_id)
        {
            $where = array('student_id' =>$student_id);
            $result=$this->Cat_model->delete('student_detail',$where);
                if($result)
                {
                $this->session->set_flashdata('res', 'deleted successfully');
                redirect(base_url("/index.php/student_table"));

                }
            $viewdata['success']   =  $this->session->flashdata('res');
            $viewdata['tablelist'] =  $this->Cat_model->get_data('student_detail',$field_list,'');
            $this->load->view('student_form',$viewdata);

        } 

}

?>