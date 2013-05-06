<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     function check_foto_count($id)
            {
                $CI =& get_instance();
                    $CI->load->model('ad');
                    if($CI->ad->get_countFoto($id) == 1){
                        return TRUE;                        
                    } else {
                                return FALSE;
                    }
            } 
/* End of file common.php */
/* Location: ./application/libraries/check_foto_N_helper.php */