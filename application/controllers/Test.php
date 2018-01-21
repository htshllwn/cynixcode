<?php
    class Test extends CI_Controller{

        public function index(){
            //echo "Index";

            $this->load->view('templates/header');
            $this->load->view('testing/ace');
            //$this->load->view('templates/footer');
        }

    }