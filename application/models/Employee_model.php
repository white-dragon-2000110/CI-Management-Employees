<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all employees with filters
    public function get_employees($filters = array()) {
        $this->db->select('e.*, u.name as unit_name, c.name as company_name');
        $this->db->from('employees e');
        $this->db->join('units u', 'u.id = e.unit_id');
        $this->db->join('companies c', 'c.id = e.company_id');
        
        // Apply filters
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('e.name', $filters['search']);
            $this->db->or_like('e.email', $filters['search']);
            $this->db->or_like('e.cpf', $filters['search']);
            $this->db->or_like('e.position', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('e.status', $filters['status']);
        }
        
        if (!empty($filters['unit_id'])) {
            $this->db->where('e.unit_id', $filters['unit_id']);
        }
        
        if (!empty($filters['company_id'])) {
            $this->db->where('e.company_id', $filters['company_id']);
        }
        
        $this->db->order_by('e.name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get single employee by ID
    public function get_employee($id) {
        $this->db->select('e.*, u.name as unit_name, c.name as company_name');
        $this->db->from('employees e');
        $this->db->join('units u', 'u.id = e.unit_id');
        $this->db->join('companies c', 'c.id = e.company_id');
        $this->db->where('e.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Get employee by CPF
    public function get_employee_by_cpf($cpf) {
        $this->db->where('cpf', $cpf);
        $query = $this->db->get('employees');
        return $query->row();
    }

    // Get employee by email
    public function get_employee_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('employees');
        return $query->row();
    }

    // Create new employee
    public function create_employee($data) {
        // Hash PINs for security
        $data['pin_4digit'] = password_hash($data['pin_4digit'], PASSWORD_DEFAULT);
        $data['pin_6digit'] = password_hash($data['pin_6digit'], PASSWORD_DEFAULT);
        
        $this->db->insert('employees', $data);
        return $this->db->insert_id();
    }

    // Update employee
    public function update_employee($id, $data) {
        // Hash PINs if they're being updated
        if (isset($data['pin_4digit']) && !empty($data['pin_4digit'])) {
            $data['pin_4digit'] = password_hash($data['pin_4digit'], PASSWORD_DEFAULT);
        }
        if (isset($data['pin_6digit']) && !empty($data['pin_6digit'])) {
            $data['pin_6digit'] = password_hash($data['pin_6digit'], PASSWORD_DEFAULT);
        }
        
        $this->db->where('id', $id);
        return $this->db->update('employees', $data);
    }

    // Delete employee
    public function delete_employee($id) {
        $this->db->where('id', $id);
        return $this->db->delete('employees');
    }

    // Block employee access
    public function block_employee($id, $reason, $blocked_by, $blocked_until = null) {
        $data = array(
            'employee_id' => $id,
            'reason' => $reason,
            'blocked_by' => $blocked_by,
            'blocked_until' => $blocked_until,
            'status' => 'active'
        );
        
        // Update employee status to blocked
        $this->db->where('id', $id);
        $this->db->update('employees', array('status' => 'blocked'));
        
        // Insert access block record
        return $this->db->insert('access_blocks', $data);
    }

    // Unblock employee access
    public function unblock_employee($id) {
        // Update employee status to active
        $this->db->where('id', $id);
        $this->db->update('employees', array('status' => 'active'));
        
        // Update access block status
        $this->db->where('employee_id', $id);
        $this->db->where('status', 'active');
        return $this->db->update('access_blocks', array('status' => 'removed'));
    }

    // Set employee on vacation
    public function set_vacation($id, $start_date, $end_date, $reason) {
        $data = array(
            'employee_id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'reason' => $reason,
            'status' => 'pending'
        );
        
        // Update employee status to vacation
        $this->db->where('id', $id);
        $this->db->update('employees', array('status' => 'vacation'));
        
        // Insert vacation period record
        return $this->db->insert('vacation_periods', $data);
    }

    // End vacation
    public function end_vacation($id) {
        // Update employee status to active
        $this->db->where('id', $id);
        $this->db->update('employees', array('status' => 'active'));
        
        // Update vacation period status
        $this->db->where('employee_id', $id);
        $this->db->where('status', 'approved');
        return $this->db->update('vacation_periods', array('status' => 'closed'));
    }

    // Authenticate employee with CPF and PINs
    public function authenticate_employee($cpf, $pin_4digit, $pin_6digit) {
        $employee = $this->get_employee_by_cpf($cpf);
        
        if ($employee && 
            password_verify($pin_4digit, $employee->pin_4digit) && 
            password_verify($pin_6digit, $employee->pin_6digit)) {
            return $employee;
        }
        
        return false;
    }

    // Get employee statistics
    public function get_employee_stats() {
        $stats = array();
        
        // Total employees
        $this->db->select('COUNT(*) as total');
        $query = $this->db->get('employees');
        $stats['total'] = $query->row()->total;
        
        // Active employees
        $this->db->select('COUNT(*) as active');
        $this->db->where('status', 'active');
        $query = $this->db->get('employees');
        $stats['active'] = $query->row()->active;
        
        // Employees on vacation
        $this->db->select('COUNT(*) as vacation');
        $this->db->where('status', 'vacation');
        $query = $this->db->get('employees');
        $stats['vacation'] = $query->row()->vacation;
        
        // Blocked employees
        $this->db->select('COUNT(*) as blocked');
        $this->db->where('status', 'blocked');
        $query = $this->db->get('employees');
        $stats['blocked'] = $query->row()->blocked;
        
        // Inactive employees
        $this->db->select('COUNT(*) as inactive');
        $this->db->where('status', 'inactive');
        $query = $this->db->get('employees');
        $stats['inactive'] = $query->row()->inactive;
        
        return $stats;
    }

    // Get all companies
    public function get_companies() {
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('companies');
        return $query->result();
    }

    // Get units by company
    public function get_units_by_company($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('units');
        return $query->result();
    }

    // Get all units (for dropdowns)
    public function get_units($company_id = null) {
        if ($company_id) {
            $this->db->where('company_id', $company_id);
        }
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('units');
        return $query->result();
    }

    // Update employee photo
    public function update_photo($id, $photo_path) {
        $this->db->where('id', $id);
        return $this->db->update('employees', array('photo_path' => $photo_path));
    }
} 