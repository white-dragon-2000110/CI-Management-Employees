<?php
// Simple database connection
$conn = new mysqli('localhost', 'root', '', 'employee_management');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to database successfully!\n";

// Clear existing data (in reverse order due to foreign key constraints)
echo "Clearing existing data...\n";

$conn->query("DELETE FROM support_tickets");
$conn->query("DELETE FROM alarm_events");
$conn->query("DELETE FROM access_blocks");
$conn->query("DELETE FROM vacation_periods");
$conn->query("DELETE FROM employees");
$conn->query("DELETE FROM units");
$conn->query("DELETE FROM companies");

echo "Database cleared successfully!\n";

// Reset auto-increment counters
$conn->query("ALTER TABLE companies AUTO_INCREMENT = 1");
$conn->query("ALTER TABLE units AUTO_INCREMENT = 1");
$conn->query("ALTER TABLE employees AUTO_INCREMENT = 1");
$conn->query("ALTER TABLE alarm_events AUTO_INCREMENT = 1");
$conn->query("ALTER TABLE support_tickets AUTO_INCREMENT = 1");

echo "Auto-increment counters reset!\n\n";

// Insert sample companies
$companies = [
    ['name' => 'TechCorp Solutions', 'status' => 'active'],
    ['name' => 'Global Industries', 'status' => 'active'],
    ['name' => 'Innovation Labs', 'status' => 'active']
];

foreach ($companies as $company) {
    $sql = "INSERT INTO companies (name, status) VALUES ('{$company['name']}', '{$company['status']}')";
    if ($conn->query($sql) === TRUE) {
        echo "Company '{$company['name']}' inserted successfully\n";
    } else {
        echo "Error inserting company: " . $conn->error . "\n";
    }
}

// Insert sample units
$units = [
    ['name' => 'IT Department', 'company_id' => 1, 'status' => 'active'],
    ['name' => 'HR Department', 'company_id' => 1, 'status' => 'active'],
    ['name' => 'Finance Department', 'company_id' => 1, 'status' => 'active'],
    ['name' => 'Operations', 'company_id' => 2, 'status' => 'active'],
    ['name' => 'Research & Development', 'company_id' => 3, 'status' => 'active']
];

foreach ($units as $unit) {
    $sql = "INSERT INTO units (name, company_id, status) VALUES ('{$unit['name']}', {$unit['company_id']}, '{$unit['status']}')";
    if ($conn->query($sql) === TRUE) {
        echo "Unit '{$unit['name']}' inserted successfully\n";
    } else {
        echo "Error inserting unit: " . $conn->error . "\n";
    }
}

// Insert sample employees
$employees = [
    [
        'name' => 'John Doe',
        'cpf' => '123.456.789-01',
        'email' => 'john.doe@techcorp.com',
        'phone' => '+55 11 99999-9999',
        'position' => 'Senior Developer',
        'unit_id' => 1,
        'company_id' => 1,
        'access_level' => 'admin',
        'pin_4digit' => password_hash('1234', PASSWORD_DEFAULT),
        'pin_6digit' => password_hash('123456', PASSWORD_DEFAULT),
        'status' => 'active'
    ],
    [
        'name' => 'Jane Smith',
        'cpf' => '987.654.321-09',
        'email' => 'jane.smith@techcorp.com',
        'phone' => '+55 11 88888-8888',
        'position' => 'HR Manager',
        'unit_id' => 2,
        'company_id' => 1,
        'access_level' => 'standard',
        'pin_4digit' => password_hash('5678', PASSWORD_DEFAULT),
        'pin_6digit' => password_hash('567890', PASSWORD_DEFAULT),
        'status' => 'active'
    ],
    [
        'name' => 'Bob Johnson',
        'cpf' => '456.789.123-45',
        'email' => 'bob.johnson@global.com',
        'phone' => '+55 11 77777-7777',
        'position' => 'Operations Director',
        'unit_id' => 4,
        'company_id' => 2,
        'access_level' => 'standard',
        'pin_4digit' => password_hash('9012', PASSWORD_DEFAULT),
        'pin_6digit' => password_hash('901234', PASSWORD_DEFAULT),
        'status' => 'active'
    ]
];

foreach ($employees as $employee) {
    $sql = "INSERT INTO employees (name, cpf, email, phone, position, unit_id, company_id, access_level, pin_4digit, pin_6digit, status) 
            VALUES ('{$employee['name']}', '{$employee['cpf']}', '{$employee['email']}', '{$employee['phone']}', '{$employee['position']}', 
                    {$employee['unit_id']}, {$employee['company_id']}, '{$employee['access_level']}', '{$employee['pin_4digit']}', 
                    '{$employee['pin_6digit']}', '{$employee['status']}')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Employee '{$employee['name']}' inserted successfully\n";
    } else {
        echo "Error inserting employee: " . $conn->error . "\n";
    }
}

// Insert sample alarm events
$alarms = [
    [
        'event_type' => 'security_breach',
        'description' => 'Unauthorized access attempt detected',
        'details' => 'Multiple failed login attempts from suspicious IP',
        'location' => 'Main Server Room',
        'unit_id' => 1,
        'company_id' => 1,
        'severity' => 'high',
        'status' => 'resolved',
        'event_date' => '2024-01-15 14:30:00',
        'response_time_hours' => 2
    ],
    [
        'event_type' => 'system_failure',
        'description' => 'Database connection timeout',
        'details' => 'Primary database server unresponsive',
        'location' => 'Data Center',
        'unit_id' => 1,
        'company_id' => 1,
        'severity' => 'critical',
        'status' => 'resolved',
        'event_date' => '2024-01-16 09:15:00',
        'response_time_hours' => 1
    ],
    [
        'event_type' => 'maintenance',
        'description' => 'Scheduled system maintenance',
        'details' => 'Regular backup and optimization',
        'location' => 'All Systems',
        'unit_id' => 1,
        'company_id' => 1,
        'severity' => 'low',
        'status' => 'closed',
        'event_date' => '2024-01-17 02:00:00',
        'response_time_hours' => 0
    ]
];

foreach ($alarms as $alarm) {
    $sql = "INSERT INTO alarm_events (event_type, description, details, location, unit_id, company_id, severity, status, event_date, response_time_hours) 
            VALUES ('{$alarm['event_type']}', '{$alarm['description']}', '{$alarm['details']}', '{$alarm['location']}', 
                    {$alarm['unit_id']}, {$alarm['company_id']}, '{$alarm['severity']}', '{$alarm['status']}', 
                    '{$alarm['event_date']}', {$alarm['response_time_hours']})";
    
    if ($conn->query($sql) === TRUE) {
        echo "Alarm event '{$alarm['description']}' inserted successfully\n";
    } else {
        echo "Error inserting alarm: " . $conn->error . "\n";
    }
}

// Insert sample support tickets
$tickets = [
    [
        'ticket_number' => 'TKT-001',
        'subject' => 'Cannot access email system',
        'description' => 'User reports being unable to access Outlook',
        'customer_name' => 'John Doe',
        'unit_id' => 1,
        'company_id' => 1,
        'priority' => 'high',
        'status' => 'resolved',
        'created_at' => '2024-01-15 10:00:00',
        'resolution_time_hours' => 4
    ],
    [
        'ticket_number' => 'TKT-002',
        'subject' => 'Printer not working',
        'description' => 'Network printer showing offline status',
        'customer_name' => 'Jane Smith',
        'unit_id' => 2,
        'company_id' => 1,
        'priority' => 'medium',
        'status' => 'in_progress',
        'created_at' => '2024-01-16 14:30:00',
        'resolution_time_hours' => null
    ],
    [
        'ticket_number' => 'TKT-003',
        'subject' => 'Software license renewal',
        'description' => 'Need to renew Adobe Creative Suite licenses',
        'customer_name' => 'Bob Johnson',
        'unit_id' => 4,
        'company_id' => 2,
        'priority' => 'low',
        'status' => 'open',
        'created_at' => '2024-01-17 11:45:00',
        'resolution_time_hours' => null
    ]
];

foreach ($tickets as $ticket) {
    $resolution_time = $ticket['resolution_time_hours'] ? $ticket['resolution_time_hours'] : 'NULL';
    $sql = "INSERT INTO support_tickets (ticket_number, subject, description, customer_name, unit_id, company_id, priority, status, created_at, resolution_time_hours) 
            VALUES ('{$ticket['ticket_number']}', '{$ticket['subject']}', '{$ticket['description']}', '{$ticket['customer_name']}', 
                    {$ticket['unit_id']}, {$ticket['company_id']}, '{$ticket['priority']}', '{$ticket['status']}', 
                    '{$ticket['created_at']}', {$resolution_time})";
    
    if ($conn->query($sql) === TRUE) {
        echo "Support ticket '{$ticket['subject']}' inserted successfully\n";
    } else {
        echo "Error inserting ticket: " . $conn->error . "\n";
    }
}

echo "\nSample data inserted successfully!\n";
echo "You can now test the system with:\n";
echo "- Employee login: CPF: 123.456.789-01, PINs: 1234 and 123456\n";
echo "- Employee login: CPF: 987.654.321-09, PINs: 5678 and 567890\n";
echo "- Employee login: CPF: 456.789.123-45, PINs: 9012 and 901234\n";

$conn->close();
?> 