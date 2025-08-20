<?php $this->load->view('templates/header'); ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-umbrella-beach me-2"></i>Set Vacation Period
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Employee Information</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td><?php echo $employee->name; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>ID:</strong></td>
                                        <td>#<?php echo $employee->id; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Position:</strong></td>
                                        <td><?php echo $employee->position; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td><?php echo $employee->email; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Company:</strong></td>
                                        <td><?php echo $employee->company_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Unit:</strong></td>
                                        <td><?php echo $employee->unit_name; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Set Vacation Period</h5>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> This employee will be marked as on vacation during the specified period.
                            </div>
                            
                            <form method="post" action="/employees/vacation/<?php echo $employee->id; ?>">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required 
                                           min="<?php echo date('Y-m-d'); ?>">
                                    <small class="text-muted">Vacation start date</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date *</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required 
                                           min="<?php echo date('Y-m-d'); ?>">
                                    <small class="text-muted">Vacation end date</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason for Vacation *</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3" required 
                                              placeholder="Please provide a reason for the vacation period"></textarea>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-umbrella-beach me-2"></i>Set Vacation
                                    </button>
                                    <a href="/employees/view/<?php echo $employee->id; ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Set minimum end date based on start date
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = this.value;
    const endDateInput = document.getElementById('end_date');
    if (startDate) {
        endDateInput.min = startDate;
        // If end date is before start date, clear it
        if (endDateInput.value && endDateInput.value < startDate) {
            endDateInput.value = '';
        }
    }
});

// Validate that end date is after start date
document.getElementById('end_date').addEventListener('change', function() {
    const startDate = document.getElementById('start_date').value;
    const endDate = this.value;
    
    if (startDate && endDate && endDate <= startDate) {
        alert('End date must be after start date');
        this.value = '';
    }
});
</script>

<?php $this->load->view('templates/footer'); ?> 