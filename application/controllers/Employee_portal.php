<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_portal extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load required libraries and models
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Employee_model');
        
        // Create uploads directory if it doesn't exist
        $upload_dir = APPPATH . '../uploads/employee_photos/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
    }
    
    public function index() {
        // If employee is already authenticated, redirect to profile
        if ($this->session->userdata('employee_logged_in')) {
            redirect('employee_portal/profile');
        }
        
        $data['title'] = 'Employee Portal - Login';
        $data['error'] = '';
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('cpf', 'CPF', 'required');
            $this->form_validation->set_rules('pin_4digit', '4-digit PIN', 'required|numeric|exact_length[4]');
            $this->form_validation->set_rules('pin_6digit', '6-digit PIN', 'required|numeric|exact_length[6]');
            
            if ($this->form_validation->run()) {
                $cpf = $this->input->post('cpf');
                $pin_4digit = $this->input->post('pin_4digit');
                $pin_6digit = $this->input->post('pin_6digit');
                
                // Authenticate employee
                $employee = $this->Employee_model->authenticate_employee($cpf, $pin_4digit, $pin_6digit);
                
                if ($employee) {
                    // Check if employee is blocked or on vacation
                    if ($employee->status === 'blocked') {
                        $this->session->set_flashdata('toast_message', 'Your access has been blocked. Please contact HR.');
                        $this->session->set_flashdata('toast_type', 'error');
                        redirect('employee_portal');
                    } elseif ($employee->status === 'vacation') {
                        $this->session->set_flashdata('toast_message', 'You are currently on vacation.');
                        $this->session->set_flashdata('toast_type', 'warning');
                        redirect('employee_portal');
                    } elseif ($employee->status === 'inactive') {
                        $this->session->set_flashdata('toast_message', 'Your account is inactive. Please contact HR.');
                        $this->session->set_flashdata('toast_type', 'error');
                        redirect('employee_portal');
                    } else {
                        // Set employee session
                        $this->session->set_userdata([
                            'employee_logged_in' => true,
                            'employee_id' => $employee->id,
                            'employee_name' => $employee->name,
                            'employee_email' => $employee->email,
                            'employee_cpf' => $employee->cpf,
                            'employee_unit' => $employee->unit_name,
                            'employee_company' => $employee->company_name,
                            'employee_position' => $employee->position,
                            'employee_access_level' => $employee->access_level
                        ]);
                        
                        $this->session->set_flashdata('toast_message', 'Welcome back, ' . $employee->name . '!');
                        $this->session->set_flashdata('toast_type', 'success');
                        redirect('employee_portal/profile');
                    }
                } else {
                    $this->session->set_flashdata('toast_message', 'Invalid CPF or PINs. Please try again.');
                    $this->session->set_flashdata('toast_type', 'error');
                    redirect('employee_portal');
                }
            }
        }
        
        $this->load->view('employee_portal/login', $data);
    }
    
    public function profile() {
        // Check if employee is logged in
        if (!$this->session->userdata('employee_logged_in')) {
            redirect('employee_portal');
        }
        
        $employee_id = $this->session->userdata('employee_id');
        $employee = $this->Employee_model->get_employee($employee_id);
        
        if (!$employee) {
            $this->session->unset_userdata(['employee_logged_in', 'employee_id', 'employee_name', 'employee_email', 'employee_cpf', 'employee_unit', 'employee_company', 'employee_position', 'employee_access_level']);
            redirect('employee_portal');
        }
        
        $data['employee'] = $employee;
        $data['title'] = 'Employee Profile';
        
        $this->load->view('employee_portal/profile', $data);
    }
    
    public function update_profile() {
        // Check if employee is logged in
        if (!$this->session->userdata('employee_logged_in')) {
            redirect('employee_portal');
        }
        
        $employee_id = $this->session->userdata('employee_id');
        $employee = $this->Employee_model->get_employee($employee_id);
        
        if (!$employee) {
            $this->session->unset_userdata(['employee_logged_in', 'employee_id', 'employee_name', 'employee_email', 'employee_cpf', 'employee_unit', 'employee_company', 'employee_position', 'employee_access_level']);
            redirect('employee_portal');
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            
            if ($this->form_validation->run()) {
                $update_data = array(
                    'phone' => $this->input->post('phone')
                );
                
                // Only update PINs if both are provided
                if ($this->input->post('pin_4digit') && $this->input->post('pin_6digit')) {
                    $update_data['pin_4digit'] = $this->input->post('pin_4digit');
                    $update_data['pin_6digit'] = $this->input->post('pin_6digit');
                }
                
                if ($this->Employee_model->update_employee($employee_id, $update_data)) {
                    $this->session->set_flashdata('toast_message', 'Profile updated successfully.');
                    $this->session->set_flashdata('toast_type', 'success');
                } else {
                    $this->session->set_flashdata('toast_message', 'Error updating profile.');
                    $this->session->set_flashdata('toast_type', 'error');
                }
                
                redirect('employee_portal/profile');
            }
        }
        
        $data['employee'] = $employee;
        $data['title'] = 'Update Profile';
        
        $this->load->view('employee_portal/update_profile', $data);
    }
    
    public function capture_photo() {
        // Check if employee is logged in
        if (!$this->session->userdata('employee_logged_in')) {
            redirect('employee_portal');
        }
        
        $employee_id = $this->session->userdata('employee_id');
        $employee = $this->Employee_model->get_employee($employee_id);
        
        if (!$employee) {
            $this->session->unset_userdata(['employee_logged_in', 'employee_id', 'employee_name', 'employee_email', 'employee_cpf', 'employee_unit', 'employee_company', 'employee_position', 'employee_access_level']);
            redirect('employee_portal');
        }
        
        $data['employee'] = $employee;
        $data['title'] = 'Capture Photo';
        
        $this->load->view('employee_portal/capture_photo', $data);
    }
    
    public function save_photo() {
        // Check if employee is logged in
        if (!$this->session->userdata('employee_logged_in')) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Not authenticated']));
            return;
        }
        
        $employee_id = $this->session->userdata('employee_id');
        
        // Get the base64 image data
        $image_data = $this->input->post('image');
        
        if (empty($image_data)) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'No image data received']));
            return;
        }
        
        // Remove data:image/jpeg;base64, prefix
        $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        
        // Decode base64
        $image_data = base64_decode($image_data);
        
        if ($image_data === false) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Invalid image data']));
            return;
        }
        
        // Validate image by re-encoding
        $image_info = getimagesizefromstring($image_data);
        if ($image_info === false) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Invalid image format']));
            return;
        }
        
        // Check image dimensions (minimum 200x200, maximum 2000x2000)
        if ($image_info[0] < 200 || $image_info[1] < 200 || $image_info[0] > 2000 || $image_info[1] > 2000) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Image dimensions must be between 200x200 and 2000x2000 pixels']));
            return;
        }
        
        // Generate unique filename
        $filename = 'employee_' . $employee_id . '_' . time() . '.jpg';
        $upload_path = APPPATH . '../uploads/employee_photos/' . $filename;
        
        // Save the image
        if (file_put_contents($upload_path, $image_data)) {
            // Update employee record with photo path
            $photo_path = 'uploads/employee_photos/' . $filename;
            
            if ($this->Employee_model->update_photo($employee_id, $photo_path)) {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode([
                    'success' => true, 
                    'message' => 'Photo captured successfully',
                    'photo_path' => $photo_path
                ]));
            } else {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(['success' => false, 'message' => 'Error saving photo to database']));
            }
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Error saving photo file']));
        }
    }
    
    public function logout() {
        $this->session->unset_userdata(['employee_logged_in', 'employee_id', 'employee_name', 'employee_email', 'employee_cpf', 'employee_unit', 'employee_company', 'employee_position', 'employee_access_level']);
        $this->session->sess_destroy();
        redirect('employee_portal');
    }
    
    // AJAX method to check if employee exists by CPF
    public function check_cpf() {
        $cpf = $this->input->post('cpf');
        $employee = $this->Employee_model->get_employee_by_cpf($cpf);
        
        $this->output->set_content_type('application/json');
        
        if ($employee) {
            $this->output->set_output(json_encode([
                'exists' => true,
                'name' => $employee->name,
                'unit' => $employee->unit_name,
                'company' => $employee->company_name
            ]));
        } else {
            $this->output->set_output(json_encode(['exists' => false]));
        }
    }
} 