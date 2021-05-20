@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Datos DDJJ</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <div class="content">
       @include('adminlte-templates::common.errors')

        <div class="card card-outline" style="border-top:3px solid #42739e">
          <!--
            <div class="card-header">
                <h3 class="card-title">&nbsp;Ver</h3>          
            </div>
          -->
            {!! Form::model($registro, ['route' => ['empresas.update', $registro->id], 'method' => 'patch']) !!}
            @include('admin.datosDdjj.fields')
            {!! Form::close() !!}

        </div>
   </div>
@endsection