<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_table extends CI_Controller
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
      $this->form_validation->set_rules('address_line1', 'address', 'trim|required'); 
      $this->form_validation->set_rules('address_line2', 'address', 'trim|required');

        if ($this->form_validation->run() == TRUE )
        {
          if($this->input->post('student_id')=="")
          {

            $tabledata = array(
                              'student_id'    => $this->input->post('student_id'),
                              'name'          => $this->input->post('name'),
                              'father_name'   => $this->input->post('father_name'),
                              'dob'           => $this->input->post('dob'),
                              'gender_id'     => $this->input->post('gender_id'),
                              'course_id'     => $this->input->post('course_id'),
                              'address_line1' => $this->input->post('address_line1'),
                              'address_line2' => $this->input->post('address_line2'),
                              'City_id'       => $this->input->post('City_id'),
                              'Area_id'       => $this->input->post('Area_id'),
                              'Pincode'       => $this->input->post('Pincode')

                            ); 
            // print_r($tabledata);                  
            $result=$this->Cat_model->insert('student_detail',$tabledata);

            if($result)
            {
            $this->session->set_flashdata('res', 'success');
            redirect(base_url("/index.php/Student_table"));
            }
          }

          else
          {
            $field_list = array(
                                    'name'          => $this->input->post('name'),
                                    'father_name'   => $this->input->post('father_name'),
                                    'dob'           => $this->input->post('dob'),
                                    'gender_id'     => $this->input->post('gender_id'),
                                    'course_id'     => $this->input->post('course_id'),
                                    'address_line1' => $this->input->post('address_line1'),
                                    'address_line2' => $this->input->post('address_line2'), 
                                      ); 
            $where = array('student_id'         =>    $this->input->post('student_id'));

            $result=$this->Cat_model->update('student_detail',$field_list,$where);

            if($result)
            {
              $this->session->set_flashdata('res', 'success');
              redirect(base_url("/index.php/Student_table"));
            }

          } 
        }                         
      
    }


      $field_list=array('gender_id','gender_name');
      $genderData=$this->Cat_model->get_data('gender',$field_list,"");
      $cityoption=array();
      foreach ($genderData as $row)
      {
      $cityoption[$row->gender_id]= $row->gender_name;
      }
      $viewdata['genderData']=$cityoption;


      $field_list=array('course_id','course_name');
      $courseData=$this->Cat_model->get_data('coursemaster',$field_list,"");
      $courseoption=array();
      foreach ($courseData as $row)
      {
      $courseoption[$row->course_id]= $row->course_name;
      }
      $viewdata['courseData']=$courseoption;


      $field_list=array('City_id','City_name');
      $cityData=$this->Cat_model->get_data('city',$field_list,"");
      $cityoption=array();
      foreach ($cityData as $row)
      {
      $cityoption[$row->City_id]= $row->City_name;
      }
      $viewdata['cityData']=$cityoption; 

      $viewdata['tablelist']=$this->Cat_model->get_data('city', $field_list,"");
      $viewdata['success']   =   $this->session->flashdata('res');
      $viewdata['tablelist'] =   $this->Cat_model->join(); 

      $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
    $this->table->set_template($tmpl);

    $this->table->set_heading('Student Name','Father Name','DOB','Gender','Course','Address1','Address2','City','Area','Pincode','Action');

    $this->load->view('student_form',$viewdata);
  }

  function  edit($student_id)
  {
     $field_list            =  array  (
                                'student_id','name','father_name',
                                'dob','gender_id','course_id',
                                'address_line1','address_line2','City_id','Area_id','Pincode','status'
                                      );

    $where                 =  array('student_id' =>  $student_id);
    $viewdata['tabledata'] =  $this->Cat_model->get_data('student_detail',$field_list,$where);
    $viewdata['success']     = $this->session->flashdata('res'); 




    $field_list=array('gender_id','gender_name');
    $genderData=$this->Cat_model->get_data('gender',$field_list,"");
    $cityoption=array();
    foreach ($genderData as $row)
    {
    $cityoption[$row->gender_id]= $row->gender_name;
    }
    $viewdata['genderData']=$cityoption;


    $field_list=array('course_id','course_name');
    $courseData=$this->Cat_model->get_data('coursemaster',$field_list,"");
    $courseoption=array();
    foreach ($courseData as $row)
    {
    $courseoption[$row->course_id]= $row->course_name;
    }
    $viewdata['courseData']=$courseoption;


    $field_list=array('City_id','City_name');
    $cityData=$this->Cat_model->get_data('city',$field_list,"");
    $cityoption=array();
    foreach ($cityData as $row)
    {
    $cityoption[$row->City_id]= $row->City_name;
    }
    $viewdata['cityData']=$cityoption;

    // print_r($viewdata); 
    $viewdata['tablelist'] =  $this->Cat_model->join();       
    // $viewdata['dropdown']  =  $this->Cat_model->get_dropdown();
     $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
    $this->table->set_template($tmpl);

    $this->table->set_heading('Student Name','Father Name','DOB','Gender','Course','Address1','Address2','City','Area','Pincode','Action');

        $viewdata['success']     = $this->session->flashdata('res'); 

    $this->load->view('student_form',$viewdata);
  }

   
 
  function delete($student_id)
  {
    $where                = array('student_id' =>$student_id);
    $result               = $this->Cat_model->delete('student_detail',$where);

    if($result)
    {
    $this->session->set_flashdata('res', 'deleted successfully');
    redirect(base_url("/index.php/student_table"));
    }

    $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
    $this->table->set_template($tmpl);

    $this->table->set_heading('Student Name','Father Name','DOB','Gender','Course','Address1','Address2','City','Area','Pincode','Action');




    $viewdata['success']   =  $this->session->flashdata('res');
    $viewdata['tablelist'] =  $this->Cat_model->get_data('student_detail',$field_list,'');
    $this->load->view('student_form',$viewdata);
  } 

  public function loadarea()
  {
    $City_id    =   $this->input->post("City_id");
    $fieldlist  =   array('Area_id','Area_name');
    $where      =   array('City_id' =>$City_id,);
    $result     =   $this->Cat_model->get_data('area', $fieldlist, $where);
    // print($result);
    $optionarr['areadata']  =   array();
    foreach($result as $row)
    {
    $optionarr[$row->Area_id]=$row->Area_name;
    }

    $extraArr="id='City_id' onchange='loadArea()'";
    echo form_dropdown('City_id',$optionarr,"", $extraArr);
  }

  public function loadpincode()
  {
    $Area_id   =$this->input->post("Area_id");
    $fieldlist = array('Pincode');
    $where     = array('Area_id'=>$Area_id);
    $result    = $this->Cat_model->get_data('area',$fieldlist,$where);       
    foreach ($result as $row)
    {
    echo $row->Pincode;
    }

  }

  function datatable()
  {

    $this->datatables->select( 'a.name,a.father_name,a.dob,b.gender_name,c.course_name,a.address_line1,a.address_line2,d.City_name,e.Area_name,a.Pincode,a.student_id');
       $this->db->from('student_detail as a');
       $this->db->join('gender as b','a.gender_id = b.gender_id');
       $this->db->join('coursemaster as c','a.course_id = c.course_id');
       $this->db->join('city as d','a.City_id = d.City_id');
       $this->db->join('area as e','a.Area_id = e.Area_id');
    $this->datatables->edit_column('a.student_id', '$1', 'get_buttons(a.student_id)');
        echo $this->datatables->generate();
 
  }

 
}

?>