<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Estatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('estatus')->insert([
			'nombre' => 'Registrado'
		]);
		DB::table('estatus')->insert([
			'nombre' => 'Autenticado'
		]);
    }
}
