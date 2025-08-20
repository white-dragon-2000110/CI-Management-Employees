<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }
    
    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['title'] = 'Login';

        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            // Authenticate user against database
            $user = $this->User_model->authenticate_user($email, $password);
            
            if ($user) {
                $this->session->set_userdata([
                    'logged_in' => true,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_role' => $user->role
                ]);
                
                $this->session->set_flashdata('toast_message', 'Welcome back, ' . $user->name . '!');
                $this->session->set_flashdata('toast_type', 'success');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('toast_message', 'Invalid email or password');
                $this->session->set_flashdata('toast_type', 'error');
                redirect('auth/login');
            }
        }

        $this->load->view('auth/login', $data);
    }
    
    public function register() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['title'] = 'Register';

        if ($this->input->post()) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            
            // Basic validation
            if (empty($name) || empty($email) || empty($password)) {
                $this->session->set_flashdata('toast_message', 'All fields are required');
                $this->session->set_flashdata('toast_type', 'error');
                redirect('auth/register');
            } elseif ($password !== $confirm_password) {
                $this->session->set_flashdata('toast_message', 'Passwords do not match');
                $this->session->set_flashdata('toast_type', 'error');
                redirect('auth/register');
            } elseif (strlen($password) < 6) {
                $this->session->set_flashdata('toast_message', 'Password must be at least 6 characters');
                $this->session->set_flashdata('toast_type', 'error');
                redirect('auth/register');
            } else {
                // Check if email already exists in database
                if ($this->User_model->email_exists($email)) {
                    $this->session->set_flashdata('toast_message', 'Email already exists. Please use a different email.');
                    $this->session->set_flashdata('toast_type', 'error');
                    redirect('auth/register');
                } else {
                    // Create user account in database
                    $user_data = [
                        'name' => $name,
                        'email' => $email,
                        'password' => $password, // Will be hashed in the model
                        'role' => 'user'
                    ];
                    
                    $user_id = $this->User_model->create_user($user_data);
                    
                    if ($user_id) {
                        // Automatically log in the new user
                        $this->session->set_userdata([
                            'logged_in' => true,
                            'user_id' => $user_id,
                            'user_name' => $name,
                            'user_email' => $email,
                            'user_role' => 'user'
                        ]);
                        
                        $this->session->set_flashdata('toast_message', 'Account created successfully! Welcome to EMS!');
                        $this->session->set_flashdata('toast_type', 'success');
                        
                        // Redirect to dashboard after successful registration
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata('toast_message', 'Error creating account. Please try again.');
                        $this->session->set_flashdata('toast_type', 'error');
                        redirect('auth/register');
                    }
                }
            }
        }

        $this->load->view('auth/register', $data);
    }
    
    public function logout() {
        $this->session->set_flashdata('toast_message', 'You have been logged out successfully');
        $this->session->set_flashdata('toast_type', 'info');
        
        $this->session->unset_userdata(['logged_in', 'user_id', 'user_email', 'user_role']);
        $this->session->sess_destroy();
        redirect('auth/login');
    }
} 