@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Perfiles</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

            <div class="card collapsed-card card-outline" style="border-top:3px solid #f38651">
                      <div class="card-header">
                                <h3 class="card-title">&nbsp;</h3>

                                <div class="card-tools" >
                                  @if (hasAccess("perfiles-alta"))
                                  <a href="{!! route('roles.create') !!}" class="btn btn-sm" style="background-color: #f38651;border-color: #f38651;color:#fff;">
                                    <i class="fa fa-plus"></i>&nbsp;Nuevo
                                  </a>
                                  @endif
                                  <a href="{!! route('roles.export') !!}" class="btn btn-sm"  style="background-color: #f38651;border-color: #f38651;color:#fff;">
                                    <i class="fa fa-download"></i>&nbsp;Exportar
                                  </a>                  
                                  <button type="button" class="btn btn-sm" data-widget="collapse"  style="background-color: #f38651;border-color: #f38651;color:#fff;">
                                    <i class="fa fa-filter"></i>&nbsp;Filtrar
                                  </button>                  

                                </div>
                                <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                            <form>
                                <div class="row">
                                  <div class="col-4">
                                        <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" id="name" name="name" class="form-control" value="{!! $filtros["name"] !!}">
                                        </div>
                                  </div>
                                </div>
                                <input type="hidden" name="page" value="1">
                                <div class="row">
                                        <div class="col-12">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-search"></i>&nbsp;Buscar
                                                </button>
                                        </div>
                                </div>       
                                </form>         
                      </div>
                      <!-- /.card-body -->
            </div>
            <div class="card card-default card-outline">
                <div class="card-body" style="padding: 0;">
                        <div class="table-responsive">
                            @include('admin.roles.table')

                        </div>
                        
                </div>
                <div class="card-footer clearfix text-center">
                <?php echo $roles->appends(request()->except('page'))->links(); ?>
              </div>
        </div>




      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
@endsection  