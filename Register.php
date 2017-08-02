<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller 
{
	function __construct()
	{
	parent:: __construct();
	$this->load->model('Common_model');
	}

	/*public function check_password()
	{
		$password = 
		if( $password == $confirmpassword)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('check_password',"password mismatch");
		}
	}*/

	/*public function date($dob)
	{
		if (preg_match("/$[0-31]{2}\/[0-12]{2}\/[0-9]{4}$/", $dob))
		{
			return true;
		}
		else
		{
			this->form_validation->set_message('date',"enter dob");
		}
	}*/

	 public function list()
        { 

			//set table id in table open tag
			$tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
			$this->table->set_template($tmpl);

			$this->table->set_heading('firstName', 'lastName', 'gender','mobno','dob','email','Status','Actions');

			$this->load->view('listform');



         	//$this->data['table']=$this->Common_model->getdata();


         	//$this->load->view('Datatable',$this->data);

        }

		function datatable()
	    {
	        $this->datatables->select('firstname, lastname, gender,mobno, dob,email,status,uid')
	            ->from('form');
	 	    
	 	   // $this->datatables->unset_column('s_no');
			$this->datatables->edit_column('uid', '$1', 'get_buttons(uid)');
	        echo $this->datatables->generate();
	    }
	    public function edit($id)
	    {
	    	//echo $id;
	    	$field_list = array ('firstname','lastname','gender','mobno','dob','email','password');
	    	$where      = array ('uid' => $id);
	    	$table = 'form';
	    	$value['user'] = $this->Common_model->get_data($field_list,$where,$table);
	    	
	    	print_r($value);
	    	$this->load->view('Form',$value);
	    	
	    }


	public function index()
	{
		
		if(isset($_POST['submit']))
		{
			$this->form_validation->set_rules('firstname','firstname','required');
			$this->form_validation->set_rules('lastname','lastname','required');
			$this->form_validation->set_rules('mobno','mobno','required');
			$this->form_validation->set_rules('gender','gender','required');
			$this->form_validation->set_rules('dob','dob','required');
			$this->form_validation->set_rules('email','email','required|valid_email');
			$this->form_validation->set_rules('password','password','required');
			$this->form_validation->set_rules('confirm_password','confirmpassword','required|matches[password]');

			if( $this->form_validation->run() == TRUE)
			{
				if($this->input->post('uid') == "")
				{
					$result = $this->Common_model->insert($data);
				$data = array (
								'firstname'       => $this->input->post('firstname'),
								'lastname'        => $this->input->post('lastname'),
								'gender'          => $this->input->post('gender'),
								'dob'             => date('Y-m-d',strtotime($this->input->post('dob'))),
								'email'           => $this->input->post('email'),
								'password'        => $this->input->post('password'),
									  );

				}
				else
				{
					$this->Common_model->update($field_list,$where,'form');

					$field_list  = array (  'firstname' => $firstname,
						                    'lastname'  => $lastname,
						                    'gender'    => $gender,
						                    'dob'       => $dob,
						                    'email'     => $email,
						                    'password'  => $password);

					$where      = array ('uid' => $this->input->post('uid'));
					$data = $this->Common_model->update($field_list,$where,$table);
	    			print_r($data);

				}	
				$result = $this->Common_model->insert($data);
				if($result)
				{
					$this->session->set_flashdata('res'," saved successfully");
					redirect(base_url('Register/'));
				}
			}
		}
			
			$msg['success'] = $this->session->flashdata('res');
			$this->load->view('Form',$msg);
	}
			
}		
	

