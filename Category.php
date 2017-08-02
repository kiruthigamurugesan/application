<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller 
{
	function __construct()
	{
	parent:: __construct();
	$this->load->model('Cat_model');
	}

	public function edit($cat_id)
    {
    	//echo $id;
    	$field_list  = array ('cat_id','cat_name','status');
    	$where       = array ('cat_id' => $cat_id);
    	$table = 'category';
    	$viewdata['tabledata'] = $this->Cat_model->get_data($field_list,$where,$table);
    	
		$field_list  = array ('cat_id','cat_name','status');
		$where       = array ('');
		$table = 'category';
		$viewdata['tablelist'] = $this->Cat_model->get_data($field_list,$where,$table);

    	$this->load->view('Cat_form',$viewdata);
    	
    }

	 public function list()
        { 

			//set table id in table open tag
			$tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
			$this->table->set_template($tmpl);

			$this->table->set_heading('cat_id','cat_name','status');

			$this->load->view('Cat_form');
		}

		function datatable()
	    {
	        $this->datatables->select('cat_id,cat_name,status')
	            ->from('category');
	 	    
	 	   // $this->datatables->unset_column('s_no');
			$this->datatables->edit_column('status', '$1', 'get_buttons(status)');
	        echo $this->datatables->generate();
	    }

	    function delete($cat_id)
	    {
	    		$where       = array ('cat_id' => $cat_id);
	            $value     = 	$this->Cat_model->delete('category',$where);
	            if($value)
									{
										$this->session->set_flashdata('res'," saved successfully");
										redirect(base_url('index.php/Category/'));
									}
	 	    
	    }


	function index()
	{
		if(!empty ($_POST))
		{
			$this->form_validation->set_rules('cat_name','catname','required');

				if( $this->form_validation->run() == TRUE)

					{

						$tabledata = array ('cat_name' => $this->input->post('cat_name'));
						if($this->input->post('cat_id') == "")
							{
								$result = $this->Cat_model->insert($tabledata);

								if($result)
									{
										$this->session->set_flashdata('res'," saved successfully");
										redirect(base_url('index.php/Category/'));
									}				
							}
						else
							{
						    	$field_list  = array ('cat_name' => $this->input->post('cat_name'));
						    	$where       = array ('cat_id' => $this->input->post('cat_id'));
								$result      = 	$this->Cat_model->update($field_list,$where,'category');

								if($result)
									{
										$this->session->set_flashdata('res'," saved successfully");
										redirect(base_url('index.php/Category/'));
									}

								$field_list  = array (  'cat_name' => $cat_name);
								$where       = array ('cat_id' => $this->input->post('cat_id'));
								$tabledata   = $this->Cat_model->update($field_list,$where,$table);
							}
					}

		}

		$field_list  = array ('cat_id','cat_name','status');
		$where       = array ('');
		$table       = 'category';
		$viewdata['tablelist'] = $this->Cat_model->get_data($field_list,$where,$table);
	    	
		$viewdata['success']        = $this->session->flashdata('res');
		$this->load->view('Cat_form',$viewdata);
	}

}
?>