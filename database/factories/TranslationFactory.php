<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Language;
use App\Models\Translation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    
    protected $model = Translation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $language = Language::inRandomOrder()->first() ?? Language::factory()->create();

        return [
            'key_name' => $this->faker->unique(true)->word(), // Generates a unique word
            'value' => $this->faker->sentence(),          // Generates a random sentence
            'language_id' => $language->id, // Random language
            'tags' => $this->faker->randomElements(['mobile', 'desktop', 'web'], rand(1, 3)), // Random tags
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
