<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * @property Login_control $Login_control
 * @property Aauth $aauth Description
 * @version 1.0
 * 
 */
class Example extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->library("Aauth");
    }

    public function index() {

        if ($this->aauth->login('admin@admin.com', 'password', true))
            echo 'tmm';

        //echo date("Y-m-d H:i:s");
    }

    function debug(){

        echo "<pre>";

        print_r(
        //$this->aauth->is_admin()
            //$this->aauth->get_user()
            //$this->aauth->control_group("Mod")
            //$this->aauth->control_perm(1)
            //$this->aauth->list_groups()
            //$this->aauth->list_users()
            //$this->aauth->is_allowed(1)
            //$this->aauth->is_admin()
            //$this->aauth->create_perm("deneme",'defff')
        //$this->aauth->update_perm(3,'dess','asd')
        //$this->aauth->allow(1,1)
        //$this->aauth->add_member(1,1)
        //$this->aauth->deny(1,1)
        //$this->aauth->mail()
        //$this->aauth->create_user('seass@asds.com','asdasdsdsdasd','asd')
        //$this->aauth->verify_user(11, 'MLUguBbXpd9Eeu5B')
        //$this->aauth->remind_password('seass@asds.com')
        //$this->aauth->reset_password(11,'0ghUM3oIC95p7uMa')
        //$this->aauth->is_allowed(1)
        //$this->aauth->control(1)
        //$this->aauth->send_pm(1,2,'asd')
        //$this->session->flashdata('d')
        //$this->aauth->add_member(1,1)
        //$this->aauth->create_user('asd@asd.co','d')
        //$this->aauth->send_pm(1,2,'asd','sad')
        //$this->aauth->list_pms(1,0,3,1)
        //$this->aauth->get_pm(6, false)
        //$this->aauth->delete_pm(6)
        //$this->aauth->set_as_read_pm(13)
        //$this->aauth->create_group('aa')
         $this->aauth->create_perm('asdda')
         //''

        );

        echo '<br>---- error --- <br>';
        echo $this->aauth->get_errors();

        echo '<br>---- info --- <br>';
        echo $this->aauth->get_infos();

        echo "</pre>";
    }

    function flash(){
        $d['a'] = 'asd';
        $d['3'] = 'asdasd';

        $this->session->set_flashdata('d', $d);

        $d['4'] = 'tttt';

        $this->session->set_flashdata('d', $d);
    }


    function settings() {
        
        //echo $this->aauth->_get_login_attempts(4);
        //echo $this->aauth->get_user_id('emre@emreakay.com');
        //$this->aauth->_increase_login_attempts('emre@emreakay.com');
        //$this->aauth->_reset_login_attempts(1);
    }

    
    public function is_loggedin() {

        if ($this->aauth->is_loggedin())
            echo 'girdin';
    }

    public function logout() {

        $this->aauth->logout();
    }

    public function is_member() {

        if ($this->aauth->is_member('Admin'))
            echo 'uye';
    }

    public function is_admin() {

        if ($this->aauth->is_member('Admin'))
            echo 'adminovic';
    }

    function get_user_groups(){
        //print_r( $this->aauth->get_user_groups());

        foreach($this->aauth->get_user_groups() as $a){

            echo $a->id . " " . $a->name . "<br>";
        }
    }

    public function group() {

        echo $this->aauth->get_group_id("Admin");
    }

    public function list_users() {
        echo '<pre>';
        print_r($this->aauth->list_users("Mod"));
        echo '</pre>';
    }

    public function list_groups() {
        echo '<pre>';
        print_r($this->aauth->list_groups());
        echo '</pre>';
    }

    public function check_email() {

        if ($this->aauth->check_email("emre@emreakay.com"))
            echo 'uygun ';
        else
            echo 'alindi ';

        echo $this->aauth->get_errors();

        echo ' sadsad';
    }

    public function get_user() {
        print_r($this->aauth->get_user(1));
    }

    function create_user() {
        $a = $this->aauth->create_user("ess@as.com", "asd", "asdasd");

        print_r($this->aauth->get_user($a));
    }

    public function is_banned() {
        print_r($this->aauth->is_banned(6));
    }

    function ban_user() {

        $a = $this->aauth->ban_user(6);

        print_r($a);
    }

    function update_user() {
        $a = $this->aauth->update_user(3, "xxx@ssdas.com", "asd", "asdasd");

        print_r($a);
    }

    function create_group() {

        $a = $this->aauth->create_group("denemeee");
    }

    function delete_group() {

        $a = $this->aauth->delete_group(3);
    }

    function update_group() {

        $a = $this->aauth->update_group(4, "zxxx");
    }

    function add_member() {

        $a = $this->aauth->add_member(1, 4);
    }

    function fire_member() {

        $a = $this->aauth->fire_member(1, 4);
    }
    
    

}

/* End of file welcome.php */
