<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/*Con esto importo los metodos (authorize,rules,message)*/
/*Es unicamente para la creacion y actualizacion de usuarios*/
use App\Http\Requests\RoleRequest;
/********IMPORTANTE***********************/
/*Aqui importo los MODELOS de Role y Permissions*/
/*Dentro de estos modelos ya se encuentran importados los TRAIT de HasRoles y HasPermissions*/
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
/********IMPORTANTE***********************/


use Auth;
/*Importo el MODELO de User para poder utilizarlo en los eventos*/
use App\User;
//use App\Role;
use App\Company;

/************* EVENTS ***************/
use \App\Events\roleUpdate;


class RoleController extends Controller
{

/*******************INDEX*********************************/
      public function index(Request $request) {

          $roles = Role::query();

          return view('dashboard.roles.index', [
              'items'   => $roles->paginate(config('ui.admin.page_size')),
              'page'    => $request->query('page')
          ]);
      }
/******************* /INDEX*********************************/

/*******************CREATE*********************************/
      public function create(Request $request) {

        $page = $request->query('page');

        $permissions = Permission::orderBy('name', 'asc')->pluck('name', 'id');

        return view('dashboard.roles.create', [
            'cancel_link'   => route('dashboard::roles.index', ['page' => $page]),
            'permissions'   => $permissions,
            'permission_id' => (!is_null(old('permission_id')))? old('permission_id'):[],
            'page'          => $page,

        ]);
/****************************************************/

/*******************STORE*********************************/
      }

      public function store(RoleRequest $request)
      {

          \DB::beginTransaction();

            $role = Role::create([
              'display_name'  => $request->get('display_name'),
              'name'          => $request->get('name'),
              'description'   => $request->get('description'),
            ]);

            $permissions = Permission::whereIn('id',$request->get('permission_id'))->get();

            $role->syncPermissions($permissions);

          \DB::commit();

          /****************************/
          /******* Evento *******/
          /****************************/
          //Tenemos que mencionar el evento en la cabecera del controlador, sino no lo puede llamar.
          //STATE es una variable que cree dentro del evento, junto con USER. STATE me va a guardar un vor que retrive en el front-end.Por ahora es un string despues intentare con un array

          $name = 'NAME';
          $authUser = Auth::user();
          $state = 'creado';

          //Esto es lo que sacamos en la vista. Todas las propiedades de los objetos que creamos. AUnque a estate solo le sacamos un string, lo podemos convertir en un array
          //Aun cuando no mencionamos 'role' ams arriba tiene que ir declarada dentro del EVENTO y incluirlo como parametro para poder sacarlo en la vista. Role curiosamente en este controlador ya es una variable.
          event(new roleUpdate($role,$state,$name,$authUser));

          
          /****************************/
          /******* /Evento *******/
          /****************************/

          return redirect()->route('dashboard::roles.index')->with([
              'message' => "Se ha creado el role ". $role->display_name,
              'level'   => 'success'
          ]);
      }
/****************************************************/

/*******************EDIT*********************************/
      public function edit(Request $request, $id) {
          $role = Role::findOrFail($id);
          $page = $request->query('page');

          $permissions = Permission::orderBy('name', 'asc')->pluck('name', 'id');

          return view('dashboard.roles.edit', [
              'model'          => $role,
              'permissions'    => $permissions,
              'permission_id'  => $request->old('permission_id', $role->permissions->pluck('id')->toArray()),
              'page'           => $request->query('page'),
              'cancel_link'   => route('dashboard::roles.index', ['page' => $page]),
          ]);
      }
/****************************************************/

/*******************UPDATE*********************************/
      public function update(RoleRequest $request, $id)
      {

          \DB::beginTransaction();

            $role = Role::findOrFail($id);

            $role->update([
              'display_name' => $request->get('display_name'),
              'name'         => $request->get('name'),
              'description'  => $request->get('description'),
            ]);

            $permissions = Permission::whereIn('id',$request->get('permission_id'))->get();

            $role->syncPermissions($permissions);

          \DB::commit();

          return redirect()->route('dashboard::roles.index')->with([
              'message' => "Se ha Actualizado el role ". $role->name,
              'level' => 'success'
          ]);
      }
/****************************************************/

/*******************DESTROY*********************************/
      public function destroy(Role $role)
      {
          $role->delete();

          /****************************/
          /******* Evento *******/
          /****************************/
          //Tenemos que mencionar el evento en la cabecera del controlador, sino no lo puede llamar.
          //STATE es una variable que cree dentro del evento, junto con USER. STATE me va a guardar un vor que retrive en el front-end.Por ahora es un string despues intentare con un array
          /*$name = 'ROLE_NAME';
          $authUser = 'USER';
          $state = 'eliminado';*/

          //Esto es lo que sacamos en la vista. Todas las propiedades de los objetos que creamos. AUnque a estate solo le sacamos un string, lo podemos convertir en un array
          //event(new roleUpdate($role,$state,$name,$authUser));

          /****************************/
          /******* /Evento *******/
          /****************************/

          return back()->with('info', 'Rol eliminado con éxito');
      }
/****************************************************/
}
