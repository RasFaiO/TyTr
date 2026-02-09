<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$products = [
			[
				'name' => 'Ropa Tygua',
				'slug' => 'Tygua Clothes',
				'excerpt' => 'Ropa a tu medida y estilo, para que en cada viaje vistas Tygua!',
				'description' => 'Nueva experiencia de ropa Tygua, para que puedas vivir las aventuras con la ropa adecuada',
				'image_uri' => 'ropa.jpg',
				'caption_image' => 'RopaTygua',
				'state' => true
			],
			[
				'name' => 'Despensa',
				'slug' => 'Tygua pantry',
				'excerpt' => 'Todo lo que necesitas para una alimentación sana, 100% del campo',
				'description' => 'Encuentra alimentos frescos, naturales y directamente del campo. Productos 100% saludables para nutrir tu día con lo mejor de la tierra.',
				'image_uri' => 'alimentos.jpg',
				'caption_image' => 'AlimentosTygua',
				'state' => true
			],
		];

		DB::table('products')->insert($products);
	}
}
