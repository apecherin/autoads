<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrate extends CI_Controller {
        private $nick = "0";
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('user');
		$this->load->library('email');
                $this->load->helper(array('auth_lib', 'url', 'captcha'));

	}

    private function _setValidationReg() 
    {
		//install forms validation rules and error messages
		$this->form_validation  
					->set_rules('name', 'User Name', 'trim|required|min_length[4]|max_length[12]|xss_clean')
					->set_rules('email', 'User Email', 'trim|required|valid_email|xss_clean')
					->set_rules('password', 'User Password', 'trim|required|min_length[6]|max_length[12]|xss_clean')
					->set_rules('repassword', 'Retry Password', 'trim|required|matches[password]|xss_clean')
                                        ->set_rules('captcha', 'Captcha', 'callback_validate_captcha');
					;
	}					
	 //only for me
        /*
        public function addUsers()
        {
            $count=0;
            while ($count<20){
                $name ='artem'.$count;
                $email='artem'.$count.'@gmail.com';
                $password = 'artem'.$count;;
                $password = md5($this->input->post('password'));
                $reginform_id = md5($email . mktime());
                $date = date('Y-m-j h:i:s');
                $count++; 
                $this->user->addUser($name, 1, 0, $email, $password, $reginform_id, $date);
            }
             redirect('admin/main/');
        }
         * 
         */
	public function addUser()
	{
		$this->load->library('form_validation');
		$this->_setValidationReg();
		if ($this->form_validation->run() == FALSE){
                        $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
			      $original_string = implode("", $original_string);
			      $captcha = substr(str_shuffle($original_string), 0, 6);
			      //for captcha
			      $vals = array(
					      'word' => $captcha,
					      'img_path' => './images/captcha/',
					      'img_url' => 'http://zahar-test.com/autoads/images/captcha/',
					      'font_path' => 'BASEPATH./system/fonts/texb.ttf',
					      'img_width' => 130,
					      'img_height' => 30,
					      'expiration' => 200
					      );
			      $cap = create_captcha($vals);
			      $data['image'] = $cap['image'];
                        @ini_set('display_errors', 'off');
                        if(file_exists('BASEPATH../images/captcha/'.$this->session->userdata['image']))
                        unlink('BASEPATH../images/captcha/'.$this->session->userdata['image']);
                        $this->session->set_userdata(array('captcha'=>$captcha, 'image' => $cap['time'].'.jpg'));
                        //echo $cap['image'];
			$this->load->view('vReg', $data);
		} else {
                    if(file_exists('BASEPATH../images/captcha/'.$this->session->userdata['image']))
                    unlink('BASEPATH../images/captcha/'.$this->session->userdata['image']);
                    $this->session->unset_userdata('captcha');
                    $this->session->unset_userdata('image');
                    
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $password = md5($this->input->post('password'));
                    $reginform_id = md5($email . mktime());
                    $date = date('Y-m-j h:i:s');
                    //check !exist user by name
                    if ($this->user->check_user_inDB($name)){
                         $data['succes'] = "Dear, unfortunately user name".$name." is already registered in the system.</br>
                            Please use a different name."; 
                         $data['link'] = anchor('registrate/addUser', 'Back to registration');
                    } else {
                        //add new user to db
                       $this->user->addUser($name, 0, 0, $email, $password, $reginform_id, $date);
                         //send message to email new user for confirm registration 
                        $this->email->from('acheperin@mail.ru', 'Admin autoads.ru');
                        $this->email->to($email);
                        $this->email->subject('Confirmation be registered on the autoads.ru');
                        $this->email->message('To activate the account click on the following link -
                        http://zahar-test.com/autoads/index.php/registrate/activ/'. $reginform_id .' or copy the link into your browsers address input box and hit enter.');
                        $this->email->send();
                        
                        $data['succes'] = "Dear ".$name.", registration is completed,</br>
                            the entered your e-mail - </br>".$email."</br>message was sent to activate your account"; 
                        $data['link'] = anchor('authorization/authUser', 'authorization');
                    }
                    $this->load->view('afterReg', $data);
		}
	}
        public function validate_captcha(){
            if($this->input->post('captcha') != $this->session->userdata['captcha'])
                {
                    $this->form_validation->set_message('validate_captcha', 'Wrong captcha code, hmm are you the Terminator?');
                    return false;
            }else{
                    return true;
                }
        }
               /**
        * This method enables a user account that has passed 
        * on the link to the letter sent to him by email at 
        * registration and verify the ID register
        * @param $id
        */
	public function activ($id)
		{
                    $row = $this->user->update_status($id);
                    if ($row == 1) {
                    $data['success'] = 'Your account has been activated. Now you can authorize using data from registering';
                    } else {
                    $data['error'] = 'Activation is not possible: profile is activated';
                    }
                    $data['link'] = anchor('authorization/authUser', 'authorization');
                    $this->load->view('afterReg', $data);
		}
}

/* End of file registrate.php */
/* Location: ./application/controllers/registrate.php */