<?php

namespace Database\Factories;

use App\Models\PesananEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananEventFactory extends Factory
{
    protected $model = PesananEvent::class;

    public function definition()
    {
        return [
            'nama_pemesan' => $this->faker->name,
            'nama_event' => $this->faker->sentence(3),
            'status' => 'Menunggu'
        ];
    }
} 