<?php

/**
 * @property Modelamca $Modelamca
 * 
 */

class Ajax_model extends CI_Model{
    //put your code here
   
    function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }
    
    
    public function get_servers($all = FALSE){
        
        if(all==FALSE){
            $q = $this->db->where('user_id', $this->CI->session->userdata('id')); 
        }        
        
        $q = $this->db->get('servers_to_users');
        
        if ($q->num_rows() > 0){
            return $q->result();
        }  else {
            return FALSE;
        }
        
    }
        
        
        

    
}

?>
