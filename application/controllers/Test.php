<?php
    class Test extends CI_Controller{

        public function index(){
            //echo "Index";

            $this->load->view('templates/header');
            $this->load->view('testing/ace');
            //$this->load->view('templates/footer');
        }

        public function proc_data(){
            
            $data = $this->input->post('content');
            $inputData = $this->input->post('inputData');
            $inputCB = $this->input->post('inputCB');
            //print_r($inputCB);
            //write_file('././sample2.c', $data);
            chdir('assets/file/');
            //exec('pwd');
            if ( ! write_file('./sample2.c', $data)){
                echo 'Unable to write the file';
            }
            else{

                //echo 'File written!';
                exec("gcc ./sample2.c -o ./sample2 2> ./sample2.err");
                $err = read_file("./sample2.err");
                if($err == ""){
                    exec("chmod 777 ./sample2");

                    if($inputCB == "true"){
                        write_file('./sample2.in', $inputData);
                        $o = shell_exec("./sample2 < ./sample2.in");
                    }
                    else{
                        $o = shell_exec("timeout --kill-after=1s 1s ./sample2");
                        //echo "Executed";
                    } 
                    
                    //exec("rm -f ./sample2");
                    //foreach ($o as $output) {
                        header('Content-Type: text/plain');
                        echo $o."\n";
                    //}
                }
                else {
                    echo $err;
                }
                
            }
            
        }

    }