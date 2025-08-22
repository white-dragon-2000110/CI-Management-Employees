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
        .capture-container {
            min-height: 100vh;
            padding: 40px 0;
        }
        .capture-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        .capture-header {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .capture-body {
            padding: 40px;
        }
        .camera-container {
            text-align: center;
            margin-bottom: 30px;
        }
        #video {
            width: 100%;
            max-width: 500px;
            border-radius: 15px;
            border: 3px solid #3498db;
            margin-bottom: 20px;
        }
        #canvas {
            display: none;
        }
        .btn-capture {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
            border-radius: 10px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        .btn-capture:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
            color: white;
        }
        .btn-save {
            background: linear-gradient(135deg, #27ae60, #229954);
            border: none;
            border-radius: 10px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
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
        .preview-container {
            text-align: center;
            margin: 20px 0;
        }
        #photo-preview {
            max-width: 300px;
            border-radius: 15px;
            border: 3px solid #27ae60;
            display: none;
        }
        .status-message {
            margin: 20px 0;
            padding: 15px;
            border-radius: 10px;
            display: none;
        }
        .status-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .status-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .loading {
            display: none;
            text-align: center;
            margin: 20px 0;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .instructions {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="capture-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="capture-card">
                        <div class="capture-header">
                            <h1><i class="fas fa-camera me-3"></i>Capture Photo</h1>
                            <p class="mb-0">Update your profile photo for security verification</p>
                        </div>
                        
                        <div class="capture-body">
                            <!-- Instructions -->
                            <div class="instructions">
                                <h5><i class="fas fa-info-circle me-2"></i>Instructions</h5>
                                <ul class="mb-0">
                                    <li>Position yourself in good lighting</li>
                                    <li>Look directly at the camera</li>
                                    <li>Ensure your face is clearly visible</li>
                                    <li>Click "Capture Photo" when ready</li>
                                    <li>Review the photo and click "Save Photo" if satisfied</li>
                                </ul>
                            </div>

                            <!-- Camera Feed -->
                            <div class="camera-container">
                                <video id="video" autoplay playsinline></video>
                                <canvas id="canvas"></canvas>
                                
                                <div class="mt-3">
                                    <button id="capture-btn" class="btn-capture">
                                        <i class="fas fa-camera me-2"></i>Capture Photo
                                    </button>
                                </div>
                            </div>

                            <!-- Photo Preview -->
                            <div class="preview-container">
                                <h5><i class="fas fa-image me-2"></i>Photo Preview</h5>
                                <img id="photo-preview" alt="Captured Photo">
                                <div class="mt-3">
                                    <button id="save-btn" class="btn-save" style="display: none;">
                                        <i class="fas fa-save me-2"></i>Save Photo
                                    </button>
                                    <button id="retake-btn" class="btn-capture" style="display: none;">
                                        <i class="fas fa-redo me-2"></i>Retake Photo
                                    </button>
                                </div>
                            </div>

                            <!-- Status Messages -->
                            <div id="status-message" class="status-message"></div>

                            <!-- Loading Spinner -->
                            <div id="loading" class="loading">
                                <div class="spinner"></div>
                                <p>Processing photo...</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="text-center mt-4">
                                <a href="/employee_portal/profile" class="btn-back">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Profile
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
    
    <script>
        let stream = null;
        let capturedImage = null;

        // Initialize camera
        async function initCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: { ideal: 640 },
                        height: { ideal: 480 },
                        facingMode: 'user'
                    } 
                });
                document.getElementById('video').srcObject = stream;
            } catch (err) {
                console.error('Error accessing camera:', err);
                showStatus('Error accessing camera. Please ensure camera permissions are granted.', 'error');
            }
        }

        // Capture photo
        function capturePhoto() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const preview = document.getElementById('photo-preview');
            
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw video frame to canvas
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Get image data
            capturedImage = canvas.toDataURL('image/jpeg', 0.8);
            
            // Show preview
            preview.src = capturedImage;
            preview.style.display = 'block';
            
            // Show/hide buttons
            document.getElementById('save-btn').style.display = 'inline-block';
            document.getElementById('retake-btn').style.display = 'inline-block';
            document.getElementById('capture-btn').style.display = 'none';
            
            showStatus('Photo captured! Review and save if satisfied.', 'success');
        }

        // Save photo
        async function savePhoto() {
            if (!capturedImage) {
                showStatus('No photo captured yet.', 'error');
                return;
            }

            // Show loading
            document.getElementById('loading').style.display = 'block';
            document.getElementById('save-btn').disabled = true;
            document.getElementById('retake-btn').disabled = true;

            try {
                const response = await fetch('/employee_portal/save_photo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'image=' + encodeURIComponent(capturedImage)
                });

                const result = await response.json();

                if (result.success) {
                    showStatus('Photo saved successfully! Redirecting to profile...', 'success');
                    setTimeout(() => {
                        window.location.href = '/employee_portal/profile';
                    }, 2000);
                } else {
                    showStatus('Error saving photo: ' + result.message, 'error');
                }
            } catch (err) {
                console.error('Error saving photo:', err);
                showStatus('Error saving photo. Please try again.', 'error');
            } finally {
                // Hide loading
                document.getElementById('loading').style.display = 'none';
                document.getElementById('save-btn').disabled = false;
                document.getElementById('retake-btn').disabled = false;
            }
        }

        // Retake photo
        function retakePhoto() {
            // Reset preview
            document.getElementById('photo-preview').style.display = 'none';
            capturedImage = null;
            
            // Show/hide buttons
            document.getElementById('save-btn').style.display = 'none';
            document.getElementById('retake-btn').style.display = 'none';
            document.getElementById('capture-btn').style.display = 'inline-block';
            
            // Clear status
            hideStatus();
        }

        // Show status message
        function showStatus(message, type) {
            const statusDiv = document.getElementById('status-message');
            statusDiv.textContent = message;
            statusDiv.className = `status-message status-${type}`;
            statusDiv.style.display = 'block';
        }

        // Hide status message
        function hideStatus() {
            document.getElementById('status-message').style.display = 'none';
        }

        // Event listeners
        document.getElementById('capture-btn').addEventListener('click', capturePhoto);
        document.getElementById('save-btn').addEventListener('click', savePhoto);
        document.getElementById('retake-btn').addEventListener('click', retakePhoto);

        // Initialize camera when page loads
        document.addEventListener('DOMContentLoaded', initCamera);

        // Clean up camera when leaving page
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html> 