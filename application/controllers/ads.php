<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends CI_Controller {
    
    private $nick = "0";    
    public function __construct() 
	{
		parent::__construct();
		$this->load->model(array('ad','user'));
                $this->load->library('pagination');
                $this->load->helper(array('form', 'url', 'auth_lib', 'check_foto'));
                //get username from session
                $this->nick = check_user_authorization();
	}
        //only for me
        /*
    public function addNewAds()
        {             
            $users = $this->user->getUsers();
            var_dump($users);
            foreach ($users as $usr) {
                $user = $usr->id;
                $count=0;
                while ($count<5){
                    //title
                    $titles = array("Nissan Xtrail", "BMW X5", "Toyota Camry", "Audi A6", "VAZ 21011", "TAZ 121", "Honda Civic", "Ford Focus", "BMW X3");
                    $key = array_rand($titles);
                    $title = $titles[$key];
                    //year
                    $years = array("2003", "2011", "2005", "2008");
                    $key = array_rand($years);
                    $year = $years[$key];
                    //price
                    $prices = array("8000", "9000", "15000", "43300");
                    $key = array_rand($prices);
                    $price = $prices[$key];
                    //text
                    $texts = array(
                        "This very good auto! Call me!",
                        "Please call me for detail",
                        "Urgently! auction!",
                        "This my first auto. Very good car... call me for detail"
                        );
                    $key = array_rand($texts);
                    $text = $texts[$key];
                    $count++;
                    $this->ad->addNewAd($title, $price, date('Y-m-j h:i:s'),$year, $text, $user);
                }
            }
            redirect('ads/main/'); 
        }
         * 
         */
//for main page	
    public function main($from=0)
	{   
            $data['access'] = $this->nick;
            //if search
                if($this->input->get('q', TRUE))
                    {
                        $data['ads'] = $this->ad->searchAd($this->input->get('q', TRUE));
                    } else {
                                //count for view ads
                                $limit = 10;
                                $data['ads'] = $this->ad->getAds($limit, $from);
           
                                //parameters for pagination main page    
                                $config['total_rows'] = $this->ad->countAds();
                                $config['base_url'] = base_url().'/ads/main/'; 
                                $config['per_page']  = 10;
                                $config['first_link'] = 'First';
                                $config['first_tag_open'] = '<li>';
                                $config['first_tag_close'] = '</li>';
                                $config['next_link'] = 'Next';
                                $config['next_tag_open'] = '<li>';
                                $config['next_tag_close'] = '</li>';
                                $config['prev_link'] = 'Previous';
                                $config['prev_tag_open'] = '<li>';
                                $config['prev_tag_close'] = '</li>';
                                $config['last_link'] = 'last';
                                $config['last_tag_open'] = '<li>';
                                $config['last_tag_close'] = '</li>';
                                $config['cur_tag_open'] = '<li><a class="current">';
                                $config['cur_tag_close'] = '</a></li>';
                                $config['num_tag_open'] = '<li>';
                                $config['num_tag_close'] = '</li>';

                                $this->pagination->initialize($config);
                    }
                $data['pager'] = $this->pagination->create_links();     
                $this->load->view('main', $data);
	}
//Get data from DB for autocomplete search        
    public function searchAutoCompl()
        {
            $ads = $this->ad->searchAdAuthComp($this->input->get('q', TRUE));
            foreach ($ads as $ad) {
                echo $ad['title'] . "\n";
                echo $ad['text'] . "\n";
            }
        }
//Method for show selected ad
    public function showAd($id, $from='')
	{       
            ($from == 1) ? ($data['frm'] = 'add') : ($data['frm'] = 'shw');
            $data['access'] = $this->nick;
            $data['ads']        = $this->ad->getAdById($id);
            $data['link_edit'] = anchor('ads/editAd/'.$id, 'edit the ad');
            $data['link_delete'] = anchor('ads/deleteAd/'.$id, 'delete the ad');
            if (($this->user->check_admin($this->nick)) == 1) ($data['admin']=TRUE);
            $data['error']      = "";
            $data['upl_succes'] = "";
            $data['fotos']      = $this->ad->GetFotoByIdAd($id, $lim=5);
            $this->load->view('showAd', $data);
	}

//Method for delete selected ad
    public function deleteAd($id)
	{   
            $data['ads_sid']  = $this->ad->getAdById($id);
            //for pidoroffff
            if (!(check_user_authorization() == $data['ads_sid']->nick_id) && !($this->user->check_admin($this->nick)) == 1) redirect('ads/main/');
            
            $fotoMainId = $this->ad->getMainIdFoto($id)->foto_main_id;
            //delete files
            $fotos = $this->ad->GetFotoByIdAd($id, $lim=100);
            if(!empty($fotos)){
                foreach($fotos as $foto){
                    unlink('./images/uploads/min/'.$foto->name);
                    unlink('./images/uploads/max/'.$foto->name);
                }
            }
            
            if($this->ad->deleteAds($id, $fotoMainId))
                {
                    $data['rsuccess'] = "Ads was successfully removed.";
                    $data['link']    = anchor('ads/main', 'to list ads');
                } else {
                    $data['rsuccess'] = "Ads was not removed.";
                    $data['link']    = anchor('ads/deleteAd/'.$id, 'try again');
                }
            $this->load->view('showAd', $data);
	}
        
//Method for delete selected foto
    public function deleteFoto($id, $id_ad)
	{   
            $data['ads_sid']  = $this->ad->getAdById($id_ad);
            //for pidoroffff
            if (!(check_user_authorization() == $data['ads_sid']->nick_id) && !($this->user->check_admin($this->nick)) == 1) redirect('ads/main/');
            //delete files
            $foto = $this->ad->GetFotoById($id);
            unlink('./images/uploads/min/'.$foto->name);
            unlink('./images/uploads/max/'.$foto->name);
            $this->ad->deleteFoto($id);
            redirect('ads/editAd/'.$id_ad);  
	}

//Method for set rules for validation when we add new ad
    private function _setValidationAddNAd() 
        {
		//install forms validation rules and error messages
		$this->form_validation  
					->set_rules('title', 'Title for ad', 'trim|required|max_length[20]|xss_clean')
					->set_rules('price', 'Price for ad', 'trim|required|max_length[12]|numeric|xss_clean')
					->set_rules('year', 'Year for car', 'trim|required|max_length[10]|numeric|xss_clean')
					->set_rules('text', 'Text for ad', 'trim|required|max_length[150]|xss_clean')
					;
        }
        
//Method for edit selected ad
    public function editAd($id)
	{    
            $data['ads']        = $this->ad->getAdById($id);
            //for pidoroffff
            if (!(check_user_authorization() == $data['ads']->nick_id) && !($this->user->check_admin($this->nick)) == 1) redirect('ads/main/');
            $data['error']      = "";
            $data['frm']      = "edit";
            $data['upl_succes'] = "";
            $data['fotos']      = $this->ad->GetFotoByIdAd($id, $lim=10);
            if (($this->user->check_admin($this->nick)) == 1) ($data['admin']=TRUE);
            $this->load->library('form_validation');
                $this->_setValidationAddNAd();
                if ($this->form_validation->run() == FALSE)
                    {
                        $this->load->view('editAd', $data);
                    } else {
                        $this->ad->editAd(
                                            $this->input->post('id'),
                                            $this->input->post('title'),
                                            $this->input->post('price'),
                                            $this->input->post('year'),
                                            $this->input->post('text')
                                            );
                        redirect('ads/showAd/'.$id);      
                    }
	}
       
//Method for add new ad	
    public function addNewAd()
	{   
            $data['access'] = $this->nick;
            $data['link'] = anchor('registrate/addUser', 'Go to registration');
            if ($this->nick == 0){
                $this->load->view('addNewAd', $data);
            } elseif($this->user->getBanStatus($this->nick)) {
                $data['link'] = anchor('#', 'write message to administrator');
                $data['user'] = $this->user->getUserByID($this->nick);
                $this->load->view('addNewAd', $data);
            } else {
                     $this->load->library('form_validation');
                     $this->_setValidationAddNAd();
                     if ($this->form_validation->run() == FALSE){
                        $this->load->view('addNewAd', $data);
                    } else {
                            $this->ad->addNewAd(
                                                $this->input->post('title'),
                                                $this->input->post('price'),
                                                date('Y-m-j h:i:s'),
                                                $this->input->post('year'),
                                                $this->input->post('text'),
                                                $this->nick
                                            );
                            //get id a new ad and show her
                            $data = $this->ad->getAdByTitleAndNickLast(($this->input->post('title')), ($this->nick));
                            redirect('ads/showAd/'.$data->id.'/1');        
                    }
            }
	}
//method for add foto ad
    public function uploadFoto($id)
	{
		$config['upload_path'] = './images/uploads/temp/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= '2048';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
                $config['encrypt_name']  = TRUE;
    
		$this->load->library('upload', $config);
                //send neccesary data about ad
                $data['ads'] = $this->ad->getAdById($id);
                //?from page
                $data['frm'] = 'add';
                //default value for error 
                $data['error']  = "";
                $data['access']  = "";
                $data['upl_succes'] = "yes";
                $data['fotos'] = $this->ad->GetFotoByIdAd($id, $lim=10);
		if ( !$this->upload->do_upload())
                    {
                        //system error when booting
                        $data['upl_succes'] = '';
                        $data['error'] = $this->upload->display_errors();
                        $this->load->view('showAd', $data);
                    } else {
                        //save file on server, save path in DB
                        $dataAboutFile = $this->upload->data();
                        $fName= $dataAboutFile['file_name'];
                        //resize min file
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './images/uploads/temp/'.$fName;
                        $config['new_image'] = './images/uploads/min/'.$fName;
                        $config['maintain_ratio'] = TRUE; 
                        $config['master_dim'] = 'auto';
                        $config['quality'] = 100;
                        $config['width'] = 125; 
                        $config['height'] = 90;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                        //resize max file
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './images/uploads/temp/'.$fName;
                        $config['new_image'] = './images/uploads/max/'.$fName;
                        $config['maintain_ratio'] = TRUE; 
                        $config['master_dim'] = 'auto';
                        $config['quality'] = 100;
                        $config['width'] = 800; 
                        $config['height'] = 400;
                        $this->load->library("image_lib");
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                        //delete temp file
                        unlink('./images/uploads/temp/'.$fName); 
                        $this->ad->addNewFoto($id, $fName);
                        //add main foto for ad(the first photo, which was added)
                        if(check_foto_count($id))
                            {
                                $foto_main_id = $this->ad->GetFotoByIdAd1($id, $lim=10);
                                $this->ad->addMainFotoToAd($id, $foto_main_id->id);
                            }
                        $this->load->view('showAd', $data);
                    
                    }
	}
//method for add foto ad
    public function uploadFoto_costl($id)
	{
		$config['upload_path'] = './images/uploads/temp/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= '2048';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
                $config['encrypt_name']  = TRUE;
    
		$this->load->library('upload', $config);
                //send neccesary data about ad
                $data['ads'] = $this->ad->getAdById($id);
                //?from page
                $data['frm'] = 'add';
                //default value for error 
                $data['error']  = "";
                $data['access']  = "";
                $data['upl_succes'] = "yes";
                $data['fotos'] = $this->ad->GetFotoByIdAd($id, $lim=5);
		if ( !$this->upload->do_upload())
                    {
                        //system error when booting
                        $data['upl_succes'] = '';
                        $data['error'] = $this->upload->display_errors();
                        $this->load->view('editAd', $data);
                    } else {
                        //save file on server, save path in DB
                        $dataAboutFile = $this->upload->data();
                        $fName= $dataAboutFile['file_name'];
                         //resize min file
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './images/uploads/temp/'.$fName;
                        $config['new_image'] = './images/uploads/min/'.$fName;
                        $config['maintain_ratio'] = TRUE;
                        $config['master_dim'] = 'auto';
                        $config['quality'] = 100;
                        $config['width'] = 125; 
                        $config['height'] = 90;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                        //resize max file
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './images/uploads/temp/'.$fName;
                        $config['new_image'] = './images/uploads/max/'.$fName;
                        $config['maintain_ratio'] = TRUE; 
                        $config['master_dim'] = 'auto';
                        $config['quality'] = 100;
                        $config['width'] = 800; 
                        $config['height'] = 400;
                        $this->load->library("image_lib");
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                        //delete temp file
                        unlink('./images/uploads/temp/'.$fName);
                        $this->ad->addNewFoto($id, $fName);
                        //add main foto for ad(the first photo, which was added)
                        if(check_foto_count($id))
                            {
                                $foto_main_id = $this->ad->GetFotoByIdAd1($id, $lim=5);
                                $this->ad->addMainFotoToAd($id, $foto_main_id->id);
                            }
                        $this->load->view('editAd', $data); 
                    }
	}

}

/* End of file ads.php */
/* Location: ./application/controllers/ads.php */