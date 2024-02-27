<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand" style="font-size: 16px;">
      <span>RE</span>CLUTAMIENTO
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Principal</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>

      <?php if($roles_permisos[1]->permitido == 1 || $roles_permisos[2]->permitido == 1){ ?>
      <li class="nav-item nav-category">COMPONENTES</li>
      <?php } ?>
      <?php if($roles_permisos[1]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['clientes']) }}">
        <a href="{{ url('/clientes') }}" class="nav-link">
          <i class="link-icon" data-feather="command"></i>
          <span class="link-title">Clientes</span>
        </a>
      </li>
      <?php } ?>
      <?php if($roles_permisos[2]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['candidatos']) }}">
        <a href="{{ url('/candidatos') }}" class="nav-link">
          <i class="link-icon" data-feather="droplet"></i>
          <span class="link-title">Candidatos</span>
        </a>
      </li>
      <?php } ?>

      <?php if($roles_permisos[0]->permitido == 1 || $roles_permisos[3]->permitido == 1 || 
               $roles_permisos[4]->permitido == 1 || $roles_permisos[9]->permitido == 1){ ?>
      <li class="nav-item nav-category">ADMINISTRACION</li>
      <?php } ?>
      <?php if($roles_permisos[0]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['usuarios']) }}">
        <a href="{{ url('/usuarios') }}" class="nav-link">
          <i class="link-icon" data-feather="users"></i>
          <span class="link-title">Usuarios</span>
        </a>
      </li>
      <?php } ?>
      <!--<li class="nav-item {{ active_class(['reclutador']) }}">
        <a href="{{ url('/reclutador') }}" class="nav-link">
          <i class="link-icon" data-feather="tag"></i>
          <span class="link-title">Reclutador</span>
        </a>
      </li>-->
      <?php if($roles_permisos[3]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['requerimiento']) }}">
        <a href="{{ url('/requerimiento') }}" class="nav-link">
          <i class="link-icon" data-feather="trello"></i>
          <span class="link-title">Requerimiento</span>
        </a>
      </li>
      <?php } ?>
      <?php if($roles_permisos[4]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['reportes']) }}">
        <a href="{{ url('/reporte') }}" class="nav-link">
          <i class="link-icon" data-feather="tablet"></i>
          <span class="link-title">Reportes</span>
        </a>
      </li>
      <?php } ?>
      <?php if($roles_permisos[9]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['rolesperfiles']) }}">
        <a href="{{ url('/rolesperfiles') }}" class="nav-link">
          <i class="link-icon" data-feather="unlock"></i>
          <span class="link-title">Roles y permisos</span>
        </a>
      </li>
      <?php } ?>

      <?php if($roles_permisos[6]->permitido == 1 || $roles_permisos[7]->permitido == 1 || 
               $roles_permisos[8]->permitido == 1){ ?>
      <li class="nav-item nav-category">CATALOGOS</li>
      <?php } ?>
      <?php if($roles_permisos[6]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['ciudad']) }}">
        <a href="{{ url('/ciudad') }}" class="nav-link">
          <i class="link-icon" data-feather="map"></i>
          <span class="link-title">Ciudad</span>
        </a>
      </li>
      <?php } ?>
      <?php if($roles_permisos[7]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['especialidad']) }}">
        <a href="{{ url('/especialidad') }}" class="nav-link">
          <i class="link-icon" data-feather="trending-up"></i>
          <span class="link-title">Especialidad</span>
        </a>
      </li>
      <?php } ?>
      <?php if($roles_permisos[10]->permitido == 1){ ?>
        <li class="nav-item {{ active_class(['perfiles']) }}">
          <a href="{{ url('/perfiles') }}" class="nav-link">
            <i class="link-icon" data-feather="layers"></i>
            <span class="link-title">Perfiles</span>
          </a>
        </li>
        <?php } ?>
      <?php if($roles_permisos[8]->permitido == 1){ ?>
      <li class="nav-item {{ active_class(['serviciorequerido']) }}">
        <a href="{{ url('/serviciorequerido') }}" class="nav-link">
          <i class="link-icon" data-feather="server"></i>
          <span class="link-title">Servicios requeridos</span>
        </a>
      </li>
      <?php } ?>


      <!-- extra data -->
    
    </ul>
  </div>
</nav>
<!--<nav class="settings-sidebar">
  <div class="sidebar-body">
    <a href="#" class="settings-sidebar-toggler">
      <i data-feather="settings"></i>
    </a>
    <h6 class="text-muted mb-2">Sidebar:</h6>
    <div class="mb-3 pb-3 border-bottom">
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
          Light
        </label>
      </div>
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
          Dark
        </label>
      </div>
    </div>
    <div class="theme-wrapper">
      <h6 class="text-muted mb-2">Light Version:</h6>
      <a class="theme-item active" href="https://www.nobleui.com/laravel/template/demo1/">
        <img src="{{ url('assets/images/screenshots/light.jpg') }}" alt="light version">
      </a>
      <h6 class="text-muted mb-2">Dark Version:</h6>
      <a class="theme-item" href="https://www.nobleui.com/laravel/template/demo2/">
        <img src="{{ url('assets/images/screenshots/dark.jpg') }}" alt="light version">
      </a>
    </div>
  </div>
</nav>
-->