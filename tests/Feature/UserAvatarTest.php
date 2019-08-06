<?php

namespace Tests\Feature;

use App\User;
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
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertEquals(asset('storage/avatars/' . $file->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }

    /** @test */
    public function users_can_determine_their_avatar_path()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(asset('storage/avatars/default.svg'), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals(asset('storage/avatars/me.jpg'), $user->avatar_path);
    }

    /** @test */
    public function an_avatar_is_replaced_when_a_user_uploads_a_new_one()
    {
        $this->signIn();

        Storage::fake('public');

        $this->postJson('/users/' . auth()->id() .'/avatars', ['avatar' => $oldAvatar = UploadedFile::fake()
            ->image('avatar.jpg', 200, 200)])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertEquals(asset('storage/avatars/' . $oldAvatar->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $oldAvatar->hashName());

        $this->postJson('/users/' . auth()->id() .'/avatars', ['avatar' => $newAvatar = UploadedFile::fake()
            ->image('avatar.jpg', 200, 200)])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNotEquals(asset('storage/avatars/' . $oldAvatar->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertMissing('avatars/' . $oldAvatar->hashName());

        $this->assertEquals(asset('storage/avatars/' . $newAvatar->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $newAvatar->hashName());
    }
}
