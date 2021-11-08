<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Cuenta extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cuenta')->insert([
			'correo' => 'vavila1@me.com',
			'contra' => '123',
            'chat_id' => 1009990204,
            'id_estatus' => 2,
            'id_usuario' => 1,
		]);
    }
}
