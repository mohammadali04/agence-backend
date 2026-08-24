<?php

namespace Modules\Home\Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Home\Models\Blog;

/**
 * @extends Factory<Model>
 */
class BlogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Blog::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'icon' => $this->faker->imageUrl(),
        ];
    }
}
