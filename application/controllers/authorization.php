<?php
    class Authorization extends CI_Controller {
        private $nick = "0";
        public function __construct() 
        {
            parent::__construct();
            $this->load->model('user');
            $this->load->helper(array('email', 'auth_lib', 'url'));
        }
        
       /**
        * This method implements user authentication, 
        * data checking, recording a session 
        * for user information (id, nick)
        */ 
        public function authUser()
        {
            $this->load->library('form_validation');
            //Check input parameters
            $this->form_validation->set_rules('name', 'Username', 'callback_nick_check|callback_status_check');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('authoriz');
            } else {
                    $name = $this->input->post('name');
                    $id = $this->user->get_userID($name); 
                    $newdata = array(
                                    'id' => $id,
                                    'name'=> $name,
                                    );
                                
                    $this->session->set_userdata($newdata);
                    redirect('/ads/main');
            }
        }

       /**
        * This method validates the entered nickname and password
        * @param $str
        */ 
        public function nick_check($str)
            {
                $password = $this->input->post('password');
                $row = $this->user->get_user_nick_pass($str, md5(trim($password)));
                if ($row == 1){
                    return TRUE;
                } else {
                        $this->form_validation->set_message('nick_check', 'Incorrect nickname or password! Check the correctness of data.');			   
                        return FALSE;
                }
            }
		
       /**
        * This method checks that the user has activated your account
        * @param $str
        */ 
        public function status_check($str)
            {
                $row = $this->user->get_user_status($str);
                if ($row == 1){
                    return TRUE;
                } else {
                        $this->form_validation->set_message('status_check', 'You have not activated your account!');			   
                        return FALSE;
                }
            }

       /**
        * This method logoff user, deletes user data from the session
        */ 
        public function logoff()
            {
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('name');
            
                redirect(''); 
            }
    }
    
/* End of file authorization.php */
/* Location: ./application/controllers/authorization.php */