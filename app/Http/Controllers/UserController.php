<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Departamento;
use App\Municipio;
use App\TypeIdentification;
use Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $msj = '';
        $notificar = false;
        $tipo = '';
        $respuesta = false;

        $departamentos = Departamento::get();
        $municipio = Municipio::get();
        $typeIdentification = TypeIdentification::get();
        $usuarios = User::with(['departamento', 'municipio', 'typeIdentification'])->get();

        if (!empty($usuarios) && !empty($departamentos) && !empty($municipio) && !empty($typeIdentification)) {
            $msj = 'Lista de usuarios registrados';
            $notificar = false;
            $tipo = 'success';
            $respuesta = [
              'usuarios' => $usuarios,
              'departamentos' => $departamentos,
              'municipios' => $municipio,
              'tipos_identificacion' => $typeIdentification
            ];
            
        }else{
            $msj = 'Algo no está bien, intente de nuevo';
            $notificar = false;
            $tipo = 'warning';
            $respuesta = false;
        }


        return response([
              'respuesta' => $respuesta,
              'tipo' => $tipo,
              'mensaje' => $msj,
              'notificar' => $notificar
        ],200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $msj = '';
        $notificar = false;
        $tipo = '';
        $respuesta = false;

        $validacion = Validator::make($request->all(),[
            'email' => 'max:50|unique:users|email', 
            'name' => 'required|max:30', 
            'second_name' => 'max:30', 
            'surname' => 'required|max:30', 
            'second_surname' => 'max:30', 
            'type_identification_id' => 'required|integer', 
            'identification' => 'required|max:30|unique:users', 
            'address' => 'required|max:125', 
            'phone_number' => 'max:12|unique:users', 
            'ocupation' => 'max:100', 
            'departamento_id' => 'integer', 
            'municipio_id' => 'integer', 
            // 'password' => 'max:20',
        ]);

        if (!$validacion->fails()) {
          $credenciales = $request->all();
          $credenciales['created_at'] = date('Y-m-d H:i:s');
          $credenciales['updated_at'] = date('Y-m-d H:i:s');
          // $credenciales['password'] = bcrypt($credenciales['password']);

          $okInsert = $user->insert($credenciales);

          if ($okInsert) {
            $msj = 'Gracias por registrase en nuestra plataforma';
            $notificar = true;
            $tipo = 'success';
            $respuesta = $credenciales;
          }else{
            $msj = 'Realice la acción nuevamente';
            $notificar = true;
            $tipo = 'info';
            $respuesta = false;
          }
          
        }else{
          $msj = $validacion->messages();
          $notificar = true;
          $tipo = 'error';
          $respuesta = false;
          
        }

        return response([
              'respuesta' => $respuesta,
              'tipo' => $tipo,
              'mensaje' => $msj,
              'notificar' => $notificar
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, User $user)
    {
        $msj = '';
        $notificar = false;
        $tipo = '';
        $respuesta = false;

        $usuario = $user->with(['departamento', 'municipio', 'typeIdentification'])->where('id', $id)->get();

            $msj = 'usuario';
            $notificar = true;
            $tipo = 'success';
            $respuesta = $usuario;
            
        return response([
              'respuesta' => $respuesta,
              'tipo' => $tipo,
              'mensaje' => $msj,
              'notificar' => $notificar
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, User $user)
    {
        $msj = '';
        $notificar = false;
        $tipo = '';
        $respuesta = false;
        $credenciales = $request->except(['type_identification', 'municipio', 'departamento', 'created_at', 'updated_at']);

        $validacion = Validator::make($credenciales,[
            'email' => 'email|max:50|unique:users,id,'.$id, 
            'name' => 'max:30', 
            'second_name' => 'max:30', 
            'surname' => 'max:30', 
            'second_surname' => 'max:30', 
            'type_identification_id' => 'integer', 
            'identification' => 'numeric|digits_between:6,10|unique:users,id,'.$id, 
            'address' => 'max:125', 
            'phone_number' => 'numeric|digits_between:6,12|unique:users,id,'.$id,
            'ocupation' => 'max:100', 
            'departamento_id' => 'integer', 
            'municipio_id' => 'integer'
        ]);

        if (!$validacion->fails()) {
          $userUp = User::where('id', '=', $id)->first();
          foreach ($credenciales as $key => $value) {
            if ($userUp[$key] === $credenciales[$key]) {
              unset($credenciales[$key]);
            }
          }

          if (!empty($credenciales)) {
              $okInsert = User::where('id', '=', $id)->update($credenciales);
              // $okInsert = User::find($id)->fill($credenciales)->save();

              if ($okInsert) {
                  $msj = 'Datos actualizados';
                  $notificar = true;
                  $tipo = 'success';
                  $respuesta = $user->with(['departamento', 'municipio', 'typeIdentification'])->first();
              }else{
                  $msj = 'No existen nuevos datos';
                  $notificar = true;
                  $tipo = 'info';
                  $respuesta = false;
              }
          }else{
            $msj = 'No existen nuevos datos';
            $notificar = true;
            $tipo = 'info';
            $respuesta = false;
          }
            
            
        }else{
            $msj = $validacion->messages();
            $notificar = true;
            $tipo = 'error';
            $respuesta = false;
            
        }

        return response([
              'respuesta' => $respuesta,
              'tipo' => $tipo,
              'mensaje' => $msj,
              'notificar' => $notificar
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $msj = '';
        $notificar = false;
        $tipo = '';
        $respuesta = false;

        $okDelete = User::where('id', $user->first()->id)->delete();

        if ($okDelete) {
            $msj = 'El usuario fue eliminado';
            $notificar = true;
            $tipo = 'success';
            $respuesta = true;
        }else{
            $msj = 'Algo no salió bien, intente de nuevo';
            $notificar = true;
            $tipo = 'warning';
            $respuesta = false;
        }


        return response([
              'respuesta' => $respuesta,
              'tipo' => $tipo,
              'mensaje' => $msj,
              'notificar' => $notificar
        ],200);
    }
}
