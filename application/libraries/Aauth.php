<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Aauth
 *
 * @author Emre Akay
 *
 *
 */


//last activity check email
class Aauth {

    public $CI;
    public $config_vars;
    public $errors = array();
    public $infos = array();

    public function __construct() {

        // delete all errors at first :)
        $this->errors = array();

        $this->CI = & get_instance();

        // dependancies
        $this->CI->load->library('session');
        $this->CI->load->library('email');
        $this->CI->load->database();
        $this->CI->load->helper('url');
        $this->CI->load->helper('string');
        $this->CI->load->helper('email');


        // config/aauth.php
        $this->CI->config->load('aauth');

        // the array which came from aauth config file
        // $this->config_vars
        $this->config_vars = & $this->CI->config->item('aauth');
    }


    // open sessions
    public function login($email, $pass, $remember = FALSE) {

        // remove cookies first
        setcookie("user", "", time()-3600, '/');

        if( !valid_email($email) or !ctype_alnum($pass) or strlen($pass) < 5 or strlen($pass) > $this->config_vars['max'] ) {
            $this->error($this->config_vars['wrong']);
            return false;}

        $query = $this->CI->db->where('email', $email);
        $query = $this->CI->db->get($this->config_vars['users']);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            if ( $this->config_vars['dos_protection'] and $row->last_login_attempt != '' and (strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($row->last_login_attempt) ) {
                $this->error($this->config_vars['exceeded']);
                return false;
            }
        }

        $query = null;
        $query = $this->CI->db->where('email', $email);

        // database stores pasword md5 cripted
        $query = $this->CI->db->where('pass', md5($pass));
        $query = $this->CI->db->where('banned', 0);
        $query = $this->CI->db->get($this->config_vars['users']);

        $row = $query->row();

        if ($query->num_rows() > 0) {

            // if email and pass matches
            // create session
            $data = array(
                'id' => $row->id,
                'name' => $row->name,
                'email' => $row->email,
                'loggedin' => TRUE
            );

            $this->CI->session->set_userdata($data);

            // id remember selected
            if ($remember){
                $expire = $this->config_vars['remember'];
                $today = date("Y-m-d");
                $remember_date = date("Y-m-d", strtotime($today . $expire) );
                $random_string = random_string('alnum', 16);
                $this->update_remember($row->id, $random_string, $remember_date );

                setcookie( 'user', $row->id . "-" . $random_string, time() + 99*999*999, '/');
            }

            // update last login
            $this->update_last_login($row->id);
            $this->update_activity();

            return TRUE;

        } else {

            $query = $this->CI->db->where('email', $email);
            $query = $this->CI->db->get($this->config_vars['users']);
            $row = $query->row();

            if ($query->num_rows() > 0) {

                if ( $row->last_login_attempt == null or  (strtotime("now") - 600) > strtotime($row->last_login_attempt) )
                {
                    $data = array(
                        'last_login_attempt' =>  date("Y-m-d H:i:s")
                    );

                } else if (!($row->last_login_attempt != '' and (strtotime("now") + 30 * $this->config_vars['try'] ) < strtotime($row->last_login_attempt))) {

                    $newtimestamp = strtotime("$row->last_login_attempt + 30 seconds");
                    $data = array(
                        'last_login_attempt' =>  date( 'Y-m-d H:i:s', $newtimestamp )
                    );
                }

                $query = $this->CI->db->where('email', $email);
                $this->CI->db->update($this->config_vars['users'], $data);
            }

            $this->error($this->config_vars['wrong']);
            return FALSE;
        }
    }

    // checks if user logged in
    // also checks remember
    public function is_loggedin() {

        if($this->CI->session->userdata('loggedin'))
        {return true;}

        else{
            if( !array_key_exists('user', $_COOKIE) ){
                return false;
            }else{
                $cookie = explode('-', $_COOKIE['user']);
                if(!is_numeric( $cookie[0] ) or strlen($cookie[1]) < 13 ){return false;}
                else{
                    $query = $this->CI->db->where('id', $cookie[0]);
                    $query = $this->CI->db->where('remember_exp', $cookie[1]);
                    $query = $this->CI->db->get($this->config_vars['users']);

                    $row = $query->row();

                    if ($query->num_rows() < 1) {
                        $this->update_remember($cookie[0]);
                        return false;
                    }else{

                        if(strtotime($row->remember_time) > strtotime("now") ){
                            $this->login_fast($cookie[0]);
                            return true;
                        }
                        // if time is expired
                        else {
                            return false;
                        }
                    }
                }

            }
        }
        return false;
    }

    // most important function. it controls if a logged or public user has permiision
    // if no permission, it stops script
    // it also updates last activity every time function called
    // if perm_par is not given just control user logged in or not
    public function control($perm_par = false){

        if(!$perm_par and !$this->is_loggedin()){
            echo $this->config_vars['no_access'];
            die();
        }

        $perm_id = $this->get_perm_id($perm_par);
        $this->update_activity();

        if( !$this->is_allowed($perm_id) ) {
            echo $this->config_vars['no_access'];
            die();
        }

    }

    // do logout
    public function logout() {

        return $this->CI->session->sess_destroy();
    }

    // return users as an object array
    public function list_users($group_par = FALSE, $limit = FALSE, $offset = FALSE, $include_banneds = FALSE) {

        // if group_par is given
        if ($group_par != FALSE) {

            $group_par = $this->get_group_id($group_par);
            $this->CI->db->select('*')
                ->from($this->config_vars['users'])
                ->join($this->config_vars['user_to_group'], $this->config_vars['users'] . ".id = " . $this->config_vars['user_to_group'] . ".user_id")
                ->where($this->config_vars['user_to_group'] . ".group_id", $group_par);

            // if group_par is not given, lists all users
        } else {

            $this->CI->db->select('*')
                ->from($this->config_vars['users']);
        }

        // banneds
        if (!$include_banneds) {
            $this->CI->db->where('banned != ', 1);
        }


        // limit
        if ($limit) {

            if ($offset == FALSE)
                $this->CI->db->limit($limit);
            else
                $this->CI->db->limit($limit, $offset);
        }


        $query = $this->CI->db->get();

        return $query->result();
    }

    //do login with id
    public function login_fast($user_id){
        $query = $this->CI->db->where('id', $user_id);
        $query = $this->CI->db->where('banned', 0);
        $query = $this->CI->db->get($this->config_vars['users']);

        $row = $query->row();

        if ($query->num_rows() > 0) {

            // if id matches
            // create session
            $data = array(
                'id' => $row->id,
                'name' => $row->name,
                'email' => $row->email,
                'loggedin' => TRUE
            );

            $this->CI->session->set_userdata($data);
        }
    }

    // creates user and returns its id
    public function create_user($email, $pass, $name='') {

        $valid = true;

        if (!$this->check_email($email)) {
            $this->error($this->config_vars['email_taken']);
            $valid = false;
        }
        if (!valid_email($email)){
            $this->error($this->config_vars['email_invalid']);
            $valid = false;
        }
        if (strlen($pass) < 5 or strlen($pass) > $this->config_vars['max'] ){
            $this->error($this->config_vars['pass_invalid']);
            $valid = false;
        }
        if ($name !='' and !ctype_alnum($name)){
            $this->error($this->config_vars['name_invalid']);
            $valid = false;
        }

        if (!$valid) { return false; }

        $data = array(
            'email' => $email,
            'pass' => md5($pass),
            'name' => $name,
            //'banned' => 1
        );

        if ( $this->CI->db->insert($this->config_vars['users'], $data )){

            $user_id = $this->CI->db->insert_id();

            // set default group
            $this->add_member($user_id, $this->config_vars['default_group']);

            if($this->config_vars['verification']){
                $data = null;
                $data['banned'] = 1;

                $this->CI->db->where('id', $user_id);
                $this->CI->db->update($this->config_vars['users'], $data);
                $this->send_verification($user_id);
            }

            return $user_id;

        } else {
            return FALSE;
        }
    }

    // takes the user id and updates the values given
    public function update_user($user_id, $email = FALSE, $pass = FALSE, $name = FALSE) {

        $data = array();

        if ($email != FALSE) {
            $data['email'] = $email;
        }

        if ($pass != FALSE) {
            $data['pass'] = md5($pass);
        }

        if ($name != FALSE) {
            $data['name'] = $name;
        }

        $this->CI->db->where('id', $user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // send vertifition mail
    public function send_verification($user_id){

        $query = $this->CI->db->where( 'id', $user_id );
        $query = $this->CI->db->get( $this->config_vars['users'] );

        if ($query->num_rows() > 0){
            $row = $query->row();

            $ver_code = random_string('alnum', 16);

            $data['verification_code'] = $ver_code;

            $this->CI->db->where('id', $user_id);
            $this->CI->db->update($this->config_vars['users'], $data);

            $this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
            $this->CI->email->to($row->email);
            $this->CI->email->subject($this->config_vars['email']);
            $this->CI->email->message($this->config_vars['code'] . $ver_code .
            $this->config_vars['link'] . $user_id . '/' . $ver_code );
            $this->CI->email->send();
        }
        //echo $this->CI->email->print_debugger();
    }

    // activare user
    public function verify_user($user_id, $ver_code){

        $query = $this->CI->db->where('id', $user_id);
        $query = $this->CI->db->where('verification_code', $ver_code);
        $query = $this->CI->db->get( $this->config_vars['users'] );

        if( $query->num_rows() >0 ){

            $data =  array(
                'verification_code' => '',
                'banned' => 0
            );

            $this->CI->db->where('id', $user_id);
            $this->CI->db->update($this->config_vars['users'] , $data);
            return true;
        }
        return false;
    }

    // resets attempts
    public  function reset_login_attempts($user_id) {

        $data['last_login_attempts'] = null;
        $this->CI->db->where('id', $user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // bans user
    public function ban_user($user_id) {

        $data = array(
            'banned' => 1
        );

        $this->CI->db->where('id', $user_id);

        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // cancels the ban
    public function unlock_user($user_id) {

        $data = array(
            'banned' => 0
        );

        $this->CI->db->where('id', $user_id);

        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // check if user banned, return false if banned or not found user
    public function is_banned($user_id) {

        $query = $this->CI->db->where('id', $user_id);
        $query = $this->CI->db->where('banned', 1);

        $query = $this->CI->db->get($this->config_vars['users']);

        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function delete_user($user_id) {

        $this->CI->db->where('id', $user_id);
        $this->CI->db->delete($this->config_vars['users']);
    }

    // if email is available, returns true
    public function check_email($email) {

        $this->CI->db->where("email", $email);
        $query = $this->CI->db->get($this->config_vars['users']);

        if ($query->num_rows() > 0) {
            $this->info($this->config_vars['email_taken']);
            return FALSE;
        }
        else
            return TRUE;
    }

    public function remind_password($email){

        $query = $this->CI->db->where( 'email', $email );
        $query = $this->CI->db->get( $this->config_vars['users'] );

        if ($query->num_rows() > 0){
            $row = $query->row();

            $ver_code = random_string('alnum', 16);

            $data['verification_code'] = $ver_code;

            $this->CI->db->where('email', $email);
            $this->CI->db->update($this->config_vars['users'], $data);

            $this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
            $this->CI->email->to($row->email);
            $this->CI->email->subject($this->config_vars['reset']);
            $this->CI->email->message($this->config_vars['remind'] . ' ' .
            $this->config_vars['remind'] . $row->id . '/' . $ver_code );
            $this->CI->email->send();
        }

        //echo $this->CI->email->print_debugger();
    }

    public function reset_password($user_id, $ver_code){

        $query = $this->CI->db->where('id', $user_id);
        $query = $this->CI->db->where('verification_code', $ver_code);
        $query = $this->CI->db->get( $this->config_vars['users'] );

        $pass = random_string('alphanum',8);

        if( $query->num_rows() > 0 ){

            $data =  array(
                'verification_code' => '',
                'pass' => md5($pass)
            );

            $row = $query->row();
            $email = $row->email;

            $this->CI->db->where('id', $user_id);
            $this->CI->db->update($this->config_vars['users'] , $data);

            $this->CI->email->from( $this->config_vars['email'], $this->config_vars['name']);
            $this->CI->email->to($email);
            $this->CI->email->subject($this->config_vars['reset']);
            $this->CI->email->message($this->config_vars['new_password'] . $pass);
            $this->CI->email->send();

            return true;
        }

        //echo $this->CI->email->print_debugger();
        return false;
    }

    // updates user's last activity date
    public function update_activity($user_id = FALSE) {

        if ($user_id == FALSE)
            $user_id = $this->CI->session->userdata('id');

        if($user_id==false){return false;}

        $data['last_activity'] = date("Y-m-d H:i:s");

        $query = $this->CI->db->where('id',$user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // updates last login date and time
    public function update_last_login($user_id = FALSE) {

        if ($user_id == FALSE)
            $user_id = $this->CI->session->userdata('id');

        $data['last_login'] = date("Y-m-d H:i:s");

        $this->CI->db->where('id', $user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }

    // updates remember time
    public function update_remember($user_id, $expression=null, $expire=null) {

        $data['remember_time'] = $expire;
        $data['remember_exp'] = $expression;

        $query = $this->CI->db->where('id',$user_id);
        return $this->CI->db->update($this->config_vars['users'], $data);
    }


    // get user information as an array
    // you can use sessions
    public function get_user($user_id = FALSE) {

        if ($user_id == FALSE)
            $user_id = $this->CI->session->userdata('id');

        $query = $this->CI->db->where('id', $user_id);
        $query = $this->CI->db->get($this->config_vars['users']);

        if ($query->num_rows() <= 0){
            $this->error($this->config_vars['no_user']);
            return FALSE;
        }
        return $query->row();
    }

    public function get_user_id($email=false) {

        if(!$email){
            $query = $this->CI->db->where('id', $this->CI->session->userdata('id'));
        } else {
            $query = $this->CI->db->where('email', $email);
        }

        $query = $this->CI->db->get($this->config_vars['users']);

        if ($query->num_rows() <= 0){
            $this->error($this->config_vars['no_user']);
            return FALSE;
        }
        return $query->row()->id;
    }

    public function get_user_groups($user_id = false){

        if ($user_id==false) { $user_id = $this->CI->session->userdata('id'); }

        $this->CI->db->select('*');
        $this->CI->db->from($this->config_vars['user_to_group']);
        $this->CI->db->join($this->config_vars['groups'], "id = group_id");
        $this->CI->db->where('user_id', $user_id);

        return $query = $this->CI->db->get()->result();
    }

    // creates a group and returns new group id
    public function create_group($group_name) {

        $query = $this->CI->db->get_where($this->config_vars['groups'], array('name' => $group_name));

        if ($query->num_rows() < 1) {

            $data = array(
                'name' => $group_name
            );
            $this->CI->db->insert($this->config_vars['groups'], $data);
            return $this->CI->db->insert_id();
        }

        $this->error($this->config_vars['group_exist']);
        return FALSE;
    }

    public function update_group($group_id, $group_name) {

        $data['name'] = $group_name;

        $this->CI->db->where('id', $group_id);
        return $this->CI->db->update($this->config_vars['groups'], $data);
    }

    public function delete_group($group_id) {

        $this->CI->db->where('id', $group_id);
        return $this->CI->db->delete($this->config_vars['groups']);
    }

    public function add_member($user_id, $group_par) {

        $group_par = $this->get_group_id($group_par);

        $query = $this->CI->db->where('user_id',$user_id);
        $query = $this->CI->db->where('group_id',$group_par);
        $query = $this->CI->db->get($this->config_vars['user_to_group']);

        if ($query->num_rows() < 1) {
            $data = array(
                'user_id' => $user_id,
                'group_id' => $group_par
            );

            return $this->CI->db->insert($this->config_vars['user_to_group'], $data);
        }
        $this->info($this->config_vars['already_member']);
        return true;
    }

    // fire the member from the given group
    public function fire_member($user_id, $group_par) {

        $group_par = $this->get_group_id($group_par);
        $this->CI->db->where('user_id', $user_id);
        $this->CI->db->where('group_id', $group_par);
        return $this->CI->db->delete($this->config_vars['user_to_group']);
    }

    // group_name or group_id
    public function is_member($group_par) {

        $user_id = $this->CI->session->userdata('id');

        $this->get_group_id($group_par);
        // group_id given
        if (is_numeric($group_par)) {

            $query = $this->CI->db->where('user_id', $user_id);
            $query = $this->CI->db->where('group_id', $group_par);
            $query = $this->CI->db->get($this->config_vars['user_to_group']);

            $row = $query->row();

            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        // group_name given
        else {

            $query = $this->CI->db->where('name', $group_par);
            $query = $this->CI->db->get($this->config_vars['groups']);

            if ($query->num_rows() == 0)
                return FALSE;

            $row = $query->row();
            return $this->is_member($row->id);
        }
    }

    public function is_admin() {
        return $this->is_member($this->config_vars['admin_group']);
    }

    // returns groups as an object array
    public function list_groups() {

        $query = $this->CI->db->get($this->config_vars['groups']);
        return $query->result();
    }

    public function get_group_name($group_id) {

        $query = $this->CI->db->where('id', $group_id);
        $query = $this->CI->db->get($this->config_vars['groups']);

        if ($query->num_rows() == 0)
            return FALSE;

        $row = $query->row();
        return $row->name;
    }

    // takes group paramater (id or name) and returns group id.
    public function get_group_id($group_par) {

        if( is_numeric($group_par) ) { return $group_par; }

        $query = $this->CI->db->where('name', $group_par);
        $query = $this->CI->db->get($this->config_vars['groups']);

        if ($query->num_rows() == 0)
            return FALSE;

        $row = $query->row();
        return $row->id;
    }

    // creates new permission rule. and returns its id
    public function create_perm($perm_name, $definition='') {

        $query = $this->CI->db->get_where($this->config_vars['perms'], array('name' => $perm_name));

        if ($query->num_rows() < 1) {

            $data = array(
                'name' => $perm_name,
                'definition'=> $definition
            );
            $this->CI->db->insert($this->config_vars['perms'], $data);
            return $this->CI->db->insert_id();
        }
        $this->error($this->config_vars['already_perm']);
        return FALSE;
    }

    // updates permissions name and definiton
    public function update_perm($perm_id, $perm_name, $definition=false) {

        $data['name'] = $perm_name;

        if ($definition!=false)
            $data['definition'] = $perm_name;

        $this->CI->db->where('id', $perm_id);
        return $this->CI->db->update($this->config_vars['perms'], $data);
    }

    // remove a permision rule
    public function delete_perm($perm_id) {

        $this->CI->db->where('id', $perm_id);
        return $this->CI->db->delete($this->config_vars['perms']);
    }

    // checks if a group has permitions for given permition
    // if group paramater is empty function checks all groups of current user
    // admin authorized for anything
    public function is_allowed($group_par=false, $perm_par){

        $perm_id = $this->get_perm_id($perm_par);

        if($group_par != false){

            $group_par = $this->get_group_id($group_par);

            $query = $this->CI->db->where('perm_id', $perm_id);
            $query = $this->CI->db->where('group_id', $group_par);
            $query = $this->CI->db->get( $this->config_vars['perm_to_group'] );

            if( $query->num_rows() > 0){
                return true;
            } else {
                return false;
            }
        }
        else {
            // all doors open to admin :)
            if ( $this->is_admin( $this->CI->session->userdata('id')) ) {return true;}

            // if public is allowed
            if( !$this->is_loggedin() and $this->is_allowed($perm_id, $this->config_vars['public_group']) ){
                return true;
            }

            if (!$this->is_loggedin()){return false;}

            $group_pars = $this->list_groups( $this->CI->session->userdata('id') );

            foreach ($group_pars as $g ){
                if($this->is_allowed($perm_id, $g -> id)){
                    return true;
                }
            }


            return false;
        }

    }

    // adds a group to permission table
    public function allow($group_par, $perm_par) {

        $perm_id = $this->get_perm_id($perm_par);

        $query = $this->CI->db->where('group_id',$group_par);
        $query = $this->CI->db->where('perm_id',$perm_id);
        $query = $this->CI->db->get($this->config_vars['perm_to_group']);

        if ($query->num_rows() < 1) {

            $group_par = $this->get_group_id($group_par);
            $data = array(
                'group_id' => $group_par,
                'perm_id' => $perm_id
            );

            return $this->CI->db->insert($this->config_vars['perm_to_group'], $data);
        }
        return true;
    }

    // deny or disallow a group for spesific permition
    // a group which not allowed is already denied.
    public function deny($group_par, $perm_par) {

        $perm_id = $this->get_perm_id($perm_par);

        $group_par = $this->get_group_id($group_par);
        $this->CI->db->where('group_id', $group_par);
        $this->CI->db->where('perm_id', $perm_id);

        return $this->CI->db->delete($this->config_vars['perm_to_group']);
    }

    public function list_perms() {

        $query = $this->CI->db->get($this->config_vars['perms']);
        return $query->result();
    }

    public function get_perm_id($perm_par) {

        if( is_numeric($perm_par) ) { return $perm_par; }

        $query = $this->CI->db->where('name', $perm_par);
        $query = $this->CI->db->get($this->config_vars['perms']);

        if ($query->num_rows() == 0)
            return false;

        $row = $query->row();
        return $row->id;
    }

    // sends private messages
    public function send_pm( $sender_id, $receiver_id, $title, $message ){

        if ( !is_numeric($receiver_id) or $sender_id == $receiver_id ){
            $this->error($this->config_vars['self_pm']);
            return false;
        }

        $query = $this->CI->db->where('id', $receiver_id);
        $query = $this->CI->db->where('banned', 0);

        $query = $this->CI->db->get( $this->config_vars['users'] );

        // if user not exist or banned
        if ( $query->num_rows() < 1 ){
            $this->error($this->config_vars['no_user']);
            return false;
        }

        $data = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'title' => $title,
            'message' => $message,
            'date' => date('Y-m-d H:i:s')
        );

        return $query = $this->CI->db->insert( $this->config_vars['pms'], $data );
    }

    // returns an object consist of list of pms
    // if receiver id not given it retruns current user's pms
    // if sender_id given, it returns only pms from given sender
    public function list_pms($limit=5, $offset=0, $receiver_id = false, $sender_id=false){

        $query='';

        if ( $receiver_id != false){
            $query = $this->CI->db->where('receiver_id', $receiver_id);
        }

        if( $sender_id != false ){
            $query = $this->CI->db->where('sender_id', $sender_id);
        }

        $query = $this->CI->db->order_by('id','DESC');
        $query = $this->CI->db->get( $this->config_vars['pms'], $limit, $offset);
        return $query->result();

    }

    // gets pm and sets as read unless $set_as_read is false
    public function get_pm($pm_id, $set_as_read = true){

        if ($set_as_read) $this->set_as_read_pm($pm_id);

        $query = $this->CI->db->where('id', $pm_id);
        $query = $this->CI->db->get( $this->config_vars['pms'] );

        if ($query->num_rows() < 1) {
            $this->error( $this->config_vars['no_pm'] );
        }

        return $query->result();
    }

    // deletes pm
    public function delete_pm($pm_id){
        return $this->CI->db->delete( $this->config_vars['pms'], array('id' => $pm_id) );
    }

    // counts unread pms and return integer.
    public function count_unread_pms($receiver_id=false){

        if(!$receiver_id){
            $receiver_id = $this->CI->session->userdata('id');
        }

        $query = $this->CI->db->where('reciever_id', $receiver_id);
        $query = $this->CI->db->where('read', 0);
        $query = $this->CI->db->get( $this->config_vars['pms'] );

        return $query->num_rows();
    }

    // sets a pm as unread
    public function set_as_read_pm($pm_id){

        $data = array(
            'read' => 1,
        );

        $this->CI->db->update( $this->config_vars['pms'], $data, "id = $pm_id");
    }



    /////   Updated Error Functions   /////

    public function error($message){

        $this->errors[] = $message;
        $this->CI->session->set_flashdata('errors', $this->errors);
    }

    public function get_errors_array(){

        if (!count($this->errors)==0){
            return $this->errors;
        } else {
            return false;
        }
    }

    public function get_errors($divider = '<br />'){

        $msg = '';
        $msg_num = count($this->errors);
        $i = 1;
        foreach ($this->errors as $e) {
            $msg .= $e;

            if ($i != $msg_num)
                $msg .= $divider;

            $i++;
        }
        return $msg;
    }

    public function info($message){

        $this->infos[] = $message;
        $this->CI->session->set_flashdata('infos', $this->errors);
    }

    public function get_infos_array(){

        if (!count($this->infos)==0){
            return $this->infos;
        } else {
            return false;
        }
    }

    public function get_infos($divider = '<br />'){

        $msg = '';
        $msg_num = count($this->infos);
        $i = 1;
        foreach ($this->infos as $e) {
            $msg .= $e;

            if ($i != $msg_num)
                $msg .= $divider;

            $i++;
        }
        return $msg;
    }

}


/**
 * Coming with v2
 * -------------
 * public id sini 0 a eşitleyip öyle kontrol yapabilirdik
 * permission id yi permission parametre yap
 * performance impr. // tablo isimlerini configden çekmesin
 * captcha
 * mail fonksiyonları imtihanı
 * config
 * stacoverflow
 * login e ip aderesi de eklemek lazım
 * list_users da grup_par verilirse ve adamın birden fazla grubu varsa nolurkun?
 * eğer grup silinmişse kullanıcıları da o gruptan sil (fire)
 * ismember la is admine 2. parametre olarak user id ekle
 * kepp infos errors die bişey yap ajax requestlerinde silinir errorlar
 *
 * Done staff
 * -----------
 * tamam hacı // control die bi fonksiyon yazıp adam önce login omuşmu sonra da yetkisi var mı die kontrol et. yetkisi yoksa yönlendir ve aktivitiyi güncelle
 * tamam hacı // grupları yetkilendirme, yetki ekleme, alma alow deny
 * tamam gibi // Email and pass validation with form helper
 * biraz oldu // laguage file support
 * tamam // forget pass
 * tamam // yetkilendirme sistemi
 * tamam // Login e remember eklencek
 * tamam // şifremi unuttum ve random string
 * sanırım şimdi tamam // hatalı girişde otomatik süreli kilit
 * ??  tamam heral // mail ile bilgilendirme
 * tamam heral // activasyon emaili
 * tamam gibi // yerine email check // username check
 * tamamlandı // public erişimi
 * tamam // Private messsages
 * tamam össen // errorlar düzenlenecek hepisiiii
 * tamam ama engelleme ve limit olayı koymadım. // pm için okundu ve göster, sil, engelle? die fonksiyonlar eklencek , gönderilen pmler, alınan pmler, arasındaki pmler,
 * tamm// already existedleri info yap onlar error değil hacım
 *
 */

?>

