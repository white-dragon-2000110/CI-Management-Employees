<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-plus me-2"></i>Add New Employee
            </h1>
            <a href="/employees" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Employees
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Employee Information</h5>
            </div>
            <div class="card-body">
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="/employees/add">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo set_value('name'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" 
                                   value="<?php echo set_value('cpf'); ?>" 
                                   placeholder="000.000.000-00" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo set_value('email'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone *</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?php echo set_value('phone'); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position *</label>
                            <input type="text" class="form-control" id="position" name="position" 
                                   value="<?php echo set_value('position'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="access_level" class="form-label">Access Level</label>
                            <select class="form-select" id="access_level" name="access_level">
                                <option value="basic" <?php echo (set_value('access_level') === 'basic') ? 'selected' : ''; ?>>Basic</option>
                                <option value="standard" <?php echo (set_value('access_level') === 'standard') ? 'selected' : ''; ?>>Standard</option>
                                <option value="admin" <?php echo (set_value('access_level') === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="company_id" class="form-label">Company *</label>
                            <select class="form-select" id="company_id" name="company_id" required>
                                <option value="">Select Company</option>
                                <?php foreach ($companies as $company): ?>
                                    <option value="<?php echo $company->id; ?>" <?php echo (set_value('company_id') == $company->id) ? 'selected' : ''; ?>>
                                        <?php echo $company->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit_id" class="form-label">Unit *</label>
                            <select class="form-select" id="unit_id" name="unit_id" required>
                                <option value="">Select Unit</option>
                                <?php foreach ($units as $unit): ?>
                                    <option value="<?php echo $unit->id; ?>" <?php echo (set_value('unit_id') == $unit->id) ? 'selected' : ''; ?>>
                                        <?php echo $unit->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pin_4digit" class="form-label">4-Digit PIN *</label>
                            <input type="password" class="form-control" id="pin_4digit" name="pin_4digit" 
                                   maxlength="4" pattern="\d{4}" required>
                            <small class="form-text text-muted">Enter a 4-digit numeric PIN</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pin_6digit" class="form-label">6-Digit PIN *</label>
                            <input type="password" class="form-control" id="pin_6digit" name="pin_6digit" 
                                   maxlength="6" pattern="\d{6}" required>
                            <small class="form-text text-muted">Enter a 6-digit numeric PIN</small>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Information</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-shield-alt me-2"></i>Security Notes</h6>
                    <ul class="mb-0">
                        <li>PINs are securely hashed</li>
                        <li>CPF must be unique</li>
                        <li>Email must be unique</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Important</h6>
                    <ul class="mb-0">
                        <li>Employee will be set to 'active' status</li>
                        <li>Access level determines permissions</li>
                        <li>PINs cannot be recovered if lost</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Dynamic unit loading based on company selection
document.getElementById('company_id').addEventListener('change', function() {
    const companyId = this.value;
    const unitSelect = document.getElementById('unit_id');
    
    // Clear current units
    unitSelect.innerHTML = '<option value="">Select Unit</option>';
    
    if (companyId) {
        // Fetch units for selected company
        fetch('/employees/get_units_by_company', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'company_id=' + companyId
        })
        .then(response => response.json())
        .then(units => {
            units.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.id;
                option.textContent = unit.name;
                unitSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    }
});

// CPF formatting
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        e.target.value = value;
    }
});
</script> 