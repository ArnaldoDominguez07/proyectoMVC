<?php
/**
 * Página de Inicio - Dashboard Profesional de Supermercado
 * Proyecto Académico de Inventarios - AcademiaAds
 */

// Incluimos la conexión y el modelo de productos para obtener estadísticas reales
include_once("conexion.php");
include_once("modelos/producto.php");
$listaProductos = Producto::consultarProductos();
$totalProductos = count($listaProductos);

// Calcular categorías únicas
$categorias = array();
foreach($listaProductos as $p) {
    if(!in_array($p->tipoProducto, $categorias)) {
        $categorias[] = $p->tipoProducto;
    }
}
$totalCategorias = count($categorias);

// Simular productos con bajo stock (para fines académicos y visuales)
$bajoStock = array();
foreach($listaProductos as $idx => $p) {
    if($idx % 3 == 0) { // Simulación de lógica de bajo stock
        $bajoStock[] = $p;
    }
    if(count($bajoStock) >= 5) break;
}
?>

<!-- Importar Google Fonts e Iconos -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<style>
    :root {
        --primary-color: #0056b3;
        --secondary-color: #ffc107;
        --accent-green: #28a745;
        --dark-bg: #1a1a1a;
        --light-gray: #f8f9fa;
        --glass-bg: rgba(255, 255, 255, 0.95);
        --shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f0f2f5;
        color: #333;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        height: 400px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
        background: url('<?php echo constant('URL_BASE'); ?>vistas/recursos/images/hero_supermarket.png') center/cover no-repeat;
        box-shadow: var(--shadow);
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
        display: flex;
        align-items: center;
        padding: 0 4rem;
    }

    .hero-content {
        max-width: 600px;
        color: white;
    }

    .hero-content h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero-content p {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .badge-academy {
        background: var(--secondary-color);
        color: #000;
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        display: inline-block;
        margin-bottom: 1rem;
    }

    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1.2rem;
    }

    .icon-products { background: rgba(0, 86, 179, 0.1); color: var(--primary-color); }
    .icon-alerts { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .icon-cats { background: rgba(40, 167, 69, 0.1); color: var(--accent-green); }
    .icon-users { background: rgba(108, 117, 125, 0.1); color: #6c757d; }

    .stat-info h3 {
        margin: 0;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .stat-info p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Quick Actions */
    .action-panel {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .section-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        color: #2c3e50;
    }

    .section-title i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .action-btn {
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        border: 1px solid #eee;
        background: #fff;
    }

    .action-btn:hover {
        background: var(--primary-color);
        color: white !important;
        border-color: var(--primary-color);
        transform: scale(1.02);
    }

    .action-btn i {
        font-size: 2rem;
        margin-bottom: 0.8rem;
        display: block;
    }

    /* Table Customization */
    .custom-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }

    .custom-table thead {
        background: #f1f3f5;
    }

    .custom-table th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        color: #555;
    }

    .custom-table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .stock-badge {
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .bg-low { background: #fff3cd; color: #856404; }
</style>

<div class="container-fluid mt-4 px-4">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <span class="badge-academy">Proyecto Académico MVC</span>
                <h1>Supermercado AcademiaAds</h1>
                <p>Gestiona el inventario de tu tienda con eficiencia, control total de existencias y reportes detallados en tiempo real.</p>
                <div class="d-flex gap-3">
                    <a href="<?php echo constant('URL_BASE'); ?>productos/mostrar" class="btn btn-warning btn-lg px-4" style="border-radius: 30px; font-weight: 700;">Ver Productos</a>
                    <a href="<?php echo constant('URL_BASE'); ?>paginas/servicios" class="btn btn-outline-light btn-lg px-4" style="border-radius: 30px; font-weight: 600;">Servicios</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Dashboard -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-products">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalProductos; ?></h3>
                    <p>Productos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-alerts">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo count($bajoStock); ?></h3>
                    <p>Bajo Stock</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-cats">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $totalCategorias; ?></h3>
                    <p>Categorías</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-users">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>2</h3>
                    <p>Usuarios</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="action-panel h-100">
                <h2 class="section-title"><i class="fa-solid fa-bolt"></i> Acciones Rápidas</h2>
                <div class="row g-3">
                    <div class="col-6">
                        <a href="<?php echo constant('URL_BASE'); ?>productos/crear" class="action-btn text-dark">
                            <i class="fa-solid fa-circle-plus text-primary"></i>
                            Nuevo Producto
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo constant('URL_BASE'); ?>productos/mostrar" class="action-btn text-dark">
                            <i class="fa-solid fa-barcode text-success"></i>
                            Ver Catálogo
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="action-btn text-dark">
                            <i class="fa-solid fa-truck-moving text-warning"></i>
                            Proveedores
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo constant('URL_BASE'); ?>paginas/registro" class="action-btn text-dark">
                            <i class="fa-solid fa-user-gear text-info"></i>
                            Configuración
                        </a>
                    </div>
                </div>
                <div class="mt-4 p-3 bg-light rounded text-center">
                    <small class="text-muted">Sistema Optimizado para <strong>Administradores</strong></small>
                </div>
            </div>
        </div>

        <!-- Inventory Alerts -->
        <div class="col-lg-8">
            <div class="action-panel h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h2 class="section-title mb-0"><i class="fa-solid fa-bell text-danger"></i> Alertas de Reabastecimiento</h2>
                    <span class="badge bg-danger rounded-pill">Crítico</span>
                </div>
                <p class="text-muted small mb-4">Productos que requieren atención inmediata por bajo nivel de existencias.</p>
                
                <div class="table-responsive">
                    <table class="table custom-table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Presentación</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($bajoStock as $p): ?>
                            <tr>
                                <td class="fw-bold text-primary"><?php echo $p->codProducto; ?></td>
                                <td><?php echo $p->nombreProducto; ?></td>
                                <td><?php echo $p->presentacionProducto; ?></td>
                                <td><span class="badge bg-light text-dark border"><?php echo $p->tipoProducto; ?></span></td>
                                <td><span class="stock-badge bg-low">Por Agotar</span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if(count($bajoStock) == 0): ?>
                    <div class="text-center py-4">
                        <i class="fa-solid fa-circle-check text-success fa-3x mb-3"></i>
                        <p>No hay alertas de stock pendientes.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Micro-interacciones para mejorar UX
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.querySelector('.stat-icon i').classList.add('fa-bounce');
        });
        card.addEventListener('mouseleave', () => {
            card.querySelector('.stat-icon i').classList.remove('fa-bounce');
        });
    });
</script>