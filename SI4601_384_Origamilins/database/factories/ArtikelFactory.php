<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        return [
            'judul' => $this->faker->sentence(6),
            'isi' => $this->faker->paragraphs(3, true),
            'tanggal_publikasi' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'gambar' => 'uploads/artikel/test-image.jpg'
        ];
    }

    public function testContent()
    {
        return $this->state(function (array $attributes) {
            return [
                'judul' => 'Test Artikel Origami',
                'isi' => 'Ini adalah artikel test tentang origami. Origami adalah seni melipat kertas yang berasal dari Jepang. Seni ini telah berkembang selama berabad-abad dan menjadi populer di seluruh dunia.',
                'gambar' => 'uploads/artikel/test-image.jpg'
            ];
        });
    }

    /**
     * Indicate that the artikel is published today.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function publishedToday()
    {
        return $this->state(function (array $attributes) {
            return [
                'tanggal_publikasi' => now(),
            ];
        });
    }

    /**
     * Indicate that the artikel is published in the future.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     *
     * @throws \Exception
     */
    public function publishedInFuture()
    {
        return $this->state(function (array $attributes) {
            return [
                'tanggal_publikasi' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            ];
        });
    }

    /**
     * Indicate that the artikel has a long title.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function longTitle()
    {
        return $this->state(function (array $attributes) {
            return [
                'judul' => Str::random(256),
            ];
        });
    }

    /**
     * Indicate that the artikel has a future publication date.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function futureDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'tanggal_publikasi' => $this->faker->dateTimeBetween('now', '+1 month'),
            ];
        });
    }

    /**
     * Indicate that the artikel has a short content.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function shortContent()
    {
        return $this->state(function (array $attributes) {
            return [
                'isi' => $this->faker->sentence(5), // Kurang dari 50 karakter
            ];
        });
    }

    /**
     * Indicate that the artikel has special characters in title.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function specialCharactersTitle()
    {
        return $this->state(function (array $attributes) {
            return [
                'judul' => 'Test Judul @#$%^&*()',
            ];
        });
    }

    /**
     * Indicate that the artikel has HTML content.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function htmlContent()
    {
        return $this->state(function (array $attributes) {
            return [
                'isi' => '<p>Test Isi dengan <strong>HTML</strong> yang <em>aman</em> dan memiliki minimal 50 karakter untuk memenuhi validasi</p>',
            ];
        });
    }
}