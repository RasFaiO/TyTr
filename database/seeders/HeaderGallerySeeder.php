<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeaderGallerySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$headerGallery = [
			[
				'description' => 'Descubre Destinos Inexplorados',
				'image_uri' => 'header.jpg',
				'caption' => 'tygua'
			],
			[
				'description' => 'Explora las montañas',
				'image_uri' => 'montain.jpg',
				'caption' => 'montañas'
			],
			[
				'description' => 'Disfruta paisajes únicos',
				'image_uri' => 'playa.jpg',
				'caption' => 'playa'
			],
		];

		DB::table('header_galleries')->insert($headerGallery);
	}
}
