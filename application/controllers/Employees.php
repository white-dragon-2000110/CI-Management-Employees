<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load required libraries and models
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Employee_model');
        
        // Check if user is logged in
        // Temporarily disabled for testing
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('login');
        // }
    }
    
    public function index() {
        $filters = array();
        
        // Get filter parameters
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }
        if ($this->input->get('status')) {
            $filters['status'] = $this->input->get('status');
        }
        if ($this->input->get('unit_id')) {
            $filters['unit_id'] = $this->input->get('unit_id');
        }
        if ($this->input->get('company_id')) {
            $filters['company_id'] = $this->input->get('company_id');
        }
        
        $data['employees'] = $this->Employee_model->get_employees($filters);
        $data['stats'] = $this->Employee_model->get_employee_stats();
        $data['companies'] = $this->Employee_model->get_companies();
        $data['units'] = $this->Employee_model->get_units();
        $data['filters'] = $filters;
        $data['title'] = 'Employee Management';
        
        $this->load->view('templates/header', $data);
        $this->load->view('employees/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add() {
        if ($this->input->post()) {
            // Set validation rules
            $this->form_validation->set_rules('cpf', 'CPF', 'required|is_unique[employees.cpf]');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employees.email]');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('position', 'Position', 'required');
            $this->form_validation->set_rules('unit_id', 'Unit', 'required|numeric');
            $this->form_validation->set_rules('company_id', 'Company', 'required|numeric');
            $this->form_validation->set_rules('pin_4digit', '4-digit PIN', 'required|numeric|exact_length[4]');
            $this->form_validation->set_rules('pin_6digit', '6-digit PIN', 'required|numeric|exact_length[6]');
            
            if ($this->form_validation->run()) {
                $employee_data = array(
                    'cpf' => $this->input->post('cpf'),
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'position' => $this->input->post('position'),
                    'unit_id' => $this->input->post('unit_id'),
                    'company_id' => $this->input->post('company_id'),
                    'access_level' => $this->input->post('access_level') ?: 'basic',
                    'pin_4digit' => $this->input->post('pin_4digit'),
                    'pin_6digit' => $this->input->post('pin_6digit')
                );
                
                $employee_id = $this->Employee_model->create_employee($employee_data);
                
                if ($employee_id) {
                    $this->session->set_flashdata('toast_message', 'Employee created successfully.');
                    $this->session->set_flashdata('toast_type', 'success');
                    redirect('employees/view/' . $employee_id);
                } else {
                    $this->session->set_flashdata('toast_message', 'Error creating employee.');
                    $this->session->set_flashdata('toast_type', 'error');
                }
            }
        }
        
        $data['companies'] = $this->Employee_model->get_companies();
        $data['units'] = $this->Employee_model->get_units();
        $data['title'] = 'Add New Employee';
        
        $this->load->view('templates/header', $data);
        $this->load->view('employees/add', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit($id) {
        $employee = $this->Employee_model->get_employee($id);
        
        if (!$employee) {
            show_404();
        }
        
        if ($this->input->post()) {
            // Set validation rules
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('position', 'Position', 'required');
            $this->form_validation->set_rules('unit_id', 'Unit', 'required|numeric');
            $this->form_validation->set_rules('company_id', 'Company', 'required|numeric');
            
            if ($this->form_validation->run()) {
                $employee_data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'position' => $this->input->post('position'),
                    'unit_id' => $this->input->post('unit_id'),
                    'company_id' => $this->input->post('company_id'),
                    'access_level' => $this->input->post('access_level')
                );
                
                // Only update PINs if provided
                if ($this->input->post('pin_4digit')) {
                    $employee_data['pin_4digit'] = $this->input->post('pin_4digit');
                }
                if ($this->input->post('pin_6digit')) {
                    $employee_data['pin_6digit'] = $this->input->post('pin_6digit');
                }
                
                if ($this->Employee_model->update_employee($id, $employee_data)) {
                    $this->session->set_flashdata('toast_message', 'Employee updated successfully.');
                    $this->session->set_flashdata('toast_type', 'success');
                    redirect('employees/view/' . $id);
                } else {
                    $this->session->set_flashdata('toast_message', 'Error updating employee.');
                    $this->session->set_flashdata('toast_type', 'error');
                }
            }
        }
        
        $data['employee'] = $employee;
        $data['companies'] = $this->Employee_model->get_companies();
        $data['units'] = $this->Employee_model->get_units($employee->company_id);
        $data['title'] = 'Edit Employee';
        
        $this->load->view('templates/header', $data);
        $this->load->view('employees/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function view($id) {
        $employee = $this->Employee_model->get_employee($id);
        
        if (!$employee) {
            show_404();
        }
        
        $data['employee'] = $employee;
        $data['title'] = 'Employee Details';
        
        $this->load->view('templates/header', $data);
        $this->load->view('employees/view', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete($id) {
        if ($this->input->post() && $this->input->post('confirm') === 'yes') {
            if ($this->Employee_model->delete_employee($id)) {
                // Try to set flash message if session is available
                if (class_exists('CI_Session')) {
                    $this->session->set_flashdata('toast_message', 'Employee deleted successfully.');
                    $this->session->set_flashdata('toast_type', 'success');
                }
                redirect('employees');
            } else {
                // Try to set flash message if session is available
                if (class_exists('CI_Session')) {
                    $this->session->set_flashdata('toast_message', 'Error deleting employee.');
                    $this->session->set_flashdata('toast_type', 'error');
                }
                redirect('employees');
            }
        }
        
        // If no POST data, redirect back to employees list
        redirect('employees');
    }
    
    public function block($id) {
        if ($this->input->post()) {
            $this->form_validation->set_rules('reason', 'Reason', 'required');
            
            if ($this->form_validation->run()) {
                $reason = $this->input->post('reason');
                $blocked_by = $this->session->userdata('user_id');
                $blocked_until = $this->input->post('blocked_until') ?: null;
                
                if ($this->Employee_model->block_employee($id, $reason, $blocked_by, $blocked_until)) {
                    $this->session->set_flashdata('toast_message', 'Employee access blocked successfully.');
                    $this->session->set_flashdata('toast_type', 'success');
                } else {
                    $this->session->set_flashdata('toast_message', 'Error blocking employee access.');
                    $this->session->set_flashdata('toast_type', 'error');
                }
                
                redirect('employees/view/' . $id);
            }
        }
        
        $employee = $this->Employee_model->get_employee($id);
        
        if (!$employee) {
            show_404();
        }
        
        $data['employee'] = $employee;
        $data['title'] = 'Block Employee Access';
        
        $this->load->view('templates/header', $data);
        $this->load->view('employees/block', $data);
        $this->load->view('templates/footer');
    }
    
    public function unblock($id) {
        if ($this->Employee_model->unblock_employee($id)) {
            $this->session->set_flashdata('toast_message', 'Employee access unblocked successfully.');
            $this->session->set_flashdata('toast_type', 'success');
        } else {
            $this->session->set_flashdata('toast_message', 'Error unblocking employee access.');
            $this->session->set_flashdata('toast_type', 'error');
        }
        
        redirect('employees/view/' . $id);
    }
    
    public function vacation($id) {
        if ($this->input->post()) {
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('end_date', 'End Date', 'required');
            $this->form_validation->set_rules('reason', 'Reason', 'required');
            
            if ($this->form_validation->run()) {
                $start_date = $this->input->post('start_date');
                $end_date = $this->input->post('end_date');
                $reason = $this->input->post('reason');
                
                if ($this->Employee_model->set_vacation($id, $start_date, $end_date, $reason)) {
                    $this->session->set_flashdata('toast_message', 'Vacation period set successfully.');
                    $this->session->set_flashdata('toast_type', 'success');
                } else {
                    $this->session->set_flashdata('toast_message', 'Error setting vacation period.');
                    $this->session->set_flashdata('toast_type', 'error');
                }
                
                redirect('employees/view/' . $id);
            }
        }
        
        $employee = $this->Employee_model->get_employee($id);
        
        if (!$employee) {
            show_404();
        }
        
        $data['employee'] = $employee;
        $data['title'] = 'Set Vacation Period';
        
        $this->load->view('templates/header', $data);
        $this->load->view('employees/vacation', $data);
        $this->load->view('templates/footer');
    }
    
    public function end_vacation($id) {
        if ($this->Employee_model->end_vacation($id)) {
            $this->session->set_flashdata('toast_message', 'Vacation ended successfully.');
            $this->session->set_flashdata('toast_type', 'success');
        } else {
            $this->session->set_flashdata('toast_message', 'Error ending vacation.');
            $this->session->set_flashdata('toast_type', 'error');
        }
        
        redirect('employees/view/' . $id);
    }
    
    // AJAX method to get units by company
    public function get_units_by_company() {
        $company_id = $this->input->post('company_id');
        $units = $this->Employee_model->get_units_by_company($company_id);
        
        header('Content-Type: application/json');
        echo json_encode($units);
    }
    
    // AJAX method to get delete modal content
    public function get_delete_modal($id) {
        $employee = $this->Employee_model->get_employee($id);
        
        if (!$employee) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Employee not found']);
            return;
        }
        
        $data['employee'] = $employee;
        
        // Return the modal HTML content
        $this->load->view('employees/delete_modal', $data);
    }
    
    // AJAX method to get block modal content
    public function get_block_modal($id) {
        $employee = $this->Employee_model->get_employee($id);
        
        if (!$employee) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Employee not found']);
            return;
        }
        
        $data['employee'] = $employee;
        
        // Return the modal HTML content
        $this->load->view('employees/block_modal', $data);
    }
} 