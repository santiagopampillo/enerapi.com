@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">PARÁMETROS</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <div class="content">
       @include('adminlte-templates::common.errors')
       @include('flash::message')

        <div class="card card-outline" style="border-top:3px solid #42739e">
            <div class="card-header">
                <h3 class="card-title">&nbsp;{{$registro->nombre}}</h3>          
            </div>
            {!! Form::model($registro, ['route' => ['parametros.update', $registro->id], 'id' => 'frm', 'method' => 'patch']) !!}
            <?php $include = 'admin.parametros.' . str_slug($registro->nombre); ?>
            @include($include)
            {!! Form::close() !!}

        </div>
   </div>
@endsection