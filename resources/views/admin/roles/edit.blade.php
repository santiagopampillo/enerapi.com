@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Perfil</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <div class="content">
       @include('adminlte-templates::common.errors')
       {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'patch']) !!}
        <div class="card card-outline" style="border-top:3px solid #f38651">
            <div class="card-header">
                <h3 class="card-title">&nbsp;Editar Perfil</h3>          
            </div>
            @include('admin.roles.fields')

        </div>
        <div class="card">
            <div class="card-header d-flex p-0 ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title p-3">
                  &nbsp;Permisos
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <?php $active="active";?>  
                  @foreach ($modulos as $modulo)
                      <li class="nav-item">
                        <a class="nav-link {!! $active !!}" href="#modulo-{!! $modulo->id !!}" data-toggle="tab">{!! $modulo->nombre !!}</a>
                      </li>
                      <?php $active="";?>  
                  @endforeach
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                  <?php $active="active";?>  
                  @foreach ($modulos as $modulo)
                        <div class="tab-pane {!! $active !!}" id="modulo-{!! $modulo->id !!}">
                            @foreach ($modulo->permisos as $permiso)
                                <div class="form-check">
                                  <input class="form-check-input" id="permiso_{!! $permiso->id !!}" type="checkbox" name="permisos[]" value="{!! $permiso->id !!}" @if (old('id')!="") @if(is_array(old('permisos'))) @if (in_array($permiso->id, old('permisos'))) checked @endif @endif @else @if($role->permisos->contains($permiso->id)) checked @endif @endif>
                                  <label class="form-check-label" for="permiso_{!! $permiso->id !!}">{!! $permiso->descripcion !!}</label>
                                </div>
                            @endforeach
                        </div>
                        <?php $active="";?>  
                  @endforeach
                </div>
            </div>
            <div class="card-footer text-right">
                {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
                <a href="{!! route('roles.index') !!}" class="btn btn-sm btn-info">Cancelar</a>
            </div>
        </div>
        {!! Form::close() !!}
   </div>
@endsection