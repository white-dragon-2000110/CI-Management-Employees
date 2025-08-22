<?php
// Test database connection and employee portal functionality
require_once 'application/config/database.php';
require_once 'application/config/config.php';

echo "<h1>Database Connection Test</h1>";

// Test database connection
try {
    $mysqli = new mysqli(
        $db['default']['hostname'],
        $db['default']['username'],
        $db['default']['password'],
        $db['default']['database']
    );
    
    if ($mysqli->connect_error) {
        echo "<p style='color: red;'>Database connection failed: " . $mysqli->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>Database connection successful!</p>";
        
        // Test if employees table exists
        $result = $mysqli->query("SHOW TABLES LIKE 'employees'");
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>Employees table exists</p>";
            
            // Test if photo_path column exists
            $result = $mysqli->query("SHOW COLUMNS FROM employees LIKE 'photo_path'");
            if ($result->num_rows > 0) {
                echo "<p style='color: green;'>photo_path column exists</p>";
            } else {
                echo "<p style='color: red;'>photo_path column does not exist</p>";
            }
            
            // Test if pin columns exist
            $result = $mysqli->query("SHOW COLUMNS FROM employees LIKE 'pin_4digit'");
            if ($result->num_rows > 0) {
                echo "<p style='color: green;'>pin_4digit column exists</p>";
            } else {
                echo "<p style='color: red;'>pin_4digit column does not exist</p>";
            }
            
            $result = $mysqli->query("SHOW COLUMNS FROM employees LIKE 'pin_6digit'");
            if ($result->num_rows > 0) {
                echo "<p style='color: green;'>pin_6digit column exists</p>";
            } else {
                echo "<p style='color: red;'>pin_6digit column does not exist</p>";
            }
            
            // Test if phone column exists
            $result = $mysqli->query("SHOW COLUMNS FROM employees LIKE 'phone'");
            if ($result->num_rows > 0) {
                echo "<p style='color: green;'>phone column exists</p>";
            } else {
                echo "<p style='color: red;'>phone column does not exist</p>";
            }
            
        } else {
            echo "<p style='color: red;'>Employees table does not exist</p>";
        }
        
        // Test uploads directory
        $upload_dir = 'uploads/employee_photos/';
        if (is_dir($upload_dir)) {
            echo "<p style='color: green;'>Uploads directory exists</p>";
            if (is_writable($upload_dir)) {
                echo "<p style='color: green;'>Uploads directory is writable</p>";
            } else {
                echo "<p style='color: red;'>Uploads directory is not writable</p>";
            }
        } else {
            echo "<p style='color: red;'>Uploads directory does not exist</p>";
        }
        
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Employee Portal Routes</h2>";
echo "<p><a href='/employee_portal'>Employee Portal Login</a></p>";
echo "<p><a href='/employee_portal/profile'>Employee Profile (requires login)</a></p>";
echo "<p><a href='/employee_portal/update_profile'>Update Profile (requires login)</a></p>";
echo "<p><a href='/employee_portal/capture_photo'>Capture Photo (requires login)</a></p>";

echo "<h2>System Information</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>CodeIgniter Version: 3.x</p>";
echo "<p>Current Directory: " . getcwd() . "</p>";
echo "<p>Upload Max Filesize: " . ini_get('upload_max_filesize') . "</p>";
echo "<p>Post Max Size: " . ini_get('post_max_size') . "</p>";
echo "<p>Memory Limit: " . ini_get('memory_limit') . "</p>";
?> 