        </div> <!-- /.container-fluid -->
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-muted">Sistema de Gestão de Funcionários &copy; 2024</span>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-muted">Powered by CodeIgniter 3</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom CSS for status badges and severity indicators -->
    <style>
        /* Status badges */
        .status-active { 
            background-color: #d4edda !important; 
            color: #155724 !important; 
        }
        .status-vacation { 
            background-color: #fff3cd !important; 
            color: #856404 !important; 
        }
        .status-blocked { 
            background-color: #f8d7da !important; 
            color: #721c24 !important; 
        }
        .status-inactive { 
            background-color: #e2e3e5 !important; 
            color: #383d41 !important; 
        }
        
        /* Severity indicators */
        .severity-low { 
            background-color: #d1ecf1 !important; 
            color: #0c5460 !important; 
        }
        .severity-medium { 
            background-color: #fff3cd !important; 
            color: #856404 !important; 
        }
        .severity-high { 
            background-color: #f8d7da !important; 
            color: #721c24 !important; 
        }
        .severity-critical { 
            background-color: #721c24 !important; 
            color: #ffffff !important; 
        }
        
        /* Table improvements */
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Card improvements */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        /* Button improvements */
        .btn-group .btn {
            margin-right: 2px;
        }
        
        .btn-group .btn:last-child {
            margin-right: 0;
        }
        
        /* Form improvements */
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        /* Alert improvements */
        .alert {
            border-radius: 0.375rem;
        }
        
        /* Badge improvements */
        .badge {
            font-size: 0.75em;
            padding: 0.375em 0.75em;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .btn-group .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
</body>
</html> 