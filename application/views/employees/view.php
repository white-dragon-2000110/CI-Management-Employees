<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user me-2"></i>Detalhes do Funcionário
            </h1>
            <div>
                <a href="/employees/edit/<?php echo $employee->id; ?>" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Editar Funcionário
                </a>
                <a href="/employees" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar aos Funcionários
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informações Pessoais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nome Completo</label>
                        <p class="form-control-plaintext"><?php echo $employee->name; ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">CPF</label>
                        <p class="form-control-plaintext"><?php echo $employee->cpf; ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <p class="form-control-plaintext"><?php echo $employee->email; ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Telefone</label>
                        <p class="form-control-plaintext"><?php echo $employee->phone; ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Cargo</label>
                        <p class="form-control-plaintext"><?php echo $employee->position; ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <span class="badge status-<?php echo $employee->status; ?>">
                            <?php echo ucfirst($employee->status); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-building me-2"></i>Informações da Empresa e Unidade</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Empresa</label>
                        <p class="form-control-plaintext"><?php echo $employee->company_name; ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Unidade</label>
                        <p class="form-control-plaintext"><?php echo $employee->unit_name; ?></p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nível de Acesso</label>
                        <span class="badge bg-<?php echo $employee->access_level === 'admin' ? 'danger' : ($employee->access_level === 'standard' ? 'primary' : 'secondary'); ?>">
                            <?php echo ucfirst($employee->access_level); ?>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID do Funcionário</label>
                        <p class="form-control-plaintext">#<?php echo $employee->id; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ($employee->photo_path): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-camera me-2"></i>Foto do Funcionário</h5>
            </div>
            <div class="card-body text-center">
                <img src="/<?php echo $employee->photo_path; ?>" 
                     alt="Foto do Funcionário" 
                     class="img-fluid rounded" 
                     style="max-width: 300px; border: 3px solid #dee2e6;">
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Cronologia</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Funcionário Criado</h6>
                            <small class="text-muted"><?php echo date('M j, Y', strtotime($employee->created_at)); ?></small>
                        </div>
                    </div>
                    
                    <?php if ($employee->updated_at != $employee->created_at): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Última Atualização</h6>
                            <small class="text-muted"><?php echo date('M j, Y', strtotime($employee->updated_at)); ?></small>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Ações Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if ($employee->status === 'active'): ?>
                        <a href="/employees/block/<?php echo $employee->id; ?>" class="btn btn-outline-danger">
                            <i class="fas fa-ban me-2"></i>Bloquear Acesso
                        </a>
                        <a href="/employees/vacation/<?php echo $employee->id; ?>" class="btn btn-outline-info">
                            <i class="fas fa-umbrella-beach me-2"></i>Definir Férias
                        </a>
                    <?php elseif ($employee->status === 'blocked'): ?>
                        <a href="/employees/unblock/<?php echo $employee->id; ?>" class="btn btn-outline-success">
                            <i class="fas fa-check me-2"></i>Desbloquear Acesso
                        </a>
                    <?php elseif ($employee->status === 'vacation'): ?>
                        <a href="/employees/end_vacation/<?php echo $employee->id; ?>" class="btn btn-outline-success">
                            <i class="fas fa-undo me-2"></i>Encerrar Férias
                        </a>
                    <?php endif; ?>
                    
                    <a href="/employee_portal/login" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt me-2"></i>Portal do Funcionário
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-shield-alt me-2"></i>Notas de Segurança</h6>
                    <ul class="mb-0">
                        <li>PINs são criptografados com segurança</li>
                        <li>Nível de acesso determina permissões</li>
                        <li>Status afeta o acesso ao sistema</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: -24px;
    top: 17px;
    width: 2px;
    height: 20px;
    background-color: #dee2e6;
}

.timeline-content h6 {
    margin: 0;
    font-size: 0.875rem;
}

.timeline-content small {
    font-size: 0.75rem;
}
</style> 