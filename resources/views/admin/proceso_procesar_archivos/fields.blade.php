<div class="card-body">
    <div class="row">
        <?php $nombreEmpresa = $registro->empresa->nombre;?>
        <div class="form-group col-sm-12">
            {!! Form::label('empresa', 'Empresa:') !!}
            {!! Form::text('nombreEmpresa',$nombreEmpresa, ['class' => 'form-control', 'disabled' =>'true']) !!}
        </div>

        <?php
        foreach ($datos as $val) {
            $titulo = str_replace("_", " ", $val);
            $columnas="col-sm-3";
            if($val == "observaciones") $columnas="col-sm-12";
            if($val == "cuenca" || $val =="provincia" || $val == "area" || $val == "yacimiento") $columnas="col-sm-6";
        ?>
        <div class="form-group <?php echo $columnas;?>">
            {!! Form::label('mes', ucwords($titulo)) !!}
            {!! Form::text($val, null, ['class' => 'form-control', 'disabled' =>'true']) !!}
        </div>
        <?php
            if($val == "anio") echo "</div><div class='row'>";
        }
            
        ?>
    </div>
    
</div>
<div class="card-footer text-right">
    <a href="{!! route('datosDdjj.index') !!}" class="btn btn-sm btn-info">Volver</a>
</div>