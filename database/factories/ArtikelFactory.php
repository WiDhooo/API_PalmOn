<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtikelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artikel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence, // Judul artikel
            'isi' => $this->faker->paragraphs(3, true), // Isi artikel dengan 3 paragraf
            'gambar' => $this->faker->optional()->imageUrl(640, 480, 'articles', true), // URL gambar, bisa nullable
            'nama' => $this->faker->name, // Nama pembuat artikel
        ];
    }
}
