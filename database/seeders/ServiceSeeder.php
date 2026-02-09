<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$services = [
			[
				'name' => 'Viajes Nacionales',
				'excerpt' => 'Explora destinos increíbles en Colombia.',
				'description' => 'Ofrecemos tours a nivel nacional para disfrutar experiencias únicas.',
				'image_uri' => 'viajenacional.jpg',
				'caption_image' => 'Viajes nacionales',
			],
			[
				'name' => 'Viajes Internacionales',
				'excerpt' => 'Explora destinos increíbles fuera de Colombia.',
				'description' => 'Ofrecemos tours a nivel internacional para disfrutar experiencias únicas.',
				'image_uri' => 'viajeinternacional.jpg',
				'caption_image' => 'Viajes internacionales',
			],
			[
				'name' => 'Deportes Extremos',
				'excerpt' => 'Actividades deportivas para todos los niveles.',
				'description' => 'Desde parapente hasta ciclomontañismo, contamos con planes deportivos personalizados.',
				'image_uri' => 'deportes.jpg',
				'caption_image' => 'Pasión por el deporte',
			],
		];

		foreach ($services as $service) {
			Service::create([
				'name' => $service['name'],
				'slug' => Str::slug($service['name']),
				'excerpt' => $service['excerpt'],
				'description' => $service['description'],
				'image_uri' => $service['image_uri'],
				'caption_image' => $service['caption_image'],
				'state' => true,
			]);
		}
	}
}
