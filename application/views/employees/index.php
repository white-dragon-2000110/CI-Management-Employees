<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i>Gestão de Funcionários
            </h1>
            <a href="/employees/add" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Adicionar Funcionário
            </a>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if (isset($this->session) && $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($this->session) && $this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-2 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-primary"><?php echo $stats['total']; ?></h4>
                <p class="card-text text-muted">Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-success"><?php echo $stats['active']; ?></h4>
                <p class="card-text text-muted">Ativos</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-warning"><?php echo $stats['vacation']; ?></h4>
                <p class="card-text text-muted">Férias</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-danger"><?php echo $stats['blocked']; ?></h4>
                <p class="card-text text-muted">Bloqueados</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title text-secondary"><?php echo $stats['inactive']; ?></h4>
                <p class="card-text text-muted">Inativos</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
    </div>
    <div class="card-body">
        <form method="get" action="/employees">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="search" class="form-label">Pesquisar</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="<?php echo isset($filters['search']) ? $filters['search'] : ''; ?>" 
                           placeholder="Nome, email, CPF...">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos os Status</option>
                        <option value="active" <?php echo (isset($filters['status']) && $filters['status'] === 'active') ? 'selected' : ''; ?>>Ativo</option>
                        <option value="vacation" <?php echo (isset($filters['status']) && $filters['status'] === 'vacation') ? 'selected' : ''; ?>>Férias</option>
                        <option value="blocked" <?php echo (isset($filters['status']) && $filters['status'] === 'blocked') ? 'selected' : ''; ?>>Bloqueado</option>
                        <option value="inactive" <?php echo (isset($filters['status']) && $filters['status'] === 'inactive') ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="company_id" class="form-label">Empresa</label>
                    <select class="form-select" id="company_id" name="company_id">
                        <option value="">Todas as Empresas</option>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?php echo $company->id; ?>" <?php echo (isset($filters['company_id']) && $filters['company_id'] == $company->id) ? 'selected' : ''; ?>>
                                <?php echo $company->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="unit_id" class="form-label">Unidade</label>
                    <select class="form-select" id="unit_id" name="unit_id">
                        <option value="">Todas as Unidades</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?php echo $unit->id; ?>" <?php echo (isset($filters['unit_id']) && $filters['unit_id'] == $unit->id) ? 'selected' : ''; ?>>
                                <?php echo $unit->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                    <a href="/employees" class="btn btn-secondary me-2">
                        <i class="fas fa-times me-2"></i>Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Employees Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Funcionários</h5>
    </div>
    <div class="card-body">
        <?php if (empty($employees)): ?>
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Nenhum funcionário encontrado</h5>
                <p class="text-muted">Tente ajustar seus filtros ou adicione um novo funcionário.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Cargo</th>
                            <th>Unidade</th>
                            <th>Empresa</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $employee->name; ?></strong>
                                    <br><small class="text-muted"><?php echo ucfirst($employee->access_level); ?> Acesso</small>
                                </td>
                                <td><?php echo $employee->cpf; ?></td>
                                <td><?php echo $employee->email; ?></td>
                                <td><?php echo $employee->position; ?></td>
                                <td><?php echo $employee->unit_name; ?></td>
                                <td><?php echo $employee->company_name; ?></td>
                                <td>
                                    <span class="badge status-<?php echo $employee->status; ?>">
                                        <?php echo ucfirst($employee->status); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/employees/view/<?php echo $employee->id; ?>" class="btn btn-sm btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/employees/edit/<?php echo $employee->id; ?>" class="btn btn-sm btn-outline-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Excluir" 
                                                onclick="showDeleteModalAjax(<?php echo $employee->id; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <?php if ($employee->status === 'active'): ?>
                                            <a href="/employees/block/<?php echo $employee->id; ?>" class="btn btn-sm btn-outline-danger pt-2" title="Bloquear">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                            <a href="/employees/vacation/<?php echo $employee->id; ?>" class="btn btn-sm btn-outline-info" title="Definir Férias">
                                                <i class="fas fa-umbrella-beach"></i>
                                            </a>
                                        <?php elseif ($employee->status === 'blocked'): ?>
                                            <a href="/employees/unblock/<?php echo $employee->id; ?>" class="btn btn-sm btn-outline-success" title="Desbloquear">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        <?php elseif ($employee->status === 'vacation'): ?>
                                            <a href="/employees/end_vacation/<?php echo $employee->id; ?>" class="btn btn-sm btn-outline-success" title="Encerrar Férias">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
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
    unitSelect.innerHTML = '<option value="">Todas as Unidades</option>';
    
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
</script>

<!-- Modal Container for AJAX Content -->
<div id="modalContainer"></div>

<!-- Test Button (temporary) -->
<div class="text-center mt-3 mb-3">
</div>

<style>
/* Essential modal button styling */
#modalContainer .modal .btn {
    position: relative;
    z-index: 1051;
    cursor: pointer;
    pointer-events: auto;
    user-select: none;
}

#modalContainer .modal .btn-close {
    z-index: 1052;
    cursor: pointer;
    pointer-events: auto;
}

#modalContainer .modal {
    z-index: 1050;
}

#modalContainer .modal-backdrop {
    z-index: 1040;
}

/* Ensure buttons are visible and clickable */
#modalContainer .modal .btn:hover {
    opacity: 0.9;
}

#modalContainer .modal .btn:active {
    transform: translateY(1px);
}
</style>

<script>
// AJAX-based delete modal system
function showDeleteModalAjax(employeeId) {
    console.log('showDeleteModalAjax called with employeeId:', employeeId);
    
    // Show loading state
    const modalContainer = document.getElementById('modalContainer');
    modalContainer.innerHTML = `
        <div class="modal fade show" id="loadingModal" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 mb-0">Carregando confirmação de exclusão...</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    `;
    
    // Fetch modal content via AJAX
    fetch(`/employees/get_delete_modal/${employeeId}`)
        .then(response => {
            console.log('AJAX response status:', response.status);
            if (!response.ok) {
                throw new Error('Failed to load modal');
            }
            return response.text();
        })
        .then(html => {
            console.log('Modal HTML received, length:', html.length);
            // Replace loading modal with actual modal content
            modalContainer.innerHTML = html;
            
            // Get the modal element
            const modal = document.getElementById('deleteModal');
            if (modal) {
                console.log('Modal element found, setting up event listeners...');
                
                // Setup event listeners BEFORE showing the modal
                setupModalEventListeners(modal);
                
                // Create and show the Bootstrap modal
                const bootstrapModal = new bootstrap.Modal(modal, {
                    backdrop: 'static',
                    keyboard: false
                });
                
                // Store the modal instance for later use
                modal.bootstrapModal = bootstrapModal;
                
                console.log('Bootstrap modal created, showing...');
                // Show the modal
                bootstrapModal.show();
                
                // Ensure modal is visible and properly positioned
                setTimeout(() => {
                    console.log('Modal should be visible now');
                    console.log('Modal display style:', modal.style.display);
                    console.log('Modal classes:', modal.className);
                    
                    // Check if buttons are accessible
                    const closeBtn = modal.querySelector('.btn-close');
                    const cancelBtn = modal.querySelector('.btn-secondary');
                    const deleteBtn = modal.querySelector('.btn-danger');
                    
                    console.log('Close button:', closeBtn);
                    console.log('Cancel button:', cancelBtn);
                    console.log('Delete button:', deleteBtn);
                    
                    if (closeBtn) console.log('Close button styles:', window.getComputedStyle(closeBtn));
                    if (cancelBtn) console.log('Cancel button styles:', window.getComputedStyle(cancelBtn));
                    if (deleteBtn) console.log('Delete button styles:', window.getComputedStyle(deleteBtn));
                }, 500);
            } else {
                console.error('Modal element not found after HTML insertion');
            }
        })
        .catch(error => {
            console.error('Error loading delete modal:', error);
            // Show error message
            modalContainer.innerHTML = `
                <div class="modal fade show" id="errorModal" tabindex="-1" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Erro</h5>
                                <button type="button" class="btn-close btn-close-white" onclick="closeErrorModal()"></button>
                            </div>
                            <div class="modal-body text-center py-4">
                                <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                                <p>Falha ao carregar confirmação de exclusão. Por favor, tente novamente.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="closeErrorModal()">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            `;
        });
}

// Setup event listeners for the modal
function setupModalEventListeners(modal) {
    console.log('Setting up modal event listeners...');
    
    // Remove any existing event listeners first
    const newModal = modal.cloneNode(true);
    modal.parentNode.replaceChild(newModal, modal);
    const freshModal = document.getElementById('deleteModal');
    
    // Close button (X button)
    const closeButton = freshModal.querySelector('.btn-close');
    if (closeButton) {
        console.log('Close button found, adding event listener');
        closeButton.addEventListener('click', function(e) {
            console.log('Close button clicked');
            e.preventDefault();
            e.stopPropagation();
            closeModal(freshModal);
        });
    } else {
        console.log('Close button not found');
    }
    
    // Cancel button
    const cancelButton = freshModal.querySelector('.btn-secondary');
    if (cancelButton) {
        console.log('Cancel button found, adding event listener');
        cancelButton.addEventListener('click', function(e) {
            console.log('Cancel button clicked');
            e.preventDefault();
            e.stopPropagation();
            closeModal(freshModal);
        });
    } else {
        console.log('Cancel button not found');
    }
    
    // Form submission
    const deleteForm = freshModal.querySelector('form');
    if (deleteForm) {
        console.log('Delete form found, adding event listener');
        deleteForm.addEventListener('submit', function(e) {
            console.log('Delete form submitted');
            e.preventDefault();
            e.stopPropagation();
            
            // Show confirmation
            if (confirm('Tem certeza absoluta que deseja excluir este funcionário? Esta ação não pode ser desfeita.')) {
                // Submit the form
                this.submit();
            }
        });
    } else {
        console.log('Delete form not found');
    }
    
    // Modal hidden event
    freshModal.addEventListener('hidden.bs.modal', function() {
        console.log('Modal hidden event triggered');
        // Clean up modal container
        const modalContainer = document.getElementById('modalContainer');
        if (modalContainer) {
            modalContainer.innerHTML = '';
        }
    });
    
    // Click outside modal to close
    freshModal.addEventListener('click', function(e) {
        if (e.target === freshModal) {
            console.log('Clicked outside modal');
            closeModal(freshModal);
        }
    });
    
    // ESC key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            console.log('ESC key pressed');
            closeModal(freshModal);
        }
    });
    
    console.log('Modal event listeners setup completed');
}

// Function to close the modal
function closeModal(modal) {
    if (modal && modal.bootstrapModal) {
        modal.bootstrapModal.hide();
    } else {
        // Fallback: manually hide modal
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
        
        // Remove backdrop
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
        
        // Clean up modal container
        const modalContainer = document.getElementById('modalContainer');
        if (modalContainer) {
            modalContainer.innerHTML = '';
        }
    }
}

// Close error modal
function closeErrorModal() {
    const modalContainer = document.getElementById('modalContainer');
    if (modalContainer) {
        modalContainer.innerHTML = '';
    }
}

</script> 