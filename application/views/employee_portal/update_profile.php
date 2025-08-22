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
        .update-container {
            min-height: 100vh;
            padding: 40px 0;
        }
        .update-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        .update-header {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .update-body {
            padding: 40px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-update {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
            color: white;
        }
        .btn-back {
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
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(149, 165, 166, 0.4);
            color: white;
        }
        .current-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }
        .info-value {
            color: #6c757d;
        }
        .pin-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="update-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="update-card">
                        <div class="update-header">
                            <h1><i class="fas fa-edit me-3"></i>Update Profile</h1>
                            <p class="mb-0">Update your personal information and security credentials</p>
                        </div>
                        
                        <div class="update-body">
                            <!-- Current Information Display -->
                            <div class="current-info">
                                <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Current Information</h5>
                                <div class="info-item">
                                    <span class="info-label">Full Name:</span>
                                    <span class="info-value"><?php echo $employee->name; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">CPF:</span>
                                    <span class="info-value"><?php echo $employee->cpf; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value"><?php echo $employee->email; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Position:</span>
                                    <span class="info-value"><?php echo $employee->position; ?></span>
                                </div>
                            </div>

                            <!-- Update Form -->
                            <?php if (isset($validation_errors) && $validation_errors): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Please fix the following errors:</strong>
                                    <?php echo $validation_errors; ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-2"></i>Phone Number
                                    </label>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           value="<?php echo $employee->phone; ?>" 
                                           required>
                                </div>

                                <div class="pin-note">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Note:</strong> PINs are optional. Only fill both fields if you want to change them.
                                </div>

                                <div class="form-group">
                                    <label for="pin_4digit" class="form-label">
                                        <i class="fas fa-key me-2"></i>4-Digit PIN (Optional)
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="pin_4digit" 
                                           name="pin_4digit" 
                                           maxlength="4" 
                                           pattern="[0-9]{4}"
                                           placeholder="Enter 4-digit PIN">
                                </div>

                                <div class="form-group">
                                    <label for="pin_6digit" class="form-label">
                                        <i class="fas fa-key me-2"></i>6-Digit PIN (Optional)
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="pin_6digit" 
                                           name="pin_6digit" 
                                           maxlength="6" 
                                           pattern="[0-9]{6}"
                                           placeholder="Enter 6-digit PIN">
                                </div>

                                <!-- Action Buttons -->
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <button type="submit" class="btn-update w-100">
                                            <i class="fas fa-save me-2"></i>Update Profile
                                        </button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="/employee_portal/profile" class="btn-back w-100 text-center">
                                            <i class="fas fa-arrow-left me-2"></i>Back to Profile
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // PIN validation
        document.getElementById('pin_4digit').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        document.getElementById('pin_6digit').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const pin4 = document.getElementById('pin_4digit').value;
            const pin6 = document.getElementById('pin_6digit').value;
            
            // If one PIN is provided, both must be provided
            if ((pin4 && !pin6) || (!pin4 && pin6)) {
                e.preventDefault();
                alert('Please provide both PINs if you want to change them.');
                return false;
            }
            
            // Validate PIN lengths
            if (pin4 && pin4.length !== 4) {
                e.preventDefault();
                alert('4-digit PIN must be exactly 4 characters long.');
                return false;
            }
            
            if (pin6 && pin6.length !== 6) {
                e.preventDefault();
                alert('6-digit PIN must be exactly 6 characters long.');
                return false;
            }
        });
    </script>
</body>
</html> 