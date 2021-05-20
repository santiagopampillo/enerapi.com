@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Empresa</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        @include('adminlte-templates::common.errors')
        <div class="card card-outline" style="border-top:3px solid #42739e">
            <div class="card-header">
                <h3 class="card-title">&nbsp;Nuevo</h3>          
            </div>
            {!! Form::open(['route' => 'empresas.store']) !!}
            @include('admin.empresas.fields')
            {!! Form::close() !!}

        </div>    
    </section>
@endsection

