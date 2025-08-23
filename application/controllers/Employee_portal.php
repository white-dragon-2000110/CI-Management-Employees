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
            if (!mkdir($upload_dir, 0755, true)) {
                log_message('error', 'Failed to create uploads directory: ' . $upload_dir);
            }
        }
        
        // Enable error logging
        log_message('info', 'Employee_portal controller initialized');
    }
    
    public function index() {
        // If employee is already authenticated, redirect to profile
        if ($this->session->userdata('employee_logged_in')) {
            redirect('employee_portal/profile');
        }
        
        $data['title'] = 'Portal do Funcionário - Login';
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
            log_message('warning', 'Unauthorized access attempt to profile');
            redirect('employee_portal');
        }
        
        $employee_id = $this->session->userdata('employee_id');
        $employee = $this->Employee_model->get_employee($employee_id);
        
        if (!$employee) {
            log_message('error', 'Employee not found for ID: ' . $employee_id . ' in profile');
            $this->session->unset_userdata(['employee_logged_in', 'employee_id', 'employee_name', 'employee_email', 'employee_cpf', 'employee_unit', 'employee_company', 'employee_position', 'employee_access_level']);
            redirect('employee_portal');
        }
        
        log_message('info', 'Employee profile page loaded for ID: ' . $employee_id);
        $data['employee'] = $employee;
        $data['title'] = 'Employee Profile';
        
        $this->load->view('employee_portal/profile', $data);
    }
    
    public function update_profile() {
        // Check if employee is logged in
        if (!$this->session->userdata('employee_logged_in')) {
            log_message('warning', 'Unauthorized access attempt to update_profile');
            redirect('employee_portal');
        }
        
        $employee_id = $this->session->userdata('employee_id');
        $employee = $this->Employee_model->get_employee($employee_id);
        
        if (!$employee) {
            log_message('error', 'Employee not found for ID: ' . $employee_id . ' in update_profile');
            $this->session->unset_userdata(['employee_logged_in', 'employee_id', 'employee_name', 'employee_email', 'employee_cpf', 'employee_unit', 'employee_company', 'employee_position', 'employee_access_level']);
            redirect('employee_portal');
        }
        
        if ($this->input->post()) {
            log_message('info', 'Update profile form submitted for employee ID: ' . $employee_id);
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            
            if ($this->form_validation->run()) {
                $update_data = array(
                    'phone' => $this->input->post('phone')
                );
                
                log_message('info', 'Form validation passed for employee ID: ' . $employee_id . ', phone: ' . $this->input->post('phone'));
                
                // Only update PINs if both are provided
                if ($this->input->post('pin_4digit') && $this->input->post('pin_6digit')) {
                    $update_data['pin_4digit'] = $this->input->post('pin_4digit');
                    $update_data['pin_6digit'] = $this->input->post('pin_6digit');
                    log_message('info', 'PINs will be updated for employee ID: ' . $employee_id);
                } else {
                    log_message('info', 'PINs not provided for employee ID: ' . $employee_id);
                }
                
                if ($this->Employee_model->update_employee($employee_id, $update_data)) {
                    log_message('info', 'Employee profile updated successfully for ID: ' . $employee_id);
                    $this->session->set_flashdata('toast_message', 'Profile updated successfully.');
                    $this->session->set_flashdata('toast_type', 'success');
                } else {
                    log_message('error', 'Failed to update employee profile for ID: ' . $employee_id);
                    $this->session->set_flashdata('toast_message', 'Error updating profile.');
                    $this->session->set_flashdata('toast_type', 'error');
                }
                
                redirect('employee_portal/profile');
            } else {
                // Add validation errors to data
                $data['validation_errors'] = validation_errors();
                log_message('warning', 'Form validation failed for employee ID: ' . $employee_id . ' - Errors: ' . validation_errors());
            }
        }
        
        $data['employee'] = $employee;
        $data['title'] = 'Update Profile';
        
        $this->load->view('employee_portal/update_profile', $data);
    }
    
    public function capture_photo() {
        // Check if employee is logged in
        if (!$this->session->userdata('employee_logged_in')) {
            log_message('warning', 'Unauthorized access attempt to capture_photo');
            redirect('employee_portal');
        }
        
        $employee_id = $this->session->userdata('employee_id');
        $employee = $this->Employee_model->get_employee($employee_id);
        
        if (!$employee) {
            log_message('error', 'Employee not found for ID: ' . $employee_id . ' in capture_photo');
            $this->session->unset_userdata(['employee_logged_in', 'employee_id', 'employee_name', 'employee_email', 'employee_cpf', 'employee_unit', 'employee_company', 'employee_position', 'employee_access_level']);
            redirect('employee_portal');
        }
        
        log_message('info', 'Employee photo capture page loaded for ID: ' . $employee_id);
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
        
        log_message('info', 'Photo save request received for employee ID: ' . $employee_id);
        
        if (empty($image_data)) {
            log_message('error', 'No image data received for employee ID: ' . $employee_id);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'No image data received']));
            return;
        }
        
        // Remove data:image/jpeg;base64, prefix
        $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        
        log_message('info', 'Image data processed, length: ' . strlen($image_data));
        
        // Decode base64
        $image_data = base64_decode($image_data);
        
        if ($image_data === false) {
            log_message('error', 'Failed to decode base64 image data for employee ID: ' . $employee_id);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Invalid image data']));
            return;
        }
        
        // Validate image by re-encoding
        $image_info = getimagesizefromstring($image_data);
        if ($image_info === false) {
            log_message('error', 'Invalid image format for employee ID: ' . $employee_id);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Invalid image format']));
            return;
        }
        
        log_message('info', 'Image validated - dimensions: ' . $image_info[0] . 'x' . $image_info[1] . ' for employee ID: ' . $employee_id);
        
        // Check image dimensions (minimum 200x200, maximum 2000x2000)
        if ($image_info[0] < 200 || $image_info[1] < 200 || $image_info[0] > 2000 || $image_info[1] > 2000) {
            log_message('error', 'Image dimensions out of range: ' . $image_info[0] . 'x' . $image_info[1] . ' for employee ID: ' . $employee_id);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Image dimensions must be between 200x200 and 2000x2000 pixels']));
            return;
        }
        
        // Generate unique filename
        $filename = 'employee_' . $employee_id . '_' . time() . '.jpg';
        $upload_path = APPPATH . '../uploads/employee_photos/' . $filename;
        
        log_message('info', 'Attempting to save image to: ' . $upload_path . ' for employee ID: ' . $employee_id);
        
        // Ensure upload directory exists
        $upload_dir = dirname($upload_path);
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                log_message('error', 'Failed to create upload directory: ' . $upload_dir . ' for employee ID: ' . $employee_id);
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(['success' => false, 'message' => 'Error creating upload directory']));
                return;
            }
        }
        
        // Save the image
        if (file_put_contents($upload_path, $image_data)) {
            // Update employee record with photo path
            $photo_path = 'uploads/employee_photos/' . $filename;
            
            if ($this->Employee_model->update_photo($employee_id, $photo_path)) {
                log_message('info', 'Employee photo updated successfully for ID: ' . $employee_id . ' at path: ' . $photo_path);
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode([
                    'success' => true, 
                    'message' => 'Photo captured successfully',
                    'photo_path' => $photo_path
                ]));
            } else {
                log_message('error', 'Failed to update employee photo in database for ID: ' . $employee_id);
                // Delete the uploaded file if database update fails
                if (file_exists($upload_path)) {
                    unlink($upload_path);
                }
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(['success' => false, 'message' => 'Error saving photo to database']));
            }
        } else {
            log_message('error', 'Failed to save image file to: ' . $upload_path . ' for employee ID: ' . $employee_id);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Error saving photo file. Check directory permissions.']));
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