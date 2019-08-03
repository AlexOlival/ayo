<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_upload_an_avatar()
    {
        $this->postJson('/users/1/avatars', ['avatar' => 'garbage'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function users_can_not_upload_an_invalid_file()
    {
        $this->signIn();

        $this->postJson('/users/' . auth()->id() .'/avatars', ['avatar' => 'garbage'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function an_avatar_with_the_correct_dimensions_must_be_provided()
    {
        $this->signIn();

        $this->postJson('/users/' . auth()->id() .'/avatars', ['avatar' => UploadedFile::fake()
            ->image('avatar.jpg', 300, 300)])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function users_can_upload_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->postJson('/users/' . auth()->id() .'/avatars', ['avatar' => $file = UploadedFile::fake()
            ->image('avatar.jpg', 200, 200)])
            ->assertStatus(Response::HTTP_OK);

        $this->assertEquals('avatars/' . $file->hashName(), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
