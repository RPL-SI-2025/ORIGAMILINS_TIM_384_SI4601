<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UpdateArtikelFactory extends Factory
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
        $judul = $this->faker->sentence(3);
        
        return [
            'judul' => $judul,
            'isi' => $this->faker->paragraphs(3, true), // Minimal 50 karakter
            'tanggal_publikasi' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'gambar' => 'uploads/artikel/test.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
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
     * Indicate that the artikel has no image.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function noImage()
    {
        return $this->state(function (array $attributes) {
            return [
                'gambar' => null,
            ];
        });
    }

    /**
     * Indicate that the artikel has invalid image format.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function invalidImageFormat()
    {
        return $this->state(function (array $attributes) {
            return [
                'gambar' => 'uploads/artikel/test.pdf',
            ];
        });
    }

    /**
     * Indicate that the artikel has large image size.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function largeImageSize()
    {
        return $this->state(function (array $attributes) {
            return [
                'gambar' => 'uploads/artikel/large.jpg',
            ];
        });
    }
} 