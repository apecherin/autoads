<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     function check_user_authorization()
            {
                $CI =& get_instance();
                if($CI->session->userdata('id')){
                    $name = $CI->session->userdata('name');
                    $CI->load->model('user');
                    if($CI->user->get_userID($name) == TRUE){
                        $id = $CI->user->get_userID($name);
                        if($CI->session->userdata('id') == $id){
                                return $CI->session->userdata('id');
                            }
                    } else {
                                return 0;
                    }
                } else {
                            return 0;
                }
            }
        function check_administrator()
            {
                $CI =& get_instance();
                $CI->load->model('user');
                if($id = $CI->session->userdata('id')){
                    if($CI->user->check_admin($id) == 1){
                        return TRUE;
                    } else {
                            return FALSE;
                    }
                } else {
                    return FALSE;
                }

            }
            
         function check_admin_additional($id)
            {
                $CI =& get_instance();
                $CI->load->model('user');
                if($CI->user->check_admin($id) == 1){
                    return TRUE;
                } else {
                        return FALSE;
                }

            }
/* End of file common.php */
/* Location: ./application/libraries/auth_lib.php */