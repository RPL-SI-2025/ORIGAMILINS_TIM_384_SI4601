<?php

namespace Database\Factories;

use App\Models\Pengrajin;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengrajinFactory extends Factory
{
    protected $model = Pengrajin::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'is_active' => true,
        ];
    }
} 