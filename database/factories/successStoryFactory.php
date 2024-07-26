<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\successStory>
 */
class successStoryFactory extends Factory
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
                'author' => $this->faker->name(),
                'description' => $this->faker->paragraph(2),
                'path' => "documents/auto.txt",
        ];
    }
}
