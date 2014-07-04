<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * @property Login_control $Login_control
 * @property Aauth $aauth Description
 * @version 1.0
 */
class Example extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->library("Aauth");
    }

    public function index() {

        if ($this->aauth->login('aa@a.com', '12345'))
            echo 'tmm';
        else
            echo 'hyr';
        //echo date("Y-m-d H:i:s");

        $this->aauth->print_errors();
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

    public function login_fast(){
        $this->aauth->login_fast(1);
    }
    
    public function is_loggedin() {

        if ($this->aauth->is_loggedin())
            echo 'girdin';

        print_r( $this->aauth->get_user() );
    }

    public function logout() {

        $this->aauth->logout();
    }

    public function is_member() {

        if ($this->aauth->is_member('deneme',9))
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

    public function get_group_name() {

        echo $this->aauth->get_group_name(1);
    }

    public function get_group_id() {

        echo $this->aauth->get_group_id("Admin");
    }

    public function list_users() {
        echo '<pre>';
        print_r($this->aauth->list_users());
        echo '</pre>';
    }

    public function list_groups() {
        echo '<pre>';
        print_r($this->aauth->list_groups());
        echo '</pre>';
    }

    public function check_email() {

        if ($this->aauth->check_email("aa@a.com"))
            echo 'uygun ';
        else
            echo 'alindi ';

        $this->aauth->print_errors();
    }

    public function get_user() {
        print_r($this->aauth->get_user());
    }

    function create_user() {

        $a = $this->aauth->create_user("admin@admin.com", "12345", "Admin");

        if ($a)
            echo "tmm   ";
        else
            echo "hyr  ";


        print_r($this->aauth->get_user($a));

        $this->aauth->print_errors();
    }

    public function is_banned() {
        print_r($this->aauth->is_banned(6));
    }

    function ban_user() {

        $a = $this->aauth->ban_user(6);

        print_r($a);
    }

    function delete_user() {

        $a = $this->aauth->delete_user(7);

        print_r($a);
    }

    function unban_user() {

        $a = $this->aauth->unban_user(6);

        print_r($a);
    }

    function update_user() {
        $a = $this->aauth->update_user(6, "a@a.com", "12345", "tested");

        print_r($a);
    }

    function update_activity() {
        $a = $this->aauth->update_activity();

        print_r($a);
    }

    function update_login_attempt() {
        $a = $this->aauth->update_login_attempts("a@a.com");

        print_r($a);
    }

    function create_group() {

        $a = $this->aauth->create_group("deneme");
    }

    function delete_group() {

        $a = $this->aauth->delete_group("deneme");
    }

    function update_group() {

        $a = $this->aauth->update_group("deneme", "zxxx");
    }

    function add_member() {

        $a = $this->aauth->add_member(8, "deneme");
    }

    function fire_member() {

        $a = $this->aauth->fire_member(8, "deneme");
    }


    function create_perm() {

        $a = $this->aauth->create_perm("deneme","def");
    }


    function update_perm() {

        $a = $this->aauth->update_perm("deneme","deneme","xxx");
    }

    function delete_perm() {

        $a = $this->aauth->update_perm("deneme","deneme","xxx");
    }

    function allow_user() {

        $a = $this->aauth->allow_user(9,"deneme");
    }


    function deny_user() {

        $a = $this->aauth->deny_user(9,"deneme");
    }

    function allow_group() {

        $a = $this->aauth->allow_group("deneme","deneme");
    }

    function deny_group() {

        $a = $this->aauth->deny_group("deneme","deneme");
    }

    function list_perms() {

        $a = $this->aauth->list_perms();
        print_r($a);
    }

    function get_perm_id() {

        $a = $this->aauth->get_perm_id("deneme");
        print_r($a);
    }


    function send_pm() {

        $a = $this->aauth->send_pm(1,8,'s',"w");
        $this->aauth->print_errors();
    }

    function list_pms(){

        print_r( $this->aauth->list_pms() );
    }

    function get_pm(){

        print_r( $this->aauth->get_pm(39,false));
    }

    function delete_pm(){

        $this->aauth->delete_pm(41);
    }


    function count_unread_pms(){

        echo $this->aauth->count_unread_pms(8);
    }

    function error(){

        $this->aauth->error("asd");
        $this->aauth->error("xasd");
        $this->aauth->keep_errors();
        $this->aauth->print_errors();

    }

    function keep_errors(){

        $this->aauth->print_errors();
        //$this->aauth->keep_errors();
    }

    function set_user_var(){
        $this->aauth->set_user_var("emre","akasy");
    }

    function unset_user_var(){
        $this->aauth->unset_user_var("emre");
    }

    function get_user_var(){
        echo $this->aauth->get_user_var("emre");
    }

    function set_system_var(){
        $this->aauth->set_system_var("emre","akay");
    }

    function unset_system_var(){
        $this->aauth->unset_system_var("emre");
    }

    function get_system_var(){
        echo $this->aauth->get_system_var("emre");
    }

}//end

/* End of file welcome.php */
