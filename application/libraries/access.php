<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
class Access{
    public $user;
    
    function __construct(){
        $this->CI=&get_instance();
        $auth=$this->CI->config->item('C_login');
        
        $this->CI->load->helper('cookie');
        $this->CI->load->model('M_user');
        
        $this->M_user=& $this->CI->M_user;
        
    }
    
    function login($username,$password){
        $result=$this->M_user->get_login_info($username,$password);
        if($result){
            $password=$password;
            if($password==$result->password){
                $this->CI->session->set_userdata('username',$result->username);
                return true;
            }
        }
        return false;
    }
    
    function login(){
        return(($this->CI->session->userdata('logged_in'))?TRUE:FALSE);
    }
    
    function logout(){
        $this->CI->session->unset_userdata('logged_in');
    }
}