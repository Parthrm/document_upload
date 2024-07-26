<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'tags' => "agriculture, scheme, helpful",
            'description' => $this->faker->paragraph(2),
            'path' => "documents/GxihUu7GZOlbHUuEvAk91Gf74wko0nbHnKkU9a7i.pdf",
        ];
    }
}
