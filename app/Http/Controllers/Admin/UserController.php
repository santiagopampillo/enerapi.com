<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use Spatie\Permission\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;
    private $rolRepo;

    public function __construct(UserRepository $userRepo, RoleRepository $rolRepo)
    {
        $this->userRepository = $userRepo;
        $this->rolRepo = $rolRepo;

    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(Request $request)
    {
        $pagination = 10;
        $filtros = [];
        $filtros["first_name"] = \Request::input('first_name');
        $filtros["last_name"] = \Request::input('last_name');

        $users = $this->userRepository->getByFilter($pagination,$filtros);

        return view('admin.users.index')->with('users', $users)->with('filtros', $filtros);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        $roles = $this->rolRepo->getOrderBy('name');
        $comboRoles= ['' => 'Seleccionar'];
        foreach($roles as $r) {
            if (!(Auth::user()->rol_id!=1 && $r->id==1)){
                $comboRoles[$r->id] = $r->name;
            }
        }

        return view('admin.users.create')->with('roles',$comboRoles);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);
        
        Flash::success('Usuario creado con &eacute;xito.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        return view('admin.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        $roles = $this->rolRepo->getOrderBy('name');
        $comboRoles= ['' => 'Seleccionar'];
        foreach($roles as $r) {
            if (!(Auth::user()->rol_id!=1 && $r->id==1)){
                $comboRoles[$r->id] = $r->name;
            }
        }        

        return view('admin.users.edit')->with('user', $user)->with('roles', $comboRoles);
    }

    public function change_pass($id)
    {
        
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        return view('admin.users.change_pass')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('Usuario modificado con &eacute;xito.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('Usuario eliminado.');

        return redirect(route('users.index'));
    }

    public function export()
    {
/*        $filtros = [];
        $filtros["name"] = \Request::input('name');
        $filtros["lastname"] = \Request::input('lastname');

        $users = $this->userRepository->getByFilter(null,$filtros);

        foreach ($users as $u) {
            $usersArray[] = array($l->id,$l->nombre,$l->empresa->nombre,$l->direccion,$l->zona->nombre);
        }

        Excel::create('locales', function($excel) use($localesArray) {
            $excel->sheet('Hoja 1', function($sheet) use($localesArray) {
                $sheet->fromArray($localesArray,null,'A1',false,false);
            });
        })->export('xls');*/
    }
}
