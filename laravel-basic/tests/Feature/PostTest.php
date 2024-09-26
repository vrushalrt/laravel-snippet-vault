<?php

namespace Tests\Feature;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Comment;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        // Arrange
        // $post = new BlogPost();
        // $post->title = 'My title';
        // $post->content = 'My content';
        // $post->save();

        $post = $this->createDummyBlogPost();

        print('Post ID: ' . $post->id);

        // Act
        $response = $this
            ->actingAs($this->user())
            ->get('/posts/' . $post->id);

        // Assert
        $response->assertSeeText($post->title);
        $response->assertSeeText($post->content);
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
        ]);
    }

    public function testSee1BlogPostWithComments()
    {
        // Arrange
        $user = $this->user();

        $post = $this->createDummyBlogPost();

        Comment::factory()->count(4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => BlogPost::class,
            'user_id' => $user->id
        ]);

        // Act
        $response = $this
            ->actingAs($this->user())
            ->get('/posts');

        // Assert
        $response->assertSeeText('4 comments');
        
    }

    public function testStorevalid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Post created!');

    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'At least 10 characters'       
        ];

        $this
            ->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $message = session('errors')->getMessages();
        $this->assertEquals($message['title'][0],'The title field must be at least 4 characters.');
    }

    public function testUpdateValid()
    {
        // Arrange
        // $post = new BlogPost();
        // $post->title = 'I am a Title';
        // $post->content = 'I am a Content.';
        // $post->save();
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        // Assert
        $newPost = [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content
        ];

        $this->assertDatabaseHas('blog_posts', $newPost);

        $params = [
            'title' => 'New Title',
            'content' => 'New Content',
        ];

        $this
            ->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Post updated!');
        $this->assertDatabaseMissing('blog_posts', $newPost);
        $this->assertDatabaseHas('blog_posts', $params);
    }

    private function createDummyBlogPost($userId=null)
    {
        $post = new BlogPost();
        $post->title = 'I am a Title';
        $post->content = 'I am a Content.';
        $post->user_id = $userId ?? $this->user()->id;
        // $post->deleted_at = null;
        $post->save();

        // By using factory state
        // return BlogPost::factory()->state('test-title')->create();

        return $post;
    }

    public function testDelete()
    {
        $user = $this->user();
        // $post = $this->createDummyBlogPost();

        // $newPost = [
        //     'id' => $post->id,
        //     'title' => $post->title,
        //     'content' => $post->content,
        //     'user_id' => $post->user_id
        // ];

        $post = $this->createDummyBlogPost($user->id);

        // $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this
            ->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Post deleted!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        // $this->assertSoftDeleted('blog_posts', $post->toArray());

    }

}
