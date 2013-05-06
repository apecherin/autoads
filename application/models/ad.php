<?php
	class Ad extends CI_Model {
		
		protected $_table = 'ads';
		
		public function getAds($limit, $from)
                    {
			$res = $this->db
						->select('ads.id, ads.title, ads.text, ads.foto_main_id, ads.date, ads.price, ads.nick_id, ads.year, fotos.name')
						->from($this->_table)
                                                ->join('fotos', 'fotos.id=ads.foto_main_id')
                                                ->order_by('ads.id','desc')
                                                ->limit($limit, $from)
						->get()
						->result()
						;
			return $res;
                    }
		
		public function getAdById($id)
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
		
                public function searchAd($key)
                    {
			$res = $this->db
					->select('ads.id, ads.title, ads.text, ads.foto_main_id, ads.date, ads.price, ads.nick_id, ads.year, fotos.name')
					->from($this->_table)
                                        ->join('fotos', 'fotos.id=ads.foto_main_id')
					->like('title', $key)
                                        ->or_like('text', $key)
                                        ->order_by('ads.id','desc')
					->get()
					->result()
					;
			return $res;
                    }
                    
               public function searchAdAuthComp($key)
                    {
			$res = $this->db
					->select()
					->from($this->_table)
					->like('title', $key)
                                        ->or_like('text', $key)
                                        ->order_by('id','desc')
					->get()
					->result_array()
					;
			return $res;
                    }     
                    
		public function addNewAd($title, $price, $date, $year, $text, $nick)
                    {
			$data = array(
                                        'title'     => $title ,
                                        'price'     => $price ,
                                        'date'      => $date,
                                        'year'      => $year,
                                        'foto_main_id'   => 11,
                                        'text'	    => $text,
                                        'nick_id'      => $nick
                                    );
			$this->db->insert($this->_table, $data); 
                    }
                    
                public function getMainIdFoto($id)
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
                
                public function deleteAds($id, $fotoMainId)
                    {
                        $this->db
                                 ->where('id', $id)
                                 ->delete($this->_table)
                                ; 
			if($this->db->affected_rows() == 0)
                            {
                                return FALSE;
                            } else {
                                //$fotoMainId=11-this is foto for empty
                                //this foto not remove
                                if($fotoMainId == 11)
                                    {
                                        return TRUE;
                                    } else {
                                        $this->db
                                             ->where('ad_id', $id)
                                             ->delete('fotos')
                                                ;
                                        if($this->db->affected_rows() == 0)
                                            {
                                                return FALSE;
                                            } else {
                                                return TRUE;
                                            }
                                    }
                            }
                    }

                public function deleteFoto($id)
                    {
			$this->db
                                 ->where('id', $id)
                                 ->delete('fotos')
                                ;
                    }                    
                    
                public function editAd($id, $title, $price, $year, $text)
                    {
			$data = array(
                                        'title'	=> $title ,
                                        'price'	=> $price ,
                                        'year'	=> $year,
                                        'text'	=> $text
                                        );
			$this->db->where('id', $id)
                                  ->update($this->_table, $data); 
                    }
                    
                public  function countAds()
                    {
  	  		$query = $this->db->select('id')
                                          ->from($this->_table)
                                          ->get()
                                          ->num_rows();			   			
                        return $query;
                    }    
                    
                public function addMainFotoToAd($id, $foto_main_id)
                    {
			$this->db->set('foto_main_id', $foto_main_id);
			$this->db->where('id', $id);
			$this->db->update($this->_table);
		
			return $this->db->affected_rows();
                    } 
                
                public function getAdByTitleAndNickLast($title, $nick)
                    {
                        $res = $this->db
					->select()
					->from($this->_table)
					->where('title', $title)
                                        ->where('nick_id', $nick)
                                        ->order_by('id','desc')
                                        ->limit('1')
					->get()
					->row()
					;
			return $res;
                    
                    }
                    
                public function getAdsByNick_id($id)
                    {
			$res = $this->db
					->select()
					->from($this->_table)
                                        ->where('nick_id', $id)
                                        ->order_by('id','desc')
					->get()
					->result_array()
					;
			return $res;
                    }
                    
                 public function addNewFoto($id, $fName)
                    {
                        $data = array(
                                        'ad_id' => $id ,
                                        'name'  => $fName 
                                    );
			$this->db->insert('fotos', $data); 
                    
                    }

                 public function GetFotoByIdAd($id, $lim=100)
                    {
                        $res = $this->db
					->select()
					->from('fotos')
					->where('ad_id', $id)
                                        ->limit($lim)
                                        ->order_by('id')
					->get()
					->result()
					;
			return $res;
                    }
                    
                 public function GetFotoByIdAd1($id)
                    {
                        $res = $this->db
					->select()
					->from('fotos')
					->where('ad_id', $id)
                                        ->limit('5')
					->get()
					->row()
					;
			return $res;
                    }
                    
                public function GetFotoById($id)
                    {
                        $res = $this->db
					->select()
					->from('fotos')
					->where('id', $id)
					->get()
					->row()
					;
			return $res;
                    }    
                    
                    
                 public function get_countFoto($id)
                    {
                        $query = $this->db
					->select()
					->from('fotos')
                                        ->where('ad_id', $id)
					->get()
                                        ->num_rows()
					;
                        return $query;
                        
                    }
                    
                        
	}