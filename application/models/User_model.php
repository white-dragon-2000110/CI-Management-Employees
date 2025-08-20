<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get user by email
    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }
    
    // Create new user
    public function create_user($user_data) {
        // Always hash the password - don't check if it's already hashed
        if (isset($user_data['password'])) {
            $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);
        }
        
        $user_data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('users', $user_data);
        return $this->db->insert_id();
    }
    
    // Check if email exists
    public function email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
    
    // Authenticate user (login)
    public function authenticate_user($email, $password) {
        $user = $this->get_user_by_email($email);
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        
        return false;
    }
    
    // Get user by ID
    public function get_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }
    
    // Update user
    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
    
    // Delete user
    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
} 