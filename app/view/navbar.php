<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="<?= _SERVER_ ?>" class="app-brand-link">
                    <span class="app-brand-logo demo">
                  <img src="<?php echo _SERVER_ . _ICON_;?>" style="margin-left: 16px; width: 8%;" alt="Logo"/>
              </span>
                </a>
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>
            <div class="menu-inner-shadow"></div>
            <ul class="menu-inner py-1" style="margin-top: 15px;">
                <!-- Dashboard -->
                <li class="menu-item ">
                    <a href="<?= _SERVER_ ?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Inicio</div>
                    </a>
                </li>
                <?php
                $raioz = 1;
                $restricciones = $this->nav->listar_restricciones($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
                foreach ($navs as $nav){
                    $active = "";
                    $active_o = "";
                    if($nav->menu_controlador == $_SESSION['controlador']){
                        $active = "active";
                        $active_o = "open";
                        $_SESSION['controlador'] = $nav->menu_nombre;
                        $_SESSION['icono'] = $nav->menu_icono;
                    }?>
                    <li class="menu-item <?= $active;?> <?= $active_o;?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="<?= $nav->menu_icono;?> "></i>
                            <div data-i18n="Layouts"><?= $nav->menu_nombre;?></div>
                        </a>
                        <ul class="menu-sub">
                            <?php
                            $option = $this->nav->listar_opciones($nav->id_menu);
                            foreach ($option as $o){
                                ($_SESSION['accion']==$o->opcion_funcion)?$active_ = "active":$active_ = "";;
                                $mostrar = true;
                                foreach ($restricciones as $r){
                                    if($r->id_opcion == $o->id_opcion){
                                        $mostrar = false;
                                    }
                                }
                                if($mostrar){
                                    ?>
                                    <li class="menu-item <?= $active_;?> ">
                                        <a href="<?= _SERVER_. $nav->menu_controlador . '/'. $o->opcion_funcion;?>" class="menu-link">
                                            <div data-i18n="<?= $o->opcion_nombre;?>"><?= $o->opcion_nombre;?></div>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                    $raioz++;
                }
                ?>
            </ul>
        </aside>
        <div class="layout-page">
            <nav style="margin-bottom: 15px" class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                 id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <h3 class="text-primary" style="margin-top: 15px; margin-left: 200px">SISTEMA DE VENTA DE TIENDA VARGAS</h3>
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <li class="nav-item lh-1 me-3">
                        </li>
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img class="img-profile rounded-circle" src="<?= _SERVER_ . $this->encriptar->desencriptar($_SESSION['u_i'],_FULL_KEY_);?>">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img src="<?= _SERVER_ . $this->encriptar->desencriptar($_SESSION['u_i'],_FULL_KEY_);?>" alt class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block"><?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_);?></span>
                                                <small class="text-muted"><?= $this->encriptar->desencriptar($_SESSION['rn'],_FULL_KEY_);?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= _SERVER_;?>Admin/finalizar_sesion">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Cerrar Sesión</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>


