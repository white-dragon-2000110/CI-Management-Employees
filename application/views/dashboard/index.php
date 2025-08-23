
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>Painel de Controle
        </h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                <h4 class="card-title"><?php echo $employee_stats['total']; ?></h4>
                <p class="card-text text-muted">Total de Funcionários</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h4 class="card-title"><?php echo $employee_stats['active']; ?></h4>
                <p class="card-text text-muted">Funcionários Ativos</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h4 class="card-title"><?php echo $alarm_stats['total']; ?></h4>
                <p class="card-text text-muted">Eventos de Alarme</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-ticket-alt fa-3x text-info mb-3"></i>
                <h4 class="card-title"><?php echo $ticket_stats['total']; ?></h4>
                <p class="card-text text-muted">Tickets de Suporte</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Ações Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="/employees/add" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-2"></i>Adicionar Funcionário
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/employees" class="btn btn-info w-100">
                            <i class="fas fa-users me-2"></i>Gerenciar Funcionários
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/reports/alarms" class="btn btn-warning w-100">
                            <i class="fas fa-chart-bar me-2"></i>Ver Relatórios
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/employee_portal" class="btn btn-success w-100" target="_blank">
                            <i class="fas fa-user-circle me-2"></i>Portal do Funcionário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Alarmes Recentes</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($alarm_stats['by_severity'])): ?>
                    <?php foreach (array_slice($alarm_stats['by_severity'], 0, 5) as $alarm): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge severity-<?php echo strtolower($alarm->severity); ?>">
                                <?php echo ucfirst($alarm->severity); ?>
                            </span>
                            <span class="text-muted"><?php echo $alarm->count; ?> eventos</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Nenhum alarme recente</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Tickets de Suporte</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($ticket_stats['by_status'])): ?>
                    <?php foreach (array_slice($ticket_stats['by_status'], 0, 5) as $ticket): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary">
                                <?php echo ucfirst(str_replace('_', ' ', $ticket->status)); ?>
                            </span>
                            <span class="text-muted"><?php echo $ticket->count; ?> tickets</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Nenhum ticket recente</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 