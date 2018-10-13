<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Municipio;
use App\TypeIdentification;
use App\User;
use Validator;

class RegisterController extends Controller
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

        $departamentos = new Departamento();
        $municipio = new Municipio();
        $typeIdentification = new TypeIdentification();

        if (!empty($departamentos) && !empty($municipio) && !empty($typeIdentification)) {
	        $msj = 'Registro';
	        $notificar = false;
	        $tipo = 'success';
	        $respuesta = [
	        	'departamentos' => $departamentos->get(),
	        	'municipios' => $municipio->get(),
	        	'tipos_identificacion' => $typeIdentification->get()
	        ];
        	
        }else{
        	$msj = 'Algo no está bien, intente de nuevo';
	        $notificar = false;
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
            'email' => 'required|max:50|unique:users', 
            'name' => 'required|max:30', 
            'second_name' => 'max:30', 
            'surname' => 'required|max:30', 
            'second_surname' => 'required|max:30', 
            'type_identification_id' => 'required|max:2|integer', 
            'identification' => 'required|max:30|unique:users', 
            'address' => 'required|max:125', 
            'phone_number' => 'required|max:12|unique:users', 
            'ocupation' => 'required|max:100', 
            'departamento_id' => 'required|max:2', 
            'municipio_id' => 'required|max:2', 
            'password' => 'required|max:20',
        ]);

        if (!$validacion->fails()) {
        	$credenciales = $request->all();
	        $credenciales['created_at'] = date('Y-m-d H:i:s');
	        $credenciales['updated_at'] = date('Y-m-d H:i:s');
	        $credenciales['password'] = bcrypt($credenciales['password']);

	        
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
