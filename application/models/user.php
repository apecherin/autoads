<?php
	class User extends CI_Model {
		
		protected $_table = 'users';	
		
		public function addUser($name, $status=0, $admin=0, $email, $password, $reginform_id, $date)
                    {
			$data = array(
                                        'name'          => $name ,
                                        'status'        => $status ,
                                        'admin'         => $admin ,
                                        'email'         => $email,
                                        'password'      => $password,
                                        'reginform_id'  => $reginform_id,
                                        'td_block'      => $date
                                     );
			$this->db->insert($this->_table, $data); 
                    }
                    
                public function deleteUser($id)
                    {
			$this->db
                                 ->where('id', $id)
                                 ->delete($this->_table)
                                ;
                    }
               
                public function blockUser($id, $date)
                    {
			$this->db->set('td_block', $date)
                                 ->where('id', $id)
                                 ->update($this->_table);
                    }
                    
                public function getUsers()
                    {
			$res = $this->db
						->select()
						->from($this->_table)
                                                ->order_by('id','desc')
						->get()
						->result()
						;
			return $res;
                    }
                    
                public function getUserByID($id)
                    {
			$res = $this->db
						->select()
						->from($this->_table)
                                                ->where('id', $id)
						->get()
						->row()
						;
			return $res;
                    }
                    
                public function check_user_inDB($name)
                    {
  	  		$query = $this->db->select()
                                          ->from($this->_table)
                                          ->where('name', $name)
                                          ->get();
                        if ($query->num_rows() > 0) { 
                            return TRUE;
                        } else {
                                    return FALSE;
                        }            
                    }
                 public function check_admin($id)
                    {
  	  		$query = $this->db->select('admin')
                                          ->from($this->_table)
                                          ->where('id', $id)
                                          ->get();
                        if ($query->num_rows() > 0) { 
                            $row = $query->row();			   			
                            return $row->admin;
                        } else {
                                    return 0;
                        }            
                    }
                    
                public function getBanStatus($id)
                    {
			$query = $this->db
						->select()
						->from($this->_table)
                                                ->where('id', $id)
                                                ->where('td_block > sysdate()') 
						->get();
                        if ($query->num_rows() > 0) 
                            { 
                                $row = $query->row();			   			
                                return TRUE;
                            } else {
                                return FALSE;
                            } 
                    }    
                    
                public function update_status($id)
                    {
			$array = array(     'reginform_id' => $id, 
                                            'status'       => 0);
			$this->db->set('status', 1)
                                 ->where($array)
                                 ->update($this->_table);
			return $this->db->affected_rows();
                    }
                    
                 public function get_userID($name)
                    {
  	  		$query = $this->db->select('id')
                                          ->from($this->_table)
                                          ->where('name', $name)
                                          ->get();
                        if ($query->num_rows() > 0) { 
                            $row = $query->row();			   			
                            return $row->id;
                        } else {
                                    return 1;
                        }            
                    } 
                    
                  public function get_user_nick_pass($name, $password)
                    {
  	  		$query = $this->db
                                          ->select('name')
                                          ->from($this->_table)
                                          ->where('name', $name)
                                          ->where('password', $password)
                                          ->get()
                                          ->num_rows();
                        return $query;                        
                    }
                
                  public function get_user_status($name)
                    {
  	  		$query = $this->db  ->select('name')
                                            ->from($this->_table)
                                            ->where('name', $name)
                                            ->where('status', 1)
                                            ->get()			   			
                                            ->num_rows();
                        return $query;                                
                    }
	}