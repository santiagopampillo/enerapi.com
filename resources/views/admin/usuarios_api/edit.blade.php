@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{!! asset('plugins/datepicker/datepicker3.css') !!}">
@endsection
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Usuarios para Api</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <div class="content">
       @include('adminlte-templates::common.errors')

        <div class="card card-outline" style="border-top:3px solid #42739e">
            <div class="card-header">
                <h3 class="card-title">&nbsp;Editar</h3>          
            </div>
            {!! Form::model($registro, ['route' => ['usuarios_api.update', $registro->id], 'method' => 'patch']) !!}
            @include('admin.usuarios_api.fields')
            {!! Form::close() !!}

        </div>
   </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{!! asset('plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('plugins/datepicker/locales/bootstrap-datepicker.es.js') !!}"></script>
    <script>
      $(function(){
          $( "#fecha_desde" ).datepicker({ format: 'dd/mm/yyyy', autoclose: true,  language: 'es' });
          $( "#fecha_hasta" ).datepicker({ format: 'dd/mm/yyyy', autoclose: true,  language: 'es' });
      });
    </script>
@endsection