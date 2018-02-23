<?php
    class Test extends CI_Controller{

        public function index(){
            //echo "Index";

            $this->load->view('templates/header');
            $this->load->view('testing/ace');
            //$this->load->view('templates/footer');
        }

        public function proc_data2(){
            // File descriptors passed to the process.
            $descriptors = array(
                0 => array('pipe', 'r'),  // stdin
                1 => array('pipe', 'w'),  // stdout
                2 => array('pipe', 'w')   // stderr
            );

            $timeout = 1;

            //Fetch data from POST
            $data = $this->input->post('content');
            $inputData = $this->input->post('inputData');
            $inputCB = $this->input->post('inputCB');

            if ( ! write_file('assets/file/sample2.c', $data)){
                echo 'Unable to write the file';
            }
            else{
                exec("gcc assets/file/sample2.c -o assets/file/sample2 2> assets/file/sample2.err");
                $err = read_file("assets/file/sample2.err");

                if($err == ""){
                    exec("chmod 777 assets/file/sample2");

                    if($inputCB == "true"){
                        write_file('assets/file/sample2.in', $inputData);
                        //$o = shell_exec("assets/file/sample2 < assets/file/sample2.in");
                        $process = proc_open('exec assets/file/sample2 < assets/file/sample2.in', $descriptors, $pipes);
                    }
                    else{
                        //$o = shell_exec("assets/file/sample2");
                        //echo "Starting Execution";
                        exec("ulimit -f 2");
                        //echo shell_exec("ulimit");
                        $process = proc_open('exec timeout 1s assets/file/sample2 > assets/file/sample2.out', $descriptors, $pipes);
                        //echo "Executed";
                    }
                    
                    if (!is_resource($process)) {
                        throw new \Exception('Could not execute process');
                    }
                    $start = microtime(true);
                    // Set the stdout stream to none-blocking.
                    stream_set_blocking($pipes[1], 0);

                    // Turn the timeout into microseconds.
                    $timeout = $timeout * 1000000;

                    // Output buffer.
                    $buffer = '';
                    //echo "Entering Loop";
                    // While we have time to wait.
                    //print_r($timeout > 0);
                    while ($timeout > 0) {

                        

                        // Wait until we have output or the timer expired.
                        $read  = array($pipes[1]);
                        $other = array();
                        stream_select($read, $other, $other, 0, $timeout);

                        // Get the status of the process.
                        // Do this before we read from the stream,
                        // this way we can't lose the last bit of output if the process dies between these functions.
                        $status = proc_get_status($process);

                        // Read the contents from the buffer.
                        // This function will always return immediately as the stream is none-blocking.
                        $buffer .= stream_get_contents($pipes[1]);

                        if (!$status['running']) {
                        // Break from this loop if the process exited before the timeout.
                        break;
                        }

                        // Subtract the number of microseconds that we waited.
                        $timeout -= (microtime(true) - $start) * 1000000;
                        //$bol = $timeout > 0;
                        //echo "<".$timeout.">";

                    }

                    // Check if there were any errors.
                    $errors = stream_get_contents($pipes[2]);

                    if (!empty($errors)) {
                        //throw new \Exception($errors);
                    }

                    // Kill the process in case the timeout expired and it's still running.
                    // If the process already exited this won't do anything.
                    proc_terminate($process, 9);

                    // Close all streams.
                    fclose($pipes[0]);
                    fclose($pipes[1]);
                    fclose($pipes[2]);

                    proc_close($process);

                    echo $buffer;
                    //$output = read_file("assets/file/sample2.out");
                    //echo $output;
                    
                }
                else {
                    echo $err;
                }
                
            }

            
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