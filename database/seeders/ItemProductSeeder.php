<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemProductSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$products = [
			[
				'product_id' => 1,
				'slug' => 'camisa-blanca-tygua',
				'description' => 'Descripción detallada de camisa',
				'excerpt' => 'Descripción corta de camisa',
				'price' => 25000,
				'stock' => 5,
				'image_uri' => 'camisablanca.jpg',
				'caption_image' => 'camisablancatygua',
				'size' => 'L',
				'weight' => null,
				'color' => 'Blanco',
				'unit' => null,
				'state' => true,
				'featured' => true
			],
			[
				'product_id' => 2,
				'slug' => 'docena-de-huevos',
				'description' => 'Huevos criollos AAA',
				'excerpt' => 'Docena de huevo campesino',
				'price' => 8000,
				'stock' => 7,
				'image_uri' => 'eggs.jpg',
				'caption_image' => 'eggs',
				'size' => null,
				'weight' => '160gr',
				'color' => null,
				'unit' => 'docena',
				'state' => true,
				'featured' => true
			],
		];
		DB::table('product_items')->insert($products);
	}
}
