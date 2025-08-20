<?php
$conn = new mysqli('localhost', 'root', '', 'employee_management');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Checking and fixing database structure...\n\n";

// Check if support_tickets table has the subject field
$result = $conn->query("DESCRIBE support_tickets");
$has_subject = false;
while ($row = $result->fetch_assoc()) {
    if ($row['Field'] === 'subject') {
        $has_subject = true;
        break;
    }
}

if (!$has_subject) {
    echo "Adding missing 'subject' field to support_tickets table...\n";
    $conn->query("ALTER TABLE support_tickets ADD COLUMN subject VARCHAR(255) NOT NULL AFTER ticket_number");
    echo "Subject field added successfully!\n";
}

// Check if alarm_events table has all required fields
$result = $conn->query("DESCRIBE alarm_events");
$has_event_date = false;
while ($row = $result->fetch_assoc()) {
    if ($row['Field'] === 'event_date') {
        $has_event_date = true;
        break;
    }
}

if (!$has_event_date) {
    echo "Adding missing 'event_date' field to alarm_events table...\n";
    $conn->query("ALTER TABLE alarm_events ADD COLUMN event_date DATETIME NOT NULL AFTER status");
    echo "Event date field added successfully!\n";
}

// Update existing support tickets with subject data
echo "Updating support tickets with subject data...\n";
$conn->query("UPDATE support_tickets SET subject = 'Email System Access Issue' WHERE id = 1");
$conn->query("UPDATE support_tickets SET subject = 'Printer Network Problem' WHERE id = 2");
$conn->query("UPDATE support_tickets SET subject = 'Software License Renewal' WHERE id = 3");

// Update existing alarm events with proper data
echo "Updating alarm events with proper data...\n";
$conn->query("UPDATE alarm_events SET event_date = '2024-01-15 14:30:00', severity = 'high', status = 'resolved' WHERE id = 1");
$conn->query("UPDATE alarm_events SET event_date = '2024-01-16 09:15:00', severity = 'critical', status = 'resolved' WHERE id = 2");
$conn->query("UPDATE alarm_events SET event_date = '2024-01-17 11:00:00', severity = 'medium', status = 'open' WHERE id = 3");

echo "Database structure fixed successfully!\n";

$conn->close();
?> 