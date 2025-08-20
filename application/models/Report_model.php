<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get alarm events with filters
    public function get_alarm_events($filters = array()) {
        $this->db->select('ae.*, u.name as unit_name, c.name as company_name');
        $this->db->from('alarm_events ae');
        $this->db->join('units u', 'u.id = ae.unit_id');
        $this->db->join('companies c', 'c.id = ae.company_id');
        
        // Apply filters
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(ae.created_at) >=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(ae.created_at) <=', $filters['end_date']);
        }
        
        if (!empty($filters['company_id'])) {
            $this->db->where('ae.company_id', $filters['company_id']);
        }
        
        if (!empty($filters['unit_id'])) {
            $this->db->where('ae.unit_id', $filters['unit_id']);
        }
        
        if (!empty($filters['event_type'])) {
            $this->db->where('ae.event_type', $filters['event_type']);
        }
        
        if (!empty($filters['severity'])) {
            $this->db->where('ae.severity', $filters['severity']);
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('ae.status', $filters['status']);
        }
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('ae.description', $filters['search']);
            $this->db->or_like('ae.event_type', $filters['search']);
            $this->db->group_end();
        }
        
        $this->db->order_by('ae.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get support tickets with filters
    public function get_support_tickets($filters = array()) {
        $this->db->select('st.*, u.name as unit_name, c.name as company_name');
        $this->db->from('support_tickets st');
        $this->db->join('units u', 'u.id = st.unit_id');
        $this->db->join('companies c', 'c.id = st.company_id');
        
        // Apply filters
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(st.created_at) >=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(st.created_at) <=', $filters['end_date']);
        }
        
        if (!empty($filters['company_id'])) {
            $this->db->where('st.company_id', $filters['company_id']);
        }
        
        if (!empty($filters['unit_id'])) {
            $this->db->where('st.unit_id', $filters['unit_id']);
        }
        
        if (!empty($filters['priority'])) {
            $this->db->where('st.priority', $filters['priority']);
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('st.status', $filters['status']);
        }
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('st.title', $filters['search']);
            $this->db->or_like('st.description', $filters['search']);
            $this->db->group_end();
        }
        
        $this->db->order_by('st.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get alarm statistics
    public function get_alarm_stats($filters = array()) {
        $stats = array();
        
        // Total alarms
        $this->db->select('COUNT(*) as total');
        $this->apply_alarm_filters($filters);
        $query = $this->db->get('alarm_events');
        $stats['total'] = $query->row()->total;
        
        // Alarms by severity
        $this->db->select('severity, COUNT(*) as count');
        $this->apply_alarm_filters($filters);
        $this->db->group_by('severity');
        $query = $this->db->get('alarm_events');
        $stats['by_severity'] = $query->result();
        
        // Alarms by status
        $this->db->select('status, COUNT(*) as count');
        $this->apply_alarm_filters($filters);
        $this->db->group_by('status');
        $query = $this->db->get('alarm_events');
        $stats['by_status'] = $query->result();
        
        // Alarms by event type
        $this->db->select('event_type, COUNT(*) as count');
        $this->apply_alarm_filters($filters);
        $this->db->group_by('event_type');
        $query = $this->db->get('alarm_events');
        $stats['by_type'] = $query->result();
        
        return $stats;
    }

    // Get ticket statistics
    public function get_ticket_stats($filters = array()) {
        $stats = array();
        
        // Total tickets
        $this->db->select('COUNT(*) as total');
        $this->apply_ticket_filters($filters);
        $query = $this->db->get('support_tickets');
        $stats['total'] = $query->row()->total;
        
        // Tickets by priority
        $this->db->select('priority, COUNT(*) as count');
        $this->apply_ticket_filters($filters);
        $this->db->group_by('priority');
        $query = $this->db->get('support_tickets');
        $stats['by_priority'] = $query->result();
        
        // Tickets by status
        $this->db->select('status, COUNT(*) as count');
        $this->apply_ticket_filters($filters);
        $this->db->group_by('status');
        $query = $this->db->get('support_tickets');
        $stats['by_status'] = $query->result();
        
        // Average resolution time
        $this->db->select('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_resolution_hours');
        $this->apply_ticket_filters($filters);
        $this->db->where('resolved_at IS NOT NULL');
        $query = $this->db->get('support_tickets');
        $stats['avg_resolution_hours'] = round($query->row()->avg_resolution_hours, 2);
        
        return $stats;
    }

    // Apply alarm filters (helper method)
    private function apply_alarm_filters($filters) {
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(created_at) >=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(created_at) <=', $filters['end_date']);
        }
        
        if (!empty($filters['company_id'])) {
            $this->db->where('company_id', $filters['company_id']);
        }
        
        if (!empty($filters['unit_id'])) {
            $this->db->where('unit_id', $filters['unit_id']);
        }
    }

    // Apply ticket filters (helper method)
    private function apply_ticket_filters($filters) {
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(created_at) >=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(created_at) <=', $filters['end_date']);
        }
        
        if (!empty($filters['company_id'])) {
            $this->db->where('company_id', $filters['company_id']);
        }
        
        if (!empty($filters['unit_id'])) {
            $this->db->where('unit_id', $filters['unit_id']);
        }
    }

    // Export data to CSV
    public function export_to_csv($data, $filename) {
        if (empty($data)) {
            return '';
        }
        
        // Get headers from first row
        $headers = array_keys((array) $data[0]);
        
        // Create CSV content
        $csv = '';
        
        // Add headers
        $csv .= implode(',', $headers) . "\n";
        
        // Add data rows
        foreach ($data as $row) {
            $row_array = (array) $row;
            $csv_row = array();
            
            foreach ($headers as $header) {
                $value = isset($row_array[$header]) ? $row_array[$header] : '';
                // Escape commas and quotes
                $value = str_replace('"', '""', $value);
                $csv_row[] = '"' . $value . '"';
            }
            
            $csv .= implode(',', $csv_row) . "\n";
        }
        
        return $csv;
    }

    // Get companies for filter dropdowns
    public function get_companies() {
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('companies');
        return $query->result();
    }

    // Get units for filter dropdowns
    public function get_units($company_id = null) {
        if ($company_id) {
            $this->db->where('company_id', $company_id);
        }
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('units');
        return $query->result();
    }
} 