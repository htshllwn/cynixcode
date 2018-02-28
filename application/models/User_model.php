<?php
    class User_Model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }

        //Login
        public function login($roll_no,$pass){
            $this->db->where('roll_no',$roll_no);
            $this->db->where('password',$pass);
            $query = $this->db->get('students');
            return $query->row(0);
        }
    }