<?php

namespace Database\Factories;

use App\Models\Kalkulasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KalkulasiFactory extends Factory
{
    protected $model = Kalkulasi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tgl_panen' => $this->faker->date(),
            'harga_tbs' => $this->faker->numberBetween(800, 2000), // assuming it's in a range per unit
            'berat_total_tbs' => $this->faker->numberBetween(500, 10000), // random weight in kg
            'potongan_timbangan' => $this->faker->numberBetween(0, 100), // discount in weight
            'upah_panen' => $this->faker->numberBetween(10000, 500000), // labor cost
            'biaya_transportasi' => $this->faker->numberBetween(10000, 100000), // transportation cost
            'biaya_lainnya' => $this->faker->numberBetween(5000, 50000), // other expenses
        ];
    }
}
