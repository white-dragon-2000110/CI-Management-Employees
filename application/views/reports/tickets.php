<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-ticket-alt me-2"></i>Support Tickets Report
            </h1>
            <div>
                <a href="/reports/tickets?export=csv<?php echo !empty($filters) ? '&' . http_build_query($filters) : ''; ?>" class="btn btn-success me-2">
                    <i class="fas fa-download me-2"></i>Export CSV
                </a>
                <a href="/reports" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Reports
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<!-- <div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-primary"><?php echo $stats['total']; ?></h4>
                <p class="card-text text-muted">Total Tickets</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-warning"><?php echo $stats['open']; ?></h4>
                <p class="card-text text-muted">Open Tickets</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-success"><?php echo $stats['resolved']; ?></h4>
                <p class="card-text text-muted">Resolved</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-info"><?php echo $stats['avg_resolution_hours']; ?>h</h4>
                <p class="card-text text-muted">Avg Resolution</p>
            </div>
        </div>
    </div>
</div> -->

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
    </div>
    <div class="card-body">
        <form method="get" action="/reports/tickets">
            <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="company_id" class="form-label">Company</label>
                    <select class="form-select" id="company_id" name="company_id">
                        <option value="">All Companies</option>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?php echo $company->id; ?>" <?php echo (isset($filters['company_id']) && $filters['company_id'] == $company->id) ? 'selected' : ''; ?>>
                                <?php echo $company->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="unit_id" class="form-label">Unit</label>
                    <select class="form-select" id="unit_id" name="unit_id">
                        <option value="">All Units</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?php echo $unit->id; ?>" <?php echo (isset($filters['unit_id']) && $filters['unit_id'] == $unit->id) ? 'selected' : ''; ?>>
                                <?php echo $unit->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-select" id="priority" name="priority">
                        <option value="">All Priorities</option>
                        <option value="low" <?php echo (isset($filters['priority']) && $filters['priority'] === 'low') ? 'selected' : ''; ?>>Low</option>
                        <option value="medium" <?php echo (isset($filters['priority']) && $filters['priority'] === 'medium') ? 'selected' : ''; ?>>Medium</option>
                        <option value="high" <?php echo (isset($filters['priority']) && $filters['priority'] === 'high') ? 'selected' : ''; ?>>High</option>
                        <option value="urgent" <?php echo (isset($filters['priority']) && $filters['priority'] === 'urgent') ? 'selected' : ''; ?>>Urgent</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="open" <?php echo (isset($filters['status']) && $filters['status'] === 'open') ? 'selected' : ''; ?>>Open</option>
                        <option value="in_progress" <?php echo (isset($filters['status']) && $filters['status'] === 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                        <option value="resolved" <?php echo (isset($filters['status']) && $filters['status'] === 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                        <option value="closed" <?php echo (isset($filters['status']) && $filters['status'] === 'closed') ? 'selected' : ''; ?>>Closed</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?php echo isset($filters['search']) ? $filters['search'] : ''; ?>" 
                           placeholder="Search by title or description...">
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    <a href="/reports/tickets" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tickets Table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Support Tickets</h5>
    </div>
    <div class="card-body">
        <?php if (empty($tickets)): ?>
            <div class="text-center py-4">
                <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No support tickets found</h5>
                <p class="text-muted">Try adjusting your filters or check back later.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ticket #</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td>
                                    <strong>#<?php echo $ticket->id; ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo $ticket->title; ?></strong>
                                </td>
                                <td>
                                    <?php if ($ticket->description): ?>
                                        <?php echo substr($ticket->description, 0, 100) . (strlen($ticket->description) > 100 ? '...' : ''); ?>
                                    <?php else: ?>
                                        <span class="text-muted">No description</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $ticket->priority === 'urgent' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : 'secondary'); ?>">
                                        <?php echo ucfirst($ticket->priority); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $ticket->status === 'open' ? 'danger' : ($ticket->status === 'in_progress' ? 'warning' : 'success'); ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $ticket->status)); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?php echo date('M j, Y', strtotime($ticket->created_at)); ?></strong>
                                    <br><small class="text-muted"><?php echo date('H:i:s', strtotime($ticket->created_at)); ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Dynamic unit loading based on company selection
document.getElementById('company_id').addEventListener('change', function() {
    const companyId = this.value;
    const unitSelect = document.getElementById('unit_id');
    
    // Clear current units
    unitSelect.innerHTML = '<option value="">All Units</option>';
    
    if (companyId) {
        // Fetch units for selected company
        fetch('/reports/get_units_by_company', {
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
</script> 