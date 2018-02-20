<?php
    class Test extends CI_Controller{

        public function index(){
            //echo "Index";

            $this->load->view('templates/header');
            $this->load->view('testing/ace');
            //$this->load->view('templates/footer');
        }

        public function proc_data(){
            //echo "TEST PROC DATA";
            //print_r($_POST['content']);
            //print_r($this->input->post('content'));

            $data = $this->input->post('content');
            //write_file('./assets/file/sample2.c', $data);
            
            if ( ! write_file('./assets/file/sample2.c', $data)){
                echo 'Unable to write the file';
            }
            else{
                //echo 'File written!';
                exec("gcc assets/file/sample2.c -o assets/file/sample2 2> assets/file/sample2.err");
                $err = read_file("assets/file/sample2.err");
                if($err == ""){
                    exec("chmod 700 assets/file/sample2");
                    exec("assets/file/sample2",$o);
                    exec("rm -f assets/file/sample2");
                    foreach ($o as $output) {
                        header('Content-Type: text/plain');
                        echo $output."\n";
                    }
                }
                else {
                    echo $err;
                }
                
            }
            
        }

    }