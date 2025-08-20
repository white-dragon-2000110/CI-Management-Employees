<?php $this->load->view('templates/header'); ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-ban me-2"></i>Block Employee Access
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
                            <h5 class="mb-3">Block Employee</h5>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Warning:</strong> This employee will not be able to access the system until unblocked.
                            </div>
                            
                            <form method="post" action="/employees/block/<?php echo $employee->id; ?>">
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason for Blocking *</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3" required 
                                              placeholder="Please provide a reason for blocking this employee's access"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="blocked_until" class="form-label">Block Until (Optional)</label>
                                    <input type="datetime-local" class="form-control" id="blocked_until" name="blocked_until">
                                    <small class="text-muted">Leave empty for indefinite blocking</small>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-ban me-2"></i>Block Employee
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

<?php $this->load->view('templates/footer'); ?> 