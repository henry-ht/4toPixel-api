<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Departamento;
use App\Municipio;
use App\TypeIdentification;
use Validator;

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
            'email' => 'max:50|unique:users', 
            'name' => 'required|max:30', 
            'second_name' => 'max:30', 
            'surname' => 'required|max:30', 
            'second_surname' => 'max:30', 
            'type_identification_id' => 'required|max:2|integer', 
            'identification' => 'required|max:30|unique:users', 
            'address' => 'required|max:125', 
            'phone_number' => 'max:12|unique:users', 
            'ocupation' => 'max:100', 
            'departamento_id' => 'max:2', 
            'municipio_id' => 'max:2', 
            'password' => 'max:20',
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
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $msj = '';
        $notificar = false;
        $tipo = '';
        $respuesta = false;

        $validacion = Validator::make($request->all(),[
            'email' => 'max:50|unique:users', 
            'name' => 'max:30', 
            'second_name' => 'max:30', 
            'surname' => 'max:30', 
            'second_surname' => 'max:30', 
            'type_identification_id' => 'max:2|integer', 
            'identification' => 'max:30|unique:users', 
            'address' => 'max:125', 
            'phone_number' => 'max:12|unique:users', 
            'ocupation' => 'max:100', 
            'departamento_id' => 'max:2', 
            'municipio_id' => 'max:2', 
            'password' => 'max:20',
        ]);

        if (!$validacion->fails()) {
            $credenciales = $request->all();
            if (!empty($credenciales['password'])) $credenciales['password'] = bcrypt($credenciales['password']);
            
            $okInsert = User::find($user->first()->id)->fill($credenciales)->save();

            if ($okInsert) {
                $msj = 'Datos actualizados';
                $notificar = true;
                $tipo = 'success';
                $respuesta = $user->first();
            }else{
                $msj = 'No existen nuevos datos';
                $notificar = true;
                $tipo = 'info';
                $respuesta = false;
            }
            
        }else{
            $msj = 'Ingrese los datos correctamente';
            $notificar = true;
            $tipo = 'error';
            $respuesta = $validacion->messages();
            
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

        $UserModel = new User();
        $okDelete = $UserModel->where('id', $user->first()->id)->delete();

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
