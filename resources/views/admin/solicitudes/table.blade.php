<table class="table table-responsive" id="solicituds-table">
    <thead>
        <tr>
            <th>Cuil</th>
        <th>Email</th>
        <th>Codarea</th>
        <th>Celular</th>
        <th>Provincia Id</th>
        <th>Monto</th>
        <th>Codigo Sms</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($solicituds as $solicitud)
        <tr>
            <td>{!! $solicitud->cuil !!}</td>
            <td>{!! $solicitud->email !!}</td>
            <td>{!! $solicitud->codarea !!}</td>
            <td>{!! $solicitud->celular !!}</td>
            <td>{!! $solicitud->provincia_id !!}</td>
            <td>{!! $solicitud->monto !!}</td>
            <td>{!! $solicitud->codigo_sms !!}</td>
            <td>
                {!! Form::open(['route' => ['solicituds.destroy', $solicitud->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('solicituds.show', [$solicitud->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('solicituds.edit', [$solicitud->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>