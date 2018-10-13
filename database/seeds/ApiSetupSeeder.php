<?php

use Illuminate\Database\Seeder;
use App\TypeIdentification;
use App\Departamento;
use App\Municipio;

class ApiSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentacion = [
    		array(
                'name' => 'CC',
                'display_name' => 'Cedula de ciudadanía'
	        ),
	        array(
                'name' => 'RC',
                'display_name' => 'Registro civil'
	        ),
	        array(
                'name' => 'TI',
                'display_name' => 'Tarjeta de identificación'
	        ),
	        array(
                'name' => 'AS',
                'display_name' => 'AS'
	        ),
	        array(
                'name' => 'MS',
                'display_name' => 'MS'
	        ),
	        array(
                'name' => 'PA',
                'display_name' => 'PA'
	        ),
    	];

    	$departamentos = [
    		array(
                'name' => 'Bolívar',
	        ),
	        array(
                'name' => 'Atlántico',
	        ),
    	];

    	$municipio = [
    		array(
                'name' => 'Cartagena',
	        ),
	        array(
                'name' => 'Barranquilla',
	        ),
    	];
        
        foreach ($documentacion as $key => $value) {
	    	$table = new TypeIdentification();
	        $table->name = $value['name'];
	        $table->display_name = $value['display_name'];
	        $table->save();
        	
        }

        foreach ($departamentos as $key => $value) {
	    	$table = new Departamento();
	        $table->name = $value['name'];
	        $table->save();
        	
        }

        foreach ($municipio as $key => $value) {
	    	$table = new Municipio();
	        $table->name = $value['name'];
	        $table->save();
        	
        }
    }
}
