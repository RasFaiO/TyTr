<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$item = [
			[
				'service_id' => 1,
				'slug' => 'Barichara',
				'description' => 'Descubre uno de los pueblos más hermosos de Colombia en un viaje que combina historia, naturaleza y tranquilidad. Barichara, conocido como "el pueblo más lindo de Colombia", te espera con sus calles empedradas, casas blancas con tejas rojas, y un ambiente que parece detenido en el tiempo.',
				'excerpt' => 'Entre calles de piedra y atardeceres dorados, Barichara te susurra historias de antaño.',
				'price' => 160000,
				'included' => 'Alojamiento en hotel boutique con desayuno
					Caminata guiada por el Camino Real a Guane
					Visita a los talleres de papel artesanal y arte local
					Recorrido histórico por Barichara (Iglesia de la Inmaculada, parque principal, mirador)
					Transporte desde y hacia Bucaramanga o San Gil
					Seguro de viaje',
				'duration' => '3 días / 2 noches',
				'state' => true,
				'image_uri' => 'barichara.jpg',
				'caption_image' => 'Barichara',
				'Location' => 'Santander',
				'capacity' => 6,
				'start_date' => '2025-06-06',
				'featured' => true
			],
			[
				'service_id' => 1,
				'slug' => 'Desierto-de-la-Tatacoa',
				'description' => 'Sumérgete en uno de los paisajes más sorprendentes de Colombia con este viaje al Desierto de la Tatacoa, un paraíso árido lleno de misterio, ciencia y belleza natural. Entre laberintos de formaciones rojizas y grises, disfrutarás de experiencias únicas en uno de los mejores destinos para la observación astronómica en Latinoamérica.',
				'excerpt' => 'Atrévete a explorar el desierto que guarda estrellas y secretos milenarios.',
				'price' => 180000,
				'included' => 'Alojamiento en eco-hotel o glamping con desayuno
					Tour guiado por los laberintos del Cuzco y Los Hoyos
					Noche de observación astronómica con telescopios profesionales
					Caminata al Valle de los Xilópalos
					Transporte desde Neiva o Villavieja
					Hidratación y seguro de viaje',
				'duration' => '3 días / 2 noches',
				'state' => true,
				'image_uri' => 'tatacoa.jpg',
				'caption_image' => 'Tatacoa',
				'Location' => 'Huila',
				'capacity' => 8,
				'start_date' => '2025-06-13',
				'featured' => true
			],
			[
				'service_id' => 1,
				'slug' => 'Represa-Prado-Tolima',
				'description' => 'Embárcate en una experiencia inolvidable a la Represa de Prado, conocida como el “Mar interior de Colombia”. Este destino, escondido entre montañas y rodeado de exuberante vegetación, es perfecto para quienes buscan un equilibrio entre aventura acuática y relax frente a paisajes únicos.',
				'excerpt' => 'Descubre la magia del mar interior de Colombia. En Prado, el agua, la selva y la historia se funden en una experiencia única que te desconectará del mundo.',
				'price' => 190000,
				'included' => 'Alojamiento en eco-lodge u hotel frente a la represa con desayuno
					Paseo en lancha por la represa con visita a cavernas naturales
					Tour guiado a las pinturas rupestres y senderos ecológicos
					Actividades acuáticas (kayak o paddle opcional)
					Transporte terrestre desde Ibagué
					Seguro de viaje',
				'duration' => '2 días / 1 noches',
				'state' => true,
				'image_uri' => 'represa.jpg',
				'caption_image' => 'Represa',
				'Location' => 'Prado - Tolima',
				'capacity' => 8,
				'start_date' => '2025-06-20',
				'featured' => true
			],
		];
		DB::table('service_items')->insert($item);
	}
}
