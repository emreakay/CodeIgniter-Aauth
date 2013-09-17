<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * 
 * 
 */
class Misal extends CI_Controller {
    //put your code here
    
    public function index() {
        
        $this->load->model("Modelamca");
        echo $this->Modelamca->al();
        
        
        
        
        
        echo 'ea';
    }
    
}

/* End of file welcome.php */
