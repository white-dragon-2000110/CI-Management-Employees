<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-chart-bar me-2"></i>Painel de Relatórios
        </h1>
    </div>
</div>

<!-- Report Navigation Cards -->
<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                <h4 class="card-title">Eventos de Alarme</h4>
                <p class="card-text">Gere relatórios detalhados para alarmes de segurança e eventos do sistema com opções avançadas de filtragem.</p>
                <div class="mt-3">
                    <a href="/reports/alarms" class="btn btn-warning me-2">
                        <i class="fas fa-chart-line me-2"></i>Ver Relatório
                    </a>
                    <a href="/reports/alarms?export=csv" class="btn btn-outline-warning">
                        <i class="fas fa-download me-2"></i>Exportar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-ticket-alt fa-4x text-info mb-3"></i>
                <h4 class="card-title">Tickets de Suporte</h4>
                <p class="card-text">Acompanhe e analise o desempenho dos tickets de suporte, tempos de resolução e produtividade da equipe.</p>
                <div class="mt-3">
                    <a href="/reports/tickets" class="btn btn-info me-2">
                        <i class="fas fa-chart-bar me-2"></i>Ver Relatório
                    </a>
                    <a href="/reports/tickets?export=csv" class="btn btn-outline-info">
                        <i class="fas fa-download me-2"></i>Exportar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Overview -->
<div class="row">
    <!-- Alarm Statistics -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm alarm-card">
            <div class="card-header bg-gradient-warning text-white border-0">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Visão Geral dos Eventos de Alarme
                </h5>
                <small class="opacity-75">Insights de segurança e monitoramento do sistema</small>
            </div>
            <div class="card-body p-4">
                <div class="row text-center mb-4">
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3 class="stat-number text-primary"><?php echo $alarm_stats['total']; ?></h3>
                            <small class="stat-label">Total de Alarmes</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <h3 class="stat-number text-warning"><?php echo count($alarm_stats['by_severity']); ?></h3>
                            <small class="stat-label">Níveis de Severidade</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-icon bg-info">
                                <i class="fas fa-list-alt"></i>
                            </div>
                            <h3 class="stat-number text-info"><?php echo count($alarm_stats['by_status']); ?></h3>
                            <small class="stat-label">Tipos de Status</small>
                        </div>
                    </div>
                </div>
                
                <!-- <?php if (!empty($alarm_stats['by_severity'])): ?>
                    <div class="severity-breakdown">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-chart-pie me-2"></i>Por Severidade
                        </h6>
                        <?php foreach ($alarm_stats['by_severity'] as $severity): ?>
                            <div class="severity-item">
                                <div class="severity-info">
                                    <span class="severity-badge severity-<?php echo strtolower($severity->severity); ?>">
                                        <?php echo ucfirst($severity->severity); ?>
                                    </span>
                                    <span class="severity-count"><?php echo $severity->count; ?> events</span>
                                </div>
                                <div class="severity-bar">
                                    <div class="severity-progress severity-<?php echo strtolower($severity->severity); ?>" 
                                         style="width: <?php echo ($severity->count / $alarm_stats['total']) * 100; ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?> -->
            </div>
        </div>
    </div>
    
    <!-- Ticket Statistics -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm ticket-card">
            <div class="card-header bg-gradient-info text-white border-0">
                <h5 class="mb-0">
                    <i class="fas fa-ticket-alt me-2"></i>Visão Geral dos Tickets de Suporte
                </h5>
                <small class="opacity-75">Métricas de desempenho do suporte ao cliente</small>
            </div>
            <div class="card-body p-4">
                <div class="row text-center mb-4">
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <h3 class="stat-number text-primary"><?php echo $ticket_stats['total']; ?></h3>
                            <small class="stat-label">Total de Tickets</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-flag"></i>
                            </div>
                            <h3 class="stat-number text-warning"><?php echo count($ticket_stats['by_priority']); ?></h3>
                            <small class="stat-label">Níveis de Prioridade</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-item">
                            <div class="stat-icon bg-info">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h3 class="stat-number text-info"><?php echo count($ticket_stats['by_status']); ?></h3>
                            <small class="stat-label">Tipos de Status</small>
                        </div>
                    </div>
                </div>
                
                <!-- <?php if (!empty($ticket_stats['by_priority'])): ?>
                    <div class="priority-breakdown">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-chart-bar me-2"></i>By Priority
                        </h6>
                        <?php foreach ($ticket_stats['by_priority'] as $priority): ?>
                            <div class="priority-item">
                                <div class="priority-info">
                                    <span class="priority-badge priority-<?php echo strtolower($priority->priority); ?>">
                                        <?php echo ucfirst($priority->priority); ?>
                                    </span>
                                    <span class="priority-count"><?php echo $priority->count; ?> tickets</span>
                                </div>
                                <div class="priority-bar">
                                    <div class="priority-progress priority-<?php echo strtolower($priority->priority); ?>" 
                                         style="width: <?php echo ($priority->count / $ticket_stats['total']) * 100; ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?> -->
                
                <!-- <?php if (isset($ticket_stats['avg_resolution_hours'])): ?>
                    <div class="performance-metrics">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-clock me-2"></i>Performance Metrics
                        </h6>
                        <div class="performance-card">
                            <div class="performance-icon">
                                <i class="fas fa-stopwatch"></i>
                            </div>
                            <div class="performance-content">
                                <h4 class="performance-value"><?php echo $ticket_stats['avg_resolution_hours']; ?>h</h4>
                                <small class="performance-label">Average Resolution Time</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?> -->
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h5 class="mb-0">
                    <i class="fas fa-rocket me-2"></i>Ações Rápidas
                </h5>
                <small class="opacity-75">Acesse recursos principais do sistema instantaneamente</small>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card">
                            <a href="/reports/alarms" class="quick-action-link">
                                <div class="quick-action-icon bg-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h6 class="quick-action-title">Relatórios de Alarme</h6>
                                <p class="quick-action-desc">Visualizar análises detalhadas de alarmes</p>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card">
                            <a href="/reports/tickets" class="quick-action-link">
                                <div class="quick-action-icon bg-info">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                                <h6 class="quick-action-title">Relatórios de Tickets</h6>
                                <p class="quick-action-desc">Insights dos tickets de suporte</p>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card">
                            <a href="/employees" class="quick-action-link">
                                <div class="quick-action-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h6 class="quick-action-title">Gestão de Funcionários</h6>
                                <p class="quick-action-desc">Gerenciar membros da equipe</p>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="quick-action-card">
                            <a href="/dashboard" class="quick-action-link">
                                <div class="quick-action-icon bg-secondary">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                <h6 class="quick-action-title">Painel de Controle</h6>
                                <p class="quick-action-desc">Visão geral do sistema</p>
                                <div class="quick-action-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Quick Actions Styling */
.quick-action-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    height: 100%;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.quick-action-link {
    display: block;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    position: relative;
    height: 100%;
}

.quick-action-link:hover {
    text-decoration: none;
    color: inherit;
}

.quick-action-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.quick-action-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
    font-size: 1.1rem;
}

.quick-action-desc {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.quick-action-arrow {
    position: absolute;
    bottom: 1.5rem;
    right: 1.5rem;
    color: #6c757d;
    transition: all 0.3s ease;
}

.quick-action-card:hover .quick-action-arrow {
    color: #007bff;
    transform: translateX(3px);
}

/* Gradient backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
}

/* Statistics Cards Styling */
.alarm-card, .ticket-card {
    transition: all 0.3s ease;
    border-radius: 15px;
}

.alarm-card:hover, .ticket-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

/* Stat Items */
.stat-item {
    text-align: center;
    padding: 1rem 0.5rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.25rem;
    color: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.stat-number {
    font-weight: 700;
    margin-bottom: 0.25rem;
    font-size: 2rem;
}

.stat-label {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.85rem;
}

/* Severity Breakdown */
.severity-breakdown, .priority-breakdown {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.severity-item, .priority-item {
    margin-bottom: 1rem;
}

.severity-info, .priority-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.severity-badge, .priority-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.severity-count, .priority-count {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.9rem;
}

.severity-bar, .priority-bar {
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.severity-progress, .priority-progress {
    height: 100%;
    border-radius: 3px;
    transition: width 0.8s ease;
}

/* Severity Colors */
.severity-critical {
    background: #dc3545;
    color: white;
}

.severity-high {
    background: #fd7e14;
    color: white;
}

.severity-medium {
    background: #ffc107;
    color: #212529;
}

.severity-low {
    background: #28a745;
    color: white;
}

.severity-progress.severity-critical { background: #dc3545; }
.severity-progress.severity-high { background: #fd7e14; }
.severity-progress.severity-medium { background: #ffc107; }
.severity-progress.severity-low { background: #28a745; }

/* Priority Colors */
.priority-high {
    background: #dc3545;
    color: white;
}

.priority-medium {
    background: #ffc107;
    color: #212529;
}

.priority-low {
    background: #28a745;
    color: white;
}

.priority-progress.priority-high { background: #dc3545; }
.priority-progress.priority-medium { background: #ffc107; }
.priority-progress.priority-low { background: #28a745; }

/* Performance Metrics */
.performance-metrics {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.performance-card {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.performance-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.performance-value {
    color: #28a745;
    font-weight: 700;
    margin-bottom: 0.25rem;
    font-size: 1.75rem;
}

.performance-label {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .quick-action-card {
        margin-bottom: 1rem;
    }
    
    .quick-action-link {
        padding: 1.25rem;
    }
    
    .quick-action-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .severity-breakdown, .priority-breakdown, .performance-metrics {
        padding: 1rem;
    }
}
</style> 