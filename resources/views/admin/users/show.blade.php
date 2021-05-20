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
        <div class="card card-outline" style="border-top:3px solid #42739e">
            <div class="card-header">
                <h3 class="card-title">&nbsp;Ver Usuario</h3>          
            </div>
            @include('admin.users.show_fields')
            <div class="card-footer text-right">                
                <a href="{!! route('users.index') !!}" class="btn btn-sm btn-info">Volver</a>
            </div>            

        </div>
   </div>
@endsection