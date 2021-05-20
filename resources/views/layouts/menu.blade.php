<li class="nav-item">
  <a href="{!! route('empresas.index') !!}" class="nav-link {{ Request::is('admin/solicitudes*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-industry"></i>
    <p style="text-transform: uppercase;">
      Empresas
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="{!! route('datosDdjj.index') !!}" class="nav-link {{ Request::is('admin/datosDdjj*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-table"></i>
    <p style="text-transform: uppercase;">
      Datos DDJJ
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="{!! route('proceso_bajar_archivos.index') !!}" class="nav-link {{ Request::is('admin/proceso_bajar_archivos*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-calendar-alt"></i>
    <p style="text-transform: uppercase;">
      Proceso - Bajar Arch.
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="{!! route('proceso_procesar_archivos.index') !!}" class="nav-link {{ Request::is('admin/proceso_procesar_archivos*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-calendar-alt"></i>
    <p style="text-transform: uppercase;">
      Proceso - Proc. Arch.
    </p>
  </a>
</li>


<li class="nav-item">
  <a href="{!! route('usuarios_api.index') !!}" class="nav-link {{ Request::is('admin/usuarios_api*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-users"></i>
    <p style="text-transform: uppercase;">
      Usuarios Api
    </p>
  </a>
</li>

<!--

<li class="nav-item has-treeview {{ Request::is('admin/parametros*') || Request::is('admin/parametros*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-sliders-h"></i>
    <p style="text-transform: uppercase;">
      Parametros
      <i class="right fa fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a style="padding-left: 20px;" href="" class="nav-link {{ Request::is('admin/parametros/1*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon" style="font-size: 12px"></i>
        <p>Rangos de Edad</p>
      </a>
    </li>
    <li class="nav-item">
      <a style="padding-left: 20px;" href="" class="nav-link {{ Request::is('admin/parametros/2*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon" style="font-size: 12px"></i>
        <p>Beneficios Anses</p>
      </a>
    </li>
    <li class="nav-item">
      <a style="padding-left: 20px;" href="" class="nav-link {{ Request::is('admin/parametros/3*') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon" style="font-size: 12px"></i>
        <p>Provincias inhabilitadas</p>
      </a>
    </li>
    
  </ul>          
</li>
<li class="nav-item has-treeview {{ Request::is('admin/reportes*') || Request::is('admin/reportes*') ? 'menu-open' : '' }}">
  <a href="#" class="nav-link">
    <i class="nav-icon far fa-file-alt"></i>
    <p style="text-transform: uppercase;">
      Reportes
      <i class="right fa fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a style="padding-left: 20px;" href="" class="nav-link {{ Request::is('admin/reportes/nivel_demanda') ? 'active' : '' }}">
        <i class="far fa-circle nav-icon" style="font-size: 12px"></i>
        <p>Nivel de demanda</p>
      </a>
    </li>
    <li class="nav-item">
        <a style="padding-left: 20px;" href="" class="nav-link {{ Request::is('admin/reportes/tipo_haberes') ? 'active' : '' }}">
          <i class="far fa-circle nav-icon" style="font-size: 12px"></i>
          <p>Tipo de haberes</p>
        </a>
    </li>
    
  </ul>          
</li>
<li class="nav-item">
  <a href="" class="nav-link {{ Request::is('admin/comercializadores*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-user-tie"></i>
    <p style="text-transform: uppercase;">
      Comercializadores
    </p>
  </a>
</li>
-->
<li class="nav-item">
  <a href="{!! route('users.index') !!}" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-users-cog"></i>
    <p style="text-transform: uppercase;">
      Usuarios del sistema
    </p>
  </a>
</li>
