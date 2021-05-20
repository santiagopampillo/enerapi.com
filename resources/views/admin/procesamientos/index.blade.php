@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Procesamientos</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

            <div class="card collapsed-card card-outline" style="border-top:3px solid #42739e">
                      <div class="card-header">
                                <h3 class="card-title">&nbsp;</h3>

                                <div class="card-tools" >
                                        <!--
                                          <a href="{!! route('datosDdjj.create') !!}" class="btn btn-sm" style="background-color: #42739e;border-color: #42739e;color:#fff;">
                                            <i class="fa fa-plus"></i>&nbsp;Nuevo
                                          </a>
                                        -->
                                          <button type="button" class="btn btn-sm" data-widget="collapse"  style="background-color: #42739e;border-color: #42739e;color:#fff;">
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
                                          <label>Codigo</label>
                                          <input type="text" id="codigo" name="codigo" class="form-control" value="{!! $filtros["codigo"] !!}">
                                      </div>
                                </div>
                                <div class="col-4">
                                      <div class="form-group">
                                          <label>Año</label>
                                          <input type="text" id="anio" name="anio" class="form-control" value="{!! $filtros["anio"] !!}">
                                      </div>
                                </div>
                                <div class="col-4">
                                      <div class="form-group">
                                          <label>Mes</label>
                                          <input type="text" id="mes" name="mes" class="form-control" value="{!! $filtros["mes"] !!}">
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
                            @include('admin.procesamientos.table')

                        </div>
                        
                </div>
                <div class="card-footer clearfix text-center">
                <?php echo $registros->appends(request()->except('page'))->links(); ?>
              </div>
        </div>




      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
@endsection  
@section('scripts')
    <script src="{{ asset('js/admin/index.js')}}"></script>
@endsection