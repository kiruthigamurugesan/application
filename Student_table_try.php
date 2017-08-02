<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_table_try extends CI_Controller
{
  function __construct()
  {

  parent::__construct();
  $this->load->model('Cat_model');

  }
   function list()
  {
    


	$tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
			$this->table->set_template($tmpl);

    $this->table->set_heading('Student Id');

    $this->load->view('Student_form_try');
  }
  function datatable1()
  {

    $this->datatables->select('student_id')
     			->from('student_detail');
   // $this->datatables->edit_column('student_id', '$1', 'get_buttons(student_id)');
        echo $this->datatables->generate();
 
  }
}