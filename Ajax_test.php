<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_test extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cat_model');
    }

    function index()
    {
        $field_list=array('City_id','City_name');
        $cityData=$this->Cat_model->get_data('city',$field_list,"");
        $Cityoption=array();
        foreach ($cityData as $row)
        {
            $cityoption[$row->City_id]= $row->City_name;
        }
        $res['cityData']=$cityoption;
        $this->load->view('ajax_test_form',$res);     
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
}
?>