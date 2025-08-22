<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .profile-container {
            min-height: 100vh;
            padding: 40px 0;
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        .profile-header {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .profile-body {
            padding: 40px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }
        .info-value {
            color: #6c757d;
        }
        .btn-portal {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-portal:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
            color: white;
        }
        .btn-secondary-portal {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-secondary-portal:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(149, 165, 166, 0.4);
            color: white;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }
        .status-active { background: #d4edda; color: #155724; }
        .status-vacation { background: #fff3cd; color: #856404; }
        .status-blocked { background: #f8d7da; color: #721c24; }
        .status-inactive { background: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="profile-card">
                        <div class="profile-header">
                            <h1><i class="fas fa-user-circle me-3"></i>Employee Profile</h1>
                            <p class="mb-0">Welcome to your secure employee portal</p>
                        </div>
                        
                        <div class="profile-body">
                            <!-- Flash Messages -->
                            <?php if ($this->session->flashdata('toast_message')): ?>
                                <div class="alert alert-<?php echo $this->session->flashdata('toast_type') === 'error' ? 'danger' : ($this->session->flashdata('toast_type') === 'warning' ? 'warning' : 'success'); ?> alert-dismissible fade show" role="alert">
                                    <i class="fas fa-<?php echo $this->session->flashdata('toast_type') === 'error' ? 'exclamation-triangle' : ($this->session->flashdata('toast_type') === 'warning' ? 'exclamation-triangle' : 'check-circle'); ?> me-2"></i>
                                    <?php echo $this->session->flashdata('toast_message'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Employee Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span class="info-label">Full Name:</span>
                                        <span class="info-value"><?php echo $employee->name; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">CPF:</span>
                                        <span class="info-value"><?php echo $employee->cpf; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Email:</span>
                                        <span class="info-value"><?php echo $employee->email; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Phone:</span>
                                        <span class="info-value"><?php echo $employee->phone; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-row">
                                        <span class="info-label">Position:</span>
                                        <span class="info-value"><?php echo $employee->position; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Unit:</span>
                                        <span class="info-value"><?php echo $employee->unit_name; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Company:</span>
                                        <span class="info-value"><?php echo $employee->company_name; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Status:</span>
                                        <span class="status-badge status-<?php echo $employee->status; ?>">
                                            <?php echo ucfirst($employee->status); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Access Level -->
                            <div class="text-center mb-4">
                                <div class="alert alert-info">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    <strong>Access Level:</strong> <?php echo ucfirst($employee->access_level); ?>
                                </div>
                            </div>
                            
                            <!-- Portal Actions -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <a href="/employee_portal/update_profile" class="btn-portal w-100 text-center">
                                        <i class="fas fa-edit me-2"></i>Update Profile
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="/employee_portal/capture_photo" class="btn-portal w-100 text-center">
                                        <i class="fas fa-camera me-2"></i>Update Photo
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Photo Section -->
                            <?php if ($employee->photo_path): ?>
                                <div class="text-center mb-4">
                                    <h5><i class="fas fa-camera me-2"></i>Current Photo</h5>
                                    <img src="/<?php echo $employee->photo_path; ?>" 
                                         alt="Employee Photo" 
                                         class="img-fluid rounded" 
                                         style="max-width: 200px; border: 3px solid #3498db;">
                                </div>
                            <?php else: ?>
                                <div class="text-center mb-4">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No photo uploaded yet. Please capture a photo for security verification.
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Logout -->
                            <div class="text-center">
                                <a href="/employee_portal/logout" class="btn-secondary-portal">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 