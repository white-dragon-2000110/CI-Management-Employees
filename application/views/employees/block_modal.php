<!-- Block Confirmation Modal -->
<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="modal-title" id="blockModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Employee Block
                </h5>
                <button type="button" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-user-slash fa-3x text-warning mb-3"></i>
                    <h6 class="text-muted">Are you sure you want to block this employee?</h6>
                </div>
                
                <div class="employee-info bg-light p-3 rounded mb-4">
                    <div class="row text-start">
                        <div class="col-12 mb-2">
                            <strong>Name:</strong> <?php echo $employee->name; ?>
                        </div>
                        <div class="col-6 mb-2">
                            <strong>ID:</strong> #<?php echo $employee->id; ?>
                        </div>
                        <div class="col-6 mb-2">
                            <strong>Position:</strong> <?php echo $employee->position; ?>
                        </div>
                        <div class="col-12 mb-2">
                            <strong>Email:</strong> <?php echo $employee->email; ?>
                        </div>
                        <div class="col-12 mb-2">
                            <strong>Company:</strong> <?php echo $employee->company_name; ?>
                        </div>
                        <div class="col-12">
                            <strong>Unit:</strong> <?php echo $employee->unit_name; ?>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning border-0">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This employee will not be able to access the system until unblocked.
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form action="/employees/block/<?php echo $employee->id; ?>" method="post" style="display: inline;">
                    <input type="hidden" name="confirm" value="yes">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-ban me-2"></i>Block Employee
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> 