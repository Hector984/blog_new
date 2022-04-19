<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    //With this line we refresh the database each time we run the migrations
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPostsWhenNothingInTheDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No blog posts yet');
    }

    public function testSeeOneBlogPostWhenThereIsOneWithNoComments()
    {
        //Arrange
        
        // $post = new BlogPost();
        // $post->title = 'New post';
        // $post->content = 'New brand content';
        // $post->save();

        $post = $this->createDummyBlogPost();

        //Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New post');
        $response->assertSeeText('No comments yet');

        $response->assertStatus(200);

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

    }

    public function testSeeOneBlogPostWithComments()
    {
        $post = $this->createDummyBlogPost();

        Comment::factory()->count(4)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }

    public function testStoreValue()
    {
        //Arrange

        $params = [
            'title' => 'Valid title',
            'content' => 'At leat 10 characters'
        ];

        $this->post('/posts', $params)
        ->assertStatus(302)//Status de redireccion
        ->assertSessionHas('status');//Verificamos que se pase la variable status

        $this->assertEquals(session('status'), 'The blog post was created!!');
    }

    public function testStoreFail()
    {
        //Arrange
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        //Act
        $this->post('/posts', $params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        //dd($messages);

        //Assert
        $this->assertEquals( $messages['title'][0], 'The title must be at least 5 characters.' );
        $this->assertEquals( $messages['content'][0], 'The content must be at least 10 characters.' );
    }

    public function testUpdateValid()
    {
        // $post = new BlogPost();
        // $post->title = 'New post';
        // $post->content = 'This is the new content';
        // $post->save();

        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $params = [
            'title' => "Updating the title",
            'content' => "Updating the content"
        ];

        $this->put("/posts/{$post->id}", $params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The post was updated');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => "Updating the title",
            'content' => "Updating the content"
        ]);
    }

    public function testDeletePostValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $params = [
            'title' => $post->title,
            'content' => $post->content
        ];

        $this->delete("/posts/{$post->id}")
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The post was deleted');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);
    }

    public function createDummyBlogPost() : BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New post';
        // $post->content = 'This is the new content';
        // $post->save();

        $post =  BlogPost::factory()->newBlogPost()->create();

        return $post;
    }

}
