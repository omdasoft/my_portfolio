<?php

namespace Tests\Feature\Contact;

use App\Livewire\Backend\Contact\Index;
use App\Livewire\Backend\Contact\View;
use App\Livewire\Frontend\Index as FrontendIndex;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_send_contact_message(): void
    {
        \App\Models\Profile::factory()->create();

        Livewire::test(FrontendIndex::class)
            ->set('name', 'John Doe')
            ->set('email', 'test@google.com')
            ->set('description', 'Hello, this is a test message.')
            ->call('send')
            ->assertHasNoErrors()
            ->assertSet('isSent', true);

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'test@google.com',
            'description' => 'Hello, this is a test message.',
        ]);
    }

    public function test_contact_form_validation(): void
    {
        \App\Models\Profile::factory()->create();

        Livewire::test(FrontendIndex::class)
            ->set('name', '')
            ->set('email', '')
            ->call('send')
            ->assertHasErrors(['name', 'email']);

        Livewire::test(FrontendIndex::class)
            ->set('email', 'not-an-email')
            ->call('send')
            ->assertHasErrors(['email']);
    }

    public function test_admin_can_view_contact_list(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Contact::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'description' => 'Test Description',
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->get(route('admin.contacts.index'));
        $response->assertOk();
        $response->assertSee('Test User');
        $response->assertSee('test@example.com');

        Livewire::test(Index::class)
            ->assertSee('Test User')
            ->assertSee('test@example.com');
    }

    public function test_admin_can_view_single_contact(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::create([
            'name' => 'View User',
            'email' => 'view@example.com',
            'description' => 'View Description',
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->get(route('admin.contacts.view', $contact->id));
        $response->assertOk();
        $response->assertSee('View User');
        $response->assertSee('View Description');

        Livewire::test(View::class, ['id' => $contact->id])
            ->assertSee('View User')
            ->assertSee('View Description');
    }

    public function test_admin_can_delete_contact(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::create([
            'name' => 'Delete User',
            'email' => 'delete@example.com',
            'description' => 'Delete Description',
            'ip_address' => '127.0.0.1',
        ]);

        Livewire::test(Index::class)
            ->call('showConfirmationModal', $contact->id)
            ->call('deleteConfirmed');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}
