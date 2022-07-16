<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'about_first_text' => $this->faker->text,
            'about_second_text' => $this->faker->text,
            'about_first_image' => 'setting/about-img-1.jpg',
            'about_second_image' => 'setting/about-img-2.jpg',
            'about_our_vision' => $this->faker->text,
            'about_our_mission' => $this->faker->text,
            'about_services' => $this->faker->text,
        ];
    }
}
