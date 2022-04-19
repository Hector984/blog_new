<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BlogPost;

class BlogPostFactory extends Factory
{

    protected $model = BlogPost::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(2, true),
        ];
    }

    /**
     * Creates a new BlogPost
     * This methos overwrites the generated data from the definition method 
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
     
     public function newBlogPost()
     {
         return $this->state(function (array $attributes){
            return [
                'title' => 'New post',
                'content' => 'This is the new content',
            ];
         });
     }
     
}
