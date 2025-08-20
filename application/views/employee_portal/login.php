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
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px;
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
        .btn-login {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        .camera-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        #video {
            width: 100%;
            border-radius: 10px;
            border: 3px solid #3498db;
        }
        .camera-controls {
            margin-top: 15px;
            text-align: center;
        }
        .btn-camera {
            background: #27ae60;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: white;
            font-weight: 600;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        .btn-camera:hover {
            background: #229954;
            transform: translateY(-1px);
        }
        .btn-camera:disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }
        .photo-preview {
            display: none;
            margin-top: 15px;
        }
        #canvas {
            width: 100%;
            border-radius: 10px;
            border: 3px solid #27ae60;
        }
        .error-message {
            color: #e74c3c;
            background: #fdf2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success-message {
            color: #27ae60;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1><i class="fas fa-user-circle me-3"></i>Employee Portal</h1>
                <p class="mb-0">Secure Access with Dual PIN Authentication</p>
            </div>
            
            <div class="login-body">
                <!-- Toast notifications will be displayed automatically -->
                
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-4 text-center">Authentication</h4>
                        
                        <form method="post" id="loginForm">
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" class="form-control" id="cpf" name="cpf" 
                                           placeholder="000.000.000-00" required 
                                           pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                                           title="Please enter CPF in format: 000.000.000-00">
                                </div>
                                <div id="cpfInfo" class="mt-2" style="display: none;"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="pin_4digit" class="form-label">4-Digit PIN</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="pin_4digit" name="pin_4digit" 
                                           placeholder="1234" required maxlength="4" pattern="\d{4}"
                                           title="Please enter a 4-digit PIN">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="pin_6digit" class="form-label">6-Digit PIN</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-shield-alt"></i>
                                    </span>
                                    <input type="password" class="form-control" id="pin_6digit" name="pin_6digit" 
                                           placeholder="123456" required maxlength="6" pattern="\d{6}"
                                           title="Please enter a 6-digit PIN">
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <h4 class="mb-4 text-center">Live Photo Capture</h4>
                        
                        <div class="camera-section">
                            <div class="camera-container">
                                <video id="video" autoplay playsinline></video>
                                <canvas id="canvas" style="display: none;"></canvas>
                                
                                <div class="camera-controls">
                                    <button type="button" class="btn btn-camera" id="startCamera">
                                        <i class="fas fa-camera me-2"></i>Start Camera
                                    </button>
                                    <button type="button" class="btn btn-camera" id="capturePhoto" disabled>
                                        <i class="fas fa-camera-retro me-2"></i>Capture
                                    </button>
                                    <button type="button" class="btn btn-camera" id="retakePhoto" style="display: none;">
                                        <i class="fas fa-redo me-2"></i>Retake
                                    </button>
                                </div>
                                
                                <div class="photo-preview" id="photoPreview">
                                    <p class="text-center text-muted mb-2">Photo Preview</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Photo capture is required for security verification
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        let stream = null;
        let photoTaken = false;
        
        // CPF formatting
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                e.target.value = value;
            }
        });
        
        // CPF validation and info
        document.getElementById('cpf').addEventListener('blur', function() {
            const cpf = this.value.replace(/\D/g, '');
            if (cpf.length === 11) {
                $.post('/employee_portal/check_cpf', {cpf: this.value}, function(response) {
                    const cpfInfo = document.getElementById('cpfInfo');
                    if (response.exists) {
                        cpfInfo.innerHTML = `
                            <div class="alert alert-success alert-sm mb-0">
                                <i class="fas fa-check-circle me-1"></i>
                                <strong>${response.name}</strong> - ${response.unit}, ${response.company}
                            </div>
                        `;
                        cpfInfo.style.display = 'block';
                    } else {
                        cpfInfo.innerHTML = `
                            <div class="alert alert-warning alert-sm mb-0">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                CPF not found in system
                            </div>
                        `;
                        cpfInfo.style.display = 'block';
                    }
                });
            }
        });
        
        // Camera functionality
        document.getElementById('startCamera').addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: { ideal: 640 },
                        height: { ideal: 480 },
                        facingMode: 'user'
                    } 
                });
                
                document.getElementById('video').srcObject = stream;
                document.getElementById('startCamera').disabled = true;
                document.getElementById('capturePhoto').disabled = false;
                
                this.innerHTML = '<i class="fas fa-video me-2"></i>Camera Active';
                this.classList.remove('btn-camera');
                this.classList.add('btn-secondary');
                
            } catch (error) {
                alert('Error accessing camera: ' + error.message);
            }
        });
        
        document.getElementById('capturePhoto').addEventListener('click', function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Show photo preview
            document.getElementById('video').style.display = 'none';
            document.getElementById('canvas').style.display = 'block';
            document.getElementById('capturePhoto').style.display = 'none';
            document.getElementById('retakePhoto').style.display = 'inline-block';
            
            photoTaken = true;
        });
        
        document.getElementById('retakePhoto').addEventListener('click', function() {
            document.getElementById('video').style.display = 'block';
            document.getElementById('canvas').style.display = 'none';
            document.getElementById('capturePhoto').style.display = 'inline-block';
            document.getElementById('retakePhoto').style.display = 'none';
            
            photoTaken = false;
        });
        
        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            if (!photoTaken) {
                e.preventDefault();
                alert('Please capture a photo before logging in.');
                return;
            }
            
            // Add photo data to form
            const canvas = document.getElementById('canvas');
            const photoData = canvas.toDataURL('image/jpeg', 0.8);
            
            // Create hidden input for photo
            const photoInput = document.createElement('input');
            photoInput.type = 'hidden';
            photoInput.name = 'photo_data';
            photoInput.value = photoData;
            this.appendChild(photoInput);
        });
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
        
        // Toast notification system
        function showToast(message, type = 'info', duration = 5000) {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.toast-notification');
            existingToasts.forEach(toast => toast.remove());
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            
            // Add toast to page
            document.body.appendChild(toast);
            
            // Show toast
            setTimeout(() => toast.classList.add('show'), 100);
            
            // Auto-hide toast
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }
        
        // Check for flash messages and display as toasts
        <?php if ($this->session->flashdata('toast_message')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const message = '<?php echo addslashes($this->session->flashdata('toast_message')); ?>';
                const type = '<?php echo $this->session->flashdata('toast_type') ?: 'info'; ?>';
                showToast(message, type, 5000);
            });
        <?php endif; ?>
    </script>
    
    <style>
        /* Toast notification styles */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            padding: 15px 20px;
            margin-bottom: 10px;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 9999;
            max-width: 350px;
        }
        
        .toast-notification.show {
            transform: translateX(0);
        }
        
        .toast-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .toast-notification.toast-success {
            border-left: 4px solid #28a745;
        }
        
        .toast-notification.toast-error {
            border-left: 4px solid #dc3545;
        }
        
        .toast-notification.toast-warning {
            border-left: 4px solid #ffc107;
        }
        
        .toast-notification.toast-info {
            border-left: 4px solid #17a2b8;
        }
        
        .toast-notification .btn-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #666;
            margin-left: auto;
        }
        
        .toast-notification .btn-close:hover {
            color: #333;
        }
    </style>
</body>
</html> 