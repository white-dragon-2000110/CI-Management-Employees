<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Sistema de Gestão de Funcionários</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .logoutindex{
            z-index: 10000;
        }
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50 !important;
        }
        .nav-link {
            color: #34495e !important;
            font-weight: 500;
        }
        .nav-link:hover {
            color: #2c3e50 !important;
        }
        .nav-link.active {
            color: #3498db !important;
            font-weight: 600;
        }
        .main-content {
            min-height: calc(100vh - 120px);
            padding: 20px 0;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .alert {
            border-radius: 0.375rem;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        .badge {
            font-size: 0.75em;
        }
        .status-active { background-color: #d4edda; color: #155724; }
        .status-vacation { background-color: #fff3cd; color: #856404; }
        .status-blocked { background-color: #f8d7da; color: #721c24; }
        .status-inactive { background-color: #e2e3e5; color: #383d41; }
        .severity-low { background-color: #d1ecf1; color: #0c5460; }
        .severity-medium { background-color: #fff3cd; color: #856404; }
        .severity-high { background-color: #f8d7da; color: #721c24; }
        .severity-critical { background-color: #f5c6cb; color: #721c24; }
        
        /* Delete button and modal enhancements */
        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header.bg-danger {
            border-radius: 15px 15px 0 0;
        }
        
        .modal-footer {
            border-radius: 0 0 15px 15px;
        }
        
        .btn-close-white {
            filter: brightness(0) invert(1);
        }
        
        .alert-warning {
            border-left: 4px solid #ffc107;
            background-color: #fff8e1;
        }
        
        /* Animation for modal */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }
        
        .modal.show .modal-dialog {
            transform: none;
        }
        
        /* Enhanced button styles */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
        }
        
        .btn-danger:hover {
            background: linear-gradient(45deg, #c82333, #a71e2a);
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #5a6268);
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary:hover {
            background: linear-gradient(45deg, #5a6268, #495057);
            transform: translateY(-1px);
        }
        
        /* Modern UI Enhancements */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .main-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 20px 20px;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 8px 16px !important;
        }
        
        .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 20px 25px;
            font-weight: 600;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }
        
        .btn-info {
            background: linear-gradient(135deg,rgb(133, 234, 102) 0%,rgb(75, 162, 104) 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-info:hover {
            background: linear-gradient(135deg,rgb(116, 192, 93) 0%,rgb(74, 168, 105) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }
        
        .btn-warning {
            background: linear-gradient(135deg,rgb(241, 224, 65) 0%,rgb(170, 168, 17) 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg,rgb(212, 198, 71) 0%,rgb(139, 137, 18) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }
        
        .btn-success {
            background: linear-gradient(135deg,rgb(49, 187, 241) 0%,rgb(40, 169, 201) 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg,rgb(47, 167, 214) 0%,rgb(33, 134, 160) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }
        
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-outline-warning {
            border: 2px solid #ffc107;
            color: #ffc107;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-warning:hover {
            background: #ffc107;
            color: #212529;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }
        
        .btn-outline-info {
            border: 2px solid #17a2b8;
            color: #17a2b8;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-info:hover {
            background: #17a2b8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
        }
        
        .btn-outline-success {
            border: 2px solid #28a745;
            color: #28a745;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-success:hover {
            background: #28a745;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            padding: 15px;
            font-weight: 600;
            color: #495057;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 15px;
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .badge {
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .status-active {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .status-vacation {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }
        
        .status-blocked {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
        }
        
        .status-inactive {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }
        
        .alert {
            border: none;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 5px solid #28a745;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            border-left: 5px solid #ffc107;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
            border-left: 5px solid #17a2b8;
        }
        
        /* Statistics Cards Enhancement */
        .card.text-center {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }
        
        .card.text-center:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-color: rgba(102, 126, 234, 0.3);
        }
        
        .card-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .card-text {
            font-size: 1.1rem;
            font-weight: 500;
            color: #6c757d;
        }
        
        /* Page Header Enhancement */
        .h3.mb-0 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.2rem;
        }
        
        /* Filter Section Enhancement */
        .card.mb-4 {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        /* Animation for page load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .main-content {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .main-content {
                margin: 10px;
                padding: 20px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
    
    <!-- Toast Container -->
    <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
    
    <!-- Toast Styles -->
    <style>
    /* Modern Toast System */
    .toast-container {
        z-index: 9999;
    }
    
    .custom-toast {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        min-width: 350px;
        max-width: 450px;
        position: relative;
        animation: slideInRight 0.4s ease-out;
    }
    
    .custom-toast::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        border-radius: 15px 0 0 15px;
    }
    
    .custom-toast.toast-success::before {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    
    .custom-toast.toast-error::before {
        background: linear-gradient(135deg, #dc3545, #e83e8c);
    }
    
    .custom-toast.toast-warning::before {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
    }
    
    .custom-toast.toast-info::before {
        background: linear-gradient(135deg, #17a2b8, #20c997);
    }
    
    .custom-toast .toast-header {
        background: transparent;
        border: none;
        padding: 15px 20px 10px;
        position: relative;
    }
    
    .custom-toast .toast-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 20px;
        right: 20px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
    }
    
    .custom-toast .toast-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-left: 10px;
    }
    
    .custom-toast .toast-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: white;
    }
    
    .custom-toast.toast-success .toast-icon {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    
    .custom-toast.toast-error .toast-icon {
        background: linear-gradient(135deg, #dc3545, #e83e8c);
    }
    
    .custom-toast.toast-warning .toast-icon {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
    }
    
    .custom-toast.toast-info .toast-icon {
        background: linear-gradient(135deg, #17a2b8, #20c997);
    }
    
    .custom-toast .toast-body {
        padding: 15px 20px 20px;
        font-size: 0.95rem;
        line-height: 1.5;
        color: #495057;
    }
    
    .custom-toast .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #6c757d;
        opacity: 0.7;
        transition: all 0.2s ease;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .custom-toast .btn-close:hover {
        opacity: 1;
        color: #dc3545;
        transform: scale(1.1);
    }
    
    .custom-toast .btn-close::before {
        content: '×';
        font-weight: bold;
    }
    
    /* Toast Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .custom-toast.hiding {
        animation: slideOutRight 0.3s ease-in forwards;
    }
    
    .custom-toast.showing {
        animation: fadeIn 0.3s ease-out;
    }
    
    /* Toast Progress Bar */
    .custom-toast .toast-progress {
        position: absolute;
        bottom: 0;
        left: 5px;
        height: 3px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 0 0 15px 15px;
        overflow: hidden;
    }
    
    .custom-toast .toast-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 0 0 15px 15px;
        animation: progressBar 5s linear forwards;
    }
    
    @keyframes progressBar {
        from { width: 100%; }
        to { width: 0%; }
    }
    
    /* Toast Types with Enhanced Styling */
    .custom-toast.toast-success {
        border-left: 5px solid #28a745;
    }
    
    .custom-toast.toast-error {
        border-left: 5px solid #dc3545;
    }
    
    .custom-toast.toast-warning {
        border-left: 5px solid #ffc107;
    }
    
    .custom-toast.toast-info {
        border-left: 5px solid #17a2b8;
    }
    
    /* Responsive Toast */
    @media (max-width: 576px) {
        .custom-toast {
            min-width: 300px;
            max-width: 350px;
        }
        
        .toast-container {
            padding: 10px;
        }
    }
    
    /* Toast Stacking */
    .toast-container .custom-toast + .custom-toast {
        margin-top: 15px;
    }
    
    /* Toast Hover Effects */
    .custom-toast:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
    
    /* Toast Focus States */
    .custom-toast:focus-within {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
    </style>
    
    <!-- Toast JavaScript -->
    <script>
    // Modern Toast Notification System
    class ToastManager {
        constructor() {
            this.toastContainer = document.getElementById('toast-container');
            this.toastQueue = [];
            this.isProcessing = false;
        }
        
        // Show a toast notification
        show(message, type = 'info', duration = 5000, options = {}) {
            const toast = this.createToast(message, type, options);
            this.toastQueue.push(toast);
            
            if (!this.isProcessing) {
                this.processQueue();
            }
        }
        
        // Create toast element
        createToast(message, type, options) {
            const toast = document.createElement('div');
            toast.className = `custom-toast toast-${type} showing`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            const icon = this.getIcon(type);
            const title = this.getTitle(type);
            
            toast.innerHTML = `
                <div class="toast-header">
                    <div class="d-flex align-items-center">
                        <div class="toast-icon">
                            <i class="fas ${icon}"></i>
                        </div>
                        <strong class="toast-title">${title}</strong>
                    </div>
                    <button type="button" class="btn-close" aria-label="Close" onclick="this.closest('.custom-toast').remove()"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
                <div class="toast-progress">
                    <div class="toast-progress-bar"></div>
                </div>
            `;
            
            // Add click to dismiss
            toast.addEventListener('click', (e) => {
                if (e.target === toast) {
                    this.dismissToast(toast);
                }
            });
            
            return toast;
        }
        
        // Get icon for toast type
        getIcon(type) {
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            return icons[type] || icons.info;
        }
        
        // Get title for toast type
        getTitle(type) {
            const titles = {
                success: 'Sucesso!',
                error: 'Erro!',
                warning: 'Aviso!',
                info: 'Informação'
            };
            return titles[type] || titles.info;
        }
        
        // Process toast queue
        processQueue() {
            if (this.toastQueue.length === 0) {
                this.isProcessing = false;
                return;
            }
            
            this.isProcessing = true;
            const toast = this.toastQueue.shift();
            
            // Add to container
            this.toastContainer.appendChild(toast);
            
            // Auto-dismiss after duration
            setTimeout(() => {
                this.dismissToast(toast);
            }, 5000);
            
            // Process next toast after a small delay
            setTimeout(() => {
                this.processQueue();
            }, 100);
        }
        
        // Dismiss toast with animation
        dismissToast(toast) {
            if (!toast.parentNode) return;
            
            toast.classList.add('hiding');
            
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }
        
        // Success toast
        success(message, duration = 5000, options = {}) {
            this.show(message, 'success', duration, options);
        }
        
        // Error toast
        error(message, duration = 5000, options = {}) {
            this.show(message, 'error', duration, options);
        }
        
        // Warning toast
        warning(message, duration = 5000, options = {}) {
            this.show(message, 'warning', duration, options);
        }
        
        // Info toast
        info(message, duration = 5000, options = {}) {
            this.show(message, 'info', duration, options);
        }
        
        // Clear all toasts
        clearAll() {
            const toasts = this.toastContainer.querySelectorAll('.custom-toast');
            toasts.forEach(toast => this.dismissToast(toast));
        }
    }
    
    // Initialize toast manager
    const toastManager = new ToastManager();
    
    // Global toast functions for easy access
    window.showToast = (message, type = 'info', duration = 5000) => {
        toastManager.show(message, type, duration);
    };
    
    window.showSuccessToast = (message, duration = 5000) => {
        toastManager.success(message, duration);
    };
    
    window.showErrorToast = (message, duration = 5000) => {
        toastManager.error(message, duration);
    };
    
    window.showWarningToast = (message, duration = 5000) => {
        toastManager.warning(message, duration);
    };
    
    window.showInfoToast = (message, duration = 5000) => {
        toastManager.info(message, duration);
    };
    
    // Auto-clear toasts on page unload
    window.addEventListener('beforeunload', () => {
        toastManager.clearAll();
    });
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-users me-2"></i>SGF
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos(current_url(), 'dashboard') !== false) ? 'active' : ''; ?>" href="/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Painel de Controle
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos(current_url(), 'employees') !== false) ? 'active' : ''; ?>" href="/employees">
                            <i class="fas fa-users me-1"></i>Funcionários
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos(current_url(), 'reports') !== false) ? 'active' : ''; ?>" href="/reports">
                            <i class="fas fa-chart-bar me-1"></i>Relatórios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos(current_url(), 'employee_portal') !== false) ? 'active' : ''; ?>" href="/employee_portal" target="_blank">
                            <i class="fas fa-user-circle me-1"></i>Portal do Funcionário
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?php echo $this->session->userdata('user_name') ?: 'Usuário'; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/auth/logout"><i class="fas fa-sign-out-alt me-1 z-index"></i>Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Toast Notifications from Flash Data -->
    <?php if ($this->session->flashdata('toast_message')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const message = '<?php echo addslashes($this->session->flashdata('toast_message')); ?>';
                const type = '<?php echo $this->session->flashdata('toast_type') ?: 'info'; ?>';
                
                // Show toast notification
                if (typeof showToast === 'function') {
                    showToast(message, type, 5000);
                } else if (typeof toastManager !== 'undefined') {
                    toastManager.show(message, type, 5000);
                } else {
                    // Fallback to alert if toast system not available
                    alert(message);
                }
            });
        </script>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container"> 