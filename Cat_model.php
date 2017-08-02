<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_model extends CI_Model 
{
    function __construct()
    {
        parent:: __construct();
        
    
    }

    public function insert($table,$tabledata)
    {
        $result =   $this->db->insert($table,$tabledata);
        return $result;
    }

    /*public function get_dropdown()
        {
            $result = $this->db->select('*')->get('coursemaster')->result_array();

            $dropdown = array();
                foreach($result as $r)
                {
                    $dropdown[$r['course_id']] = $r['course_name'];
                }
            return $dropdown;
        }
*/
   

    
    public function join()
    {
       $this->db->select('
                         a.*,b.gender_name,c.course_name,d.City_name,e.Area_name,a.Pincode');
       $this->db->from('student_detail as a');
       $this->db->join('gender as b','a.gender_id = b.gender_id');
       $this->db->join('coursemaster as c','a.course_id = c.course_id');
       $this->db->join('city as d','a.City_id = d.City_id');
       $this->db->join('area as e','a.Area_id = e.Area_id');
       $result = $this->db->get()->result();
       return $result;

    }
 

    public function get_data($table,$field_list,$where)
  {
    $this->db->select($field_list);
    $this->db->from($table);

    if(!empty($where))
    {
      $this->db->where($where);
    }
    $query  = $this->db->get();
    return $query->result();
  } 
    public function update($table,$field_list,$where)
        {
            $this->db->where($where);
            $data=$this->db->update($table,$field_list);
            return $data;
        }
    public function delete($table,$where)
        {
            $this->db->where($where);
            $value=$this->db->delete($table);
            return $value;
        }
    public function show($table,$field_list,$where)
    {
        $this->db->select($field_list);
        $this->db->From($table);
        if(!empty($where))
            {
                $this->db->where($where);
            }
        $result = $this->db->get()->result_array();
        return $result;
    }   
        

        
}
?>