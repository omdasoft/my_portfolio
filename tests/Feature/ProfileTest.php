<?php

namespace Tests\Feature;

use App\Livewire\Backend\Profile\Info;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_profile_info()
    {
        Profile::factory()->create();

        Livewire::test(Info::class)
            ->assertStatus(200);
    }

    public function test_can_list_profile_info()
    {
        $profile = Profile::factory()->create();

        Livewire::test(Info::class)
            ->set('profileInfo', [])
            ->call('getProfileInfo')
            ->assertSet('profileInfo.phone', $profile->phone)
            ->assertSet('profileInfo.github', $profile->github)
            ->assertSet('profileInfo.twitter', $profile->twitter)
            ->assertSet('profileInfo.linkedin', $profile->linkedin)
            ->assertSet('profileInfo.designation', $profile->designation)
            ->assertSet('profileInfo.intro', $profile->intro);
    }

    public function test_can_update_profile_info()
    {
        Profile::factory()->create();

        Livewire::test(Info::class)
            ->set('profileInfo', [])
            ->call('getProfileInfo')
            ->set('profileInfo.phone', '+912345678')
            ->set('profileInfo.github', 'https://github.com')
            ->set('profileInfo.twitter', 'https://twitter.com')
            ->set('profileInfo.github', 'https://github.com')
            ->call('update')
            ->assertStatus(200);

        $this->assertDatabaseHas('profiles', [
            'phone' => '+912345678',
            'github' => 'https://github.com',
            'twitter' => 'https://twitter.com',
            'github' => 'https://github.com',
        ]);
    }
}
