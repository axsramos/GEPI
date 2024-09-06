<?php
    $is_visible = ($_SESSION['LOGIN_SUPER'] == 'S' ? '' : 'hidden');
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
            <div class="sb-sidenav-menu-heading">Operacional</div>
                <a class="nav-link" href="/GEPI/Dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="/GEPI/Reserve" <?=$is_visible;?>>
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    Reserva
                </a>
                <a class="nav-link" href="/GEPI/Stock" <?=$is_visible;?>>
                    <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                    Estoque
                </a>
                <div class="sb-sidenav-menu-heading" <?=$is_visible;?>>Cadastro</div>
                <a class="nav-link" href="/GEPI/Collaborator" <?=$is_visible;?>>
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Colaborador
                </a>
                <a class="nav-link" href="/GEPI/Equipment" <?=$is_visible;?>>
                    <div class="sb-nav-link-icon"><i class="fas fa-mitten"></i></div>
                    Equipamento
                </a>
                <div class="sb-sidenav-menu-heading" <?=$is_visible;?>>Relat&oacute;rios</div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts" <?=$is_visible;?>>
                    <div class="sb-nav-link-icon"><i class="fas fa-print"></i></div>
                    Relat&oacute;rio
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion" <?=$is_visible;?>>
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-sidenav-light.html">Colaborador</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Equipamento</a>
                        <a class="nav-link" href="layout-static.html">Estoque</a>
                    </nav>
                </div>                
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Conectado como:</div>
            <?=(isset($_SESSION['LOGIN_NAME']) ? $_SESSION['LOGIN_NAME'] : 'Desconectado');?>
        </div>
    </nav>
</div>