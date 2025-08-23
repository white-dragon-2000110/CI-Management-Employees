<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $this->load->model('Employee_model');
        $this->load->model('Report_model');
        
        $data['title'] = 'Painel de Controle';
        $data['employee_stats'] = $this->Employee_model->get_employee_stats();
        $data['alarm_stats'] = $this->Report_model->get_alarm_stats();
        $data['ticket_stats'] = $this->Report_model->get_ticket_stats();
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
} 