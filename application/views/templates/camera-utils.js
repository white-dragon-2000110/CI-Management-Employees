/**
 * Camera Utilities - Cross-platform camera functionality
 * Works on both desktop and mobile devices
 */

class CameraManager {
    constructor(options = {}) {
        this.stream = null;
        this.videoElement = null;
        this.canvasElement = null;
        this.onError = options.onError || console.error;
        this.onSuccess = options.onSuccess || (() => {});
        this.onStreamReady = options.onStreamReady || (() => {});
        
        // Default constraints
        this.constraints = {
            video: {
                width: { ideal: 1280, min: 640 },
                height: { ideal: 720, min: 480 },
                facingMode: 'user',
                aspectRatio: { ideal: 16/9 }
            },
            audio: false
        };
        
        // Override with custom constraints if provided
        if (options.constraints) {
            this.constraints = { ...this.constraints, ...options.constraints };
        }
    }

    /**
     * Initialize camera with enhanced error handling
     */
    async initialize(videoElement, canvasElement = null) {
        this.videoElement = videoElement;
        this.canvasElement = canvasElement;
        
        try {
            // Check browser support
            this._checkBrowserSupport();
            
            // Check security context
            this._checkSecurityContext();
            
            // Request camera access
            await this._requestCameraAccess();
            
            // Set up video stream
            this._setupVideoStream();
            
            // Call success callback
            this.onSuccess();
            this.onStreamReady(this.stream);
            
        } catch (error) {
            this._handleError(error);
        }
    }

    /**
     * Check if browser supports getUserMedia
     */
    _checkBrowserSupport() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            throw new Error('Camera API not supported in this browser');
        }
    }

    /**
     * Check if we're in a secure context (required for mobile)
     */
    _checkSecurityContext() {
        if (location.protocol !== 'https:' && 
            location.hostname !== 'localhost' && 
            location.hostname !== '127.0.0.1' &&
            location.hostname !== '10.254.254.16') {
            throw new Error('Camera access requires HTTPS on mobile devices');
        }
    }

    /**
     * Request camera access
     */
    async _requestCameraAccess() {
        try {
            this.stream = await navigator.mediaDevices.getUserMedia(this.constraints);
        } catch (error) {
            // Enhanced error handling for specific error types
            if (error.name === 'NotAllowedError') {
                throw new Error('Permission denied. Please allow camera access.');
            } else if (error.name === 'NotFoundError') {
                throw new Error('No camera found on device.');
            } else if (error.name === 'NotReadableError') {
                throw new Error('Camera is being used by another application.');
            } else if (error.name === 'OverconstrainedError') {
                throw new Error('Camera configuration not supported.');
            } else if (error.name === 'SecurityError') {
                throw new Error('Camera access blocked for security reasons.');
            } else if (error.name === 'AbortError') {
                throw new Error('Camera access was aborted.');
            } else if (error.name === 'NotSupportedError') {
                throw new Error('Camera not supported on this device.');
            } else {
                throw error;
            }
        }
    }

    /**
     * Set up video stream
     */
    _setupVideoStream() {
        if (!this.videoElement || !this.stream) {
            throw new Error('Video element or stream not available');
        }

        this.videoElement.srcObject = this.stream;
        
        // Wait for video to be ready
        return new Promise((resolve) => {
            this.videoElement.onloadedmetadata = () => {
                this.videoElement.play().then(() => {
                    resolve();
                }).catch(error => {
                    console.warn('Auto-play failed:', error);
                    resolve(); // Continue anyway
                });
            };
        });
    }

    /**
     * Capture photo from video stream
     */
    capturePhoto(quality = 0.8) {
        if (!this.videoElement || !this.canvasElement || !this.stream) {
            throw new Error('Camera not ready for photo capture');
        }

        try {
            const video = this.videoElement;
            const canvas = this.canvasElement;
            
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw video frame to canvas
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Return image data
            return canvas.toDataURL('image/jpeg', quality);
            
        } catch (error) {
            throw new Error(`Photo capture failed: ${error.message}`);
        }
    }

    /**
     * Switch camera (front/back) if available
     */
    async switchCamera() {
        if (!this.stream) {
            throw new Error('No active camera stream');
        }

        try {
            // Stop current stream
            this.stop();
            
            // Toggle facing mode
            if (this.constraints.video.facingMode === 'user') {
                this.constraints.video.facingMode = 'environment';
            } else {
                this.constraints.video.facingMode = 'user';
            }
            
            // Reinitialize with new constraints
            await this.initialize(this.videoElement, this.canvasElement);
            
        } catch (error) {
            // Revert to original facing mode if switch fails
            this.constraints.video.facingMode = 'user';
            throw error;
        }
    }

    /**
     * Stop camera stream
     */
    stop() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => {
                track.stop();
            });
            this.stream = null;
        }
        
        if (this.videoElement) {
            this.videoElement.srcObject = null;
        }
    }

    /**
     * Check if camera is active
     */
    isActive() {
        return this.stream && this.stream.active;
    }

    /**
     * Get camera capabilities
     */
    async getCapabilities() {
        if (!this.stream) {
            throw new Error('No active camera stream');
        }

        const videoTrack = this.stream.getVideoTracks()[0];
        if (videoTrack && videoTrack.getCapabilities) {
            return videoTrack.getCapabilities();
        }
        
        return null;
    }

    /**
     * Handle errors with user-friendly messages
     */
    _handleError(error) {
        console.error('Camera error:', error);
        
        let userMessage = 'Camera error: ';
        
        if (error.message.includes('HTTPS')) {
            userMessage += 'Camera access requires HTTPS on mobile devices.';
        } else if (error.message.includes('Permission denied')) {
            userMessage += 'Please allow camera access in your browser settings.';
        } else if (error.message.includes('No camera found')) {
            userMessage += 'No camera detected on this device.';
        } else if (error.message.includes('being used by another application')) {
            userMessage += 'Camera is busy. Close other apps using the camera.';
        } else if (error.message.includes('not supported')) {
            userMessage += 'Camera configuration not supported by this device.';
        } else if (error.message.includes('blocked for security')) {
            userMessage += 'Camera access blocked. Check browser security settings.';
        } else {
            userMessage += error.message || 'Unknown error occurred.';
        }
        
        this.onError(userMessage, error);
    }

    /**
     * Get device info
     */
    getDeviceInfo() {
        return {
            userAgent: navigator.userAgent,
            isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
            isSecure: location.protocol === 'https:' || 
                     location.hostname === 'localhost' || 
                     location.hostname === '127.0.0.1' ||
                     location.hostname === '10.254.254.16',
            protocol: location.protocol,
            hostname: location.hostname
        };
    }
}

/**
 * Utility function to create a camera manager with common configuration
 */
function createCameraManager(options = {}) {
    return new CameraManager(options);
}

/**
 * Check if camera is supported in current environment
 */
function isCameraSupported() {
    return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
}

/**
 * Check if we're in a secure context for camera access
 */
function isSecureContext() {
    return location.protocol === 'https:' || 
           location.hostname === 'localhost' || 
           location.hostname === '127.0.0.1' ||
           location.hostname === '10.254.254.16';
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { CameraManager, createCameraManager, isCameraSupported, isSecureContext };
} 