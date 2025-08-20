<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                    <h5 class="text-danger mb-3">Are you sure you want to delete this employee?</h5>
                    <p class="text-muted mb-0">This action cannot be undone and will permanently remove the employee from the system.</p>
                </div>
                <div class="alert alert-warning text-start">
                    <h6 class="alert-heading mb-2">
                        <i class="fas fa-info-circle me-2"></i>Employee Details
                    </h6>
                    <div class="row">
                        <div class="col-6">
                            <strong>Name:</strong><br>
                            <span class="text-dark"><?php echo htmlspecialchars($employee->name); ?></span>
                        </div>
                        <div class="col-6">
                            <strong>ID:</strong><br>
                            <span class="text-dark">#<?php echo $employee->id; ?></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <strong>Position:</strong><br>
                            <span class="text-dark"><?php echo htmlspecialchars($employee->position); ?></span>
                        </div>
                        <div class="col-6">
                            <strong>Email:</strong><br>
                            <span class="text-dark"><?php echo htmlspecialchars($employee->email); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form action="/employees/delete/<?php echo $employee->id; ?>" method="post" style="display: inline;">
                    <input type="hidden" name="confirm" value="yes">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash me-2"></i>Delete Employee
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> 