<table class="table">
        <tbody>
                <tr style="background-color: #f8f9fa;font-size:14px;color: #495057;">
                        <th style="text-align: center" width="10%">ACCIONES</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                </tr>
                @foreach($users as $user)
                <tr>
                        <td nowrap>                                
                                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                                <a href="{!! route('users.edit', [$user->id]) !!}" class="btn btn-sm btn-edit" style="padding: 1px 5px 0px 5px;height: 28px;">
                                        <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="{!! route('users.change_pass', [$user->id]) !!}" class="btn btn-sm btn-change_pass" style="padding: 1px 5px 0px 5px;height: 28px;">
                                        <i class="fas fa-key"></i>
                                </a>
                                @if (Auth::user()->id!=$user->id)
                                    <button type="submit" class="btn btn-sm btn-delete" style="    padding: 0px 5px 0px 5px;height: 28px;" onclick="return confirm('¿Estás seguro?')">
                                                                        <i class="fa fa-trash"></i>
                                                                </button>                                    
                                @endif
                                {!! Form::close() !!}                                                 
                        </td>
                        <td>{!! $user->first_name !!}</td>
                        <td>{!! $user->last_name !!}</td>
                        <td>{!! $user->email !!}</td>
                </tr>
                @endforeach
        </tbody>
</table>