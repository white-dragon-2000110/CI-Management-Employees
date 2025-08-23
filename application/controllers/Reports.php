<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load required libraries and models
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Report_model');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['title'] = 'Painel de Relatórios';
        $data['alarm_stats'] = $this->Report_model->get_alarm_stats();
        $data['ticket_stats'] = $this->Report_model->get_ticket_stats();
        
        $this->load->view('templates/header', $data);
        $this->load->view('reports/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function alarms() {
        $filters = array();
        
        // Get filter parameters
        if ($this->input->get('start_date')) {
            $filters['start_date'] = $this->input->get('start_date');
        }
        if ($this->input->get('end_date')) {
            $filters['end_date'] = $this->input->get('end_date');
        }
        if ($this->input->get('company_id')) {
            $filters['company_id'] = $this->input->get('company_id');
        }
        if ($this->input->get('unit_id')) {
            $filters['unit_id'] = $this->input->get('unit_id');
        }
        if ($this->input->get('event_type')) {
            $filters['event_type'] = $this->input->get('event_type');
        }
        if ($this->input->get('severity')) {
            $filters['severity'] = $this->input->get('severity');
        }
        if ($this->input->get('status')) {
            $filters['status'] = $this->input->get('status');
        }
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }
        
        $data['alarms'] = $this->Report_model->get_alarm_events($filters);
        $data['stats'] = $this->Report_model->get_alarm_stats($filters);
        $data['companies'] = $this->Report_model->get_companies();
        $data['units'] = $this->Report_model->get_units();
        $data['filters'] = $filters;
        $data['title'] = 'Alarm Events Report';
        
        // Handle export
        if ($this->input->get('export') === 'csv') {
            $this->export_alarms_csv($data['alarms']);
            return;
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('reports/alarms', $data);
        $this->load->view('templates/footer');
    }
    
    public function tickets() {
        $filters = array();
        
        // Get filter parameters
        if ($this->input->get('start_date')) {
            $filters['start_date'] = $this->input->get('start_date');
        }
        if ($this->input->get('end_date')) {
            $filters['end_date'] = $this->input->get('end_date');
        }
        if ($this->input->get('company_id')) {
            $filters['company_id'] = $this->input->get('company_id');
        }
        if ($this->input->get('unit_id')) {
            $filters['unit_id'] = $this->input->get('unit_id');
        }
        if ($this->input->get('priority')) {
            $filters['priority'] = $this->input->get('priority');
        }
        if ($this->input->get('status')) {
            $filters['status'] = $this->input->get('status');
        }
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }
        
        $data['tickets'] = $this->Report_model->get_support_tickets($filters);
        $data['stats'] = $this->Report_model->get_ticket_stats($filters);
        $data['companies'] = $this->Report_model->get_companies();
        $data['units'] = $this->Report_model->get_units();
        $data['filters'] = $filters;
        $data['title'] = 'Support Tickets Report';
        
        // Handle export
        if ($this->input->get('export') === 'csv') {
            $this->export_tickets_csv($data['tickets']);
            return;
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('reports/tickets', $data);
        $this->load->view('templates/footer');
    }
    
    private function export_alarms_csv($alarms) {
        $filename = 'alarm_events_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Create CSV content
        $csv = $this->Report_model->export_to_csv($alarms, $filename);
        
        // Output CSV
        echo $csv;
        exit;
    }
    
    private function export_tickets_csv($tickets) {
        $filename = 'support_tickets_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Create CSV content
        $csv = $this->Report_model->export_to_csv($tickets, $filename);
        
        // Output CSV
        echo $csv;
        exit;
    }
    
    // AJAX method to get units by company
    public function get_units_by_company() {
        $company_id = $this->input->post('company_id');
        $units = $this->Report_model->get_units($company_id);
        
        header('Content-Type: application/json');
        echo json_encode($units);
    }
} 