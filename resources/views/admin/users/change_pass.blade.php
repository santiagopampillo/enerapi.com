@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Usuario</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <div class="content">
       @include('adminlte-templates::common.errors')

        <div class="card card-outline" style="border-top:3px solid #42739e">
            <div class="card-header">
                <h3 class="card-title">&nbsp;Cambiar Password Usuario</h3>          
            </div>
            {!! Form::model($user, ['route' => ['users.update', $user->id], 'id' => 'frm', 'method' => 'patch']) !!}
            {!! Form::hidden('id') !!}
            {!! Form::hidden('first_name') !!}
            {!! Form::hidden('last_name') !!}
            {!! Form::hidden('email') !!}
            {!! Form::hidden('rol_id') !!}
              <div class="card-body">
                <div class="row">
                    <!-- Contact Name Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('password', 'Contraseña:') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>

                    <!-- Contact Lastname Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('password_confirmation', 'Confirmar contraseña:') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>
              </div>
              <div class="card-footer text-right">
                  {!! Form::submit('Guardar', ['class' => 'btn btn-sm btn-success']) !!}
                  <a href="{!! route('users.index') !!}" class="btn btn-sm btn-info">Cancelar</a>
              </div>
            {!! Form::close() !!}

        </div>
   </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/users_change_pass.js') }}"></script>
@endsection
