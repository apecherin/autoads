<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debug extends CI_Controller {
    private $nick = "0";
    
    public function __construct() 
	{
		parent::__construct();
                $this->load->model(array('ad','user'));
                $this->load->helper(array('url', 'auth_lib'));
                //get username from session
                $this->nick = check_user_authorization();
	}
//show list of users
    public function main()
        {
            $data['access'] = $this->nick;
            if ($this->nick != 3){
                $data['link'] = anchor('ads/main', 'Go to main page');
                $this->load->view('showUsers', $data);
            } else {
                $data['users'] = $this->user->getUsers();  
                $this->load->view('showUsers', $data);
                }      
            
        }
//Method for delete selected user
    public function deleteUser($id)
	{   
        //delete all ads this user
            $ads_id = $this->ad->getAdsByNick_id($id);
            foreach ($ads_id as $ad_id) {
                $fotoMainId = $this->ad->getMainIdFoto($ad_id['id'])->foto_main_id;
                $this->ad->deleteAds($ad_id['id'], $fotoMainId);
            }
        //delete user
            $this->user->deleteUser($id);
            redirect('admin/main'); 
	}
//Method for ban selected user
    public function blockUser($id, $ban_type)
	{   
        //determine time for ban
            switch ($ban_type) {
                case "1" :
                    $date = date('Y-m-d H:i:s', strtotime("+1 hours"));
                    break;
                case "12" :
                    $date = date('Y-m-d H:i:s', strtotime("+12 hours"));
                    break;
                case "24" :
                    $date = date('Y-m-d H:i:s', strtotime("+24 hours"));
                    break;
                case "168" :
                    $date = date('Y-m-d H:i:s', strtotime("+168 hours"));
                    break;
        }
        //ban user
            $this->user->blockUser($id, $date);
            redirect('admin/main'); 
	}
        

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */