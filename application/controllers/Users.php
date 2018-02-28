<?php
    class Users extends CI_Controller{

        //Login
        public function login(){

            $this->form_validation->set_rules('enroll','Enrollment_Number','required');
            $this->form_validation->set_rules('pass','Password','required');
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/login');
                $this->load->view('templates/footer');
            }
            else{
                $userData = array(
                    'roll_no' => $this->input->post('enroll'),
                    'password' => md5($this->input->post('pass'))
                );

                $user = $this->user_model->login($userData['roll_no'], $userData['password']);

                if($user){

                    //Create Session
					$user_sessData = array(
                        'user_id' => $user->id,
                        'roll_no' => $user->roll_no,
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($user_sessData);

                    header('Content-Type: application/json');
                    echo json_encode($user_sessData);
                    
                }
                else{
                    //echo "Not Found";
                    header('Content-Type: application/json');
                    echo json_encode($userData);
                }

                

                //print_r($userData);
            }
            
        }

        //Logout
        public function logout(){
            $this->session->sess_destroy();
            redirect('/');
        }
    }