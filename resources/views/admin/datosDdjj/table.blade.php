<table class="table">
    <tbody>
            <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                <th style="text-align: center;width: 130px">Acciones</th>
                <th>Empresa</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Cuenca</th>
                <th>Yacimiento</th>
                <th>Id Pozo</th>
            </tr>
            @foreach($registros as $registro)          
            <tr>
                <td nowrap style="text-align: center;width: 80px">
                    <a href="{!! route('datosDdjj.view', [$registro->id]) !!}" class="btn btn-sm btn-edit" style="padding: 1px 5px 0px 5px;height: 25px;">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
                <td>{!! $registro->empresa->nombre !!}</td>
                <td>{!! $registro->mes !!}</td>
                <td>{!! $registro->anio !!}</td>
                <td>{!! $registro->cuenca !!}</td>
                <td>{!! $registro->yacimiento !!}</td>
                <td>{!! $registro->id_pozo !!}</td>
            </tr>
            @endforeach
    </tbody>
</table>
