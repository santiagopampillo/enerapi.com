@extends('layouts.app')

@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Datos DDJJ</h1>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <?php if(is_null($registros) && isset($_REQUEST["page"])) { ?>
        <ul class="alert alert-danger" style="list-style-type: none">
              <li>Debe completar algun campo de busqueda.</li>
        </ul>
      <?php } ?>
      <div class="container-fluid">

            <div class="card card-outline" style="border-top:3px solid #42739e">
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
                                          <label>Empresa</label>
                                          <!--<input type="text" id="empresa" name="empresa" class="form-control" value="{!! $filtros["empresa"] !!}">-->
                                          <select id="empresa" name="empresa" class="form-control" >
                                            <option value="">Seleccionar</option>
                                            <?php 
                                            foreach ($empresas as $item) {
                                              $sel="";
                                              if($item->id == $filtros["empresa"]) $sel=" selected ";
                                            ?>
                                              <option value="<?php echo $item->id;?>" <?php echo $sel;?>><?php echo $item->nombre;?></option>
                                            <?php 
                                            } 
                                            ?>
                                          </select>
                                      </div>
                                </div>
                                <div class="col-4">
                                      <div class="form-group">
                                          <label>Pozo (siglas)</label>
                                          <input type="text" id="sigla" name="sigla" class="form-control" value="{!! $filtros["sigla"] !!}">
                                      </div>
                                </div>
                                <div class="col-4">
                                      <div class="form-group">
                                          <label>Cuenca</label>
                                          <input type="text" id="cuenca" name="cuenca" class="form-control" value="{!! $filtros["cuenca"] !!}">
                                      </div>
                                </div>
                                <div class="col-4">
                                      <div class="form-group">
                                          <label>Mes</label>
                                          <select id="mes" name="mes" class="form-control" >
                                            <option value="">Seleccionar</option>
                                            <?php 
                                            for($i=1;$i<=12;$i++){
                                              $sel="";
                                              if($i == $filtros["mes"]) $sel=" selected ";
                                            ?>
                                              <option value="<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?></option>
                                            <?php 
                                            } 
                                            ?>
                                          </select>
                                      </div>
                                </div>
                                <div class="col-3">
                                      <div class="form-group">
                                          <label>Año</label>
                                          <select id="anio" name="anio" class="form-control" >
                                            <option value="">Seleccionar</option>
                                            <?php 
                                            for($i=2019;$i<=date('Y');$i++){
                                              $sel="";
                                              if($i == $filtros["anio"]) $sel=" selected ";
                                            ?>
                                              <option value="<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?></option>
                                            <?php 
                                            } 
                                            ?>
                                          </select>
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
            <?php if(!is_null($registros)) { ?>
            <div class="card card-default card-outline">
                <div class="card-body" style="padding: 0;">
                        <div class="table-responsive">
                            @include('admin.datosDdjj.table')
                        </div>
                        
                </div>
                <div class="card-footer clearfix text-center">
                <?php echo $registros->appends(request()->except('page'))->links(); ?>
              </div>
            <?php } ?>
        </div>




      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
@endsection  
@section('scripts')
    <script src="{{ asset('js/admin/index.js')}}"></script>
@endsection