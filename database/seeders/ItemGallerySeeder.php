<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemGallerySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void {
		$itemGallery = [
			[
				'item_id' => 1,
				'image_uri' => 'barichara.jpg',
				'caption' => 'Barichara'
			],
			[
				'item_id' => 1,
				'image_uri' => 'barichara2.jpg',
				'caption' => 'Barichara2'
			],
			[
				'item_id' => 1,
				'image_uri' => 'barichara3.jpg',
				'caption' => 'Barichara3'
			],
		];

		DB::table('item_gallery')->insert($itemGallery);
	}
}
