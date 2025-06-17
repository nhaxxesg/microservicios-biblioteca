<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nombre' => 'Ficción',
                'grupo' => 'entretenimiento',
                'descripcion' => 'Narraciones inventadas que pueden incluir elementos fantásticos o realistas.'
            ],
            [
                'nombre' => 'No Ficción',
                'grupo' => 'informativo',
                'descripcion' => 'Obras basadas en hechos reales, como biografías o ensayos.'
            ],
            [
                'nombre' => 'Ciencia',
                'grupo' => 'informativo',
                'descripcion' => 'Libros que exploran temas científicos, desde física hasta biología.'
            ],
            [
                'nombre' => 'Historia',
                'grupo' => 'informativo',
                'descripcion' => 'Obras que relatan eventos pasados, biografías de personajes históricos o análisis de épocas.'
            ],
            [
                'nombre' => 'Infantil',
                'grupo' => 'entretenimiento',
                'descripcion' => 'Libros diseñados para niños, con ilustraciones y narrativas simples.'
            ],
            [
                'nombre' => 'Aventura',
                'grupo' => 'entretenimiento',
                'descripcion' => 'Narraciones que incluyen viajes, exploraciones y situaciones emocionantes.'
            ],
            [
                'nombre' => 'Fantasía',
                'grupo' => 'entretenimiento',
                'descripcion' => 'Obras que incluyen elementos mágicos, mundos imaginarios y criaturas fantásticas.'
            ],
            [
                'nombre' => 'Romance',
                'grupo' => 'entretenimiento',
                'descripcion' => 'Historias centradas en relaciones amorosas y emociones humanas.'
            ],
            [
                'nombre' => 'Tecnología',
                'grupo' => 'informativo',
                'descripcion' => 'Libros que abordan temas tecnológicos, desde programación hasta innovaciones.'
            ],
            [
                'nombre' => 'Autoayuda',
                'grupo' => 'informativo',
                'descripcion' => 'Obras diseñadas para ayudar a las personas a mejorar aspectos de su vida personal o profesional.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
