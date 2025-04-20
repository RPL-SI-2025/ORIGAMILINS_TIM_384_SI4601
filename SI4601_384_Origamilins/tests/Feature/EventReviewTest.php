<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventReviewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
        $this->event = Event::factory()->create();
    }

    public function test_admin_can_view_event_reviews_list()
    {
        EventReview::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/event-reviews');

        $response->assertStatus(200)
            ->assertViewHas('reviews');
    }

    public function test_admin_can_view_event_reviews_detail()
    {
        EventReview::factory()->count(3)->create(['event_id' => $this->event->id]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/event-reviews/{$this->event->id}");

        $response->assertStatus(200)
            ->assertViewHas('event')
            ->assertViewHas('reviews');
    }

    public function test_admin_can_get_reviews_via_ajax()
    {
        EventReview::factory()->count(3)->create(['event_id' => $this->event->id]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/event-reviews/{$this->event->id}/get-reviews");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'html',
                'hasMorePages'
            ]);
    }

    public function test_regular_user_cannot_access_event_reviews()
    {
        $response = $this->actingAs($this->user)
            ->get('/admin/event-reviews');

        $response->assertRedirect('/dashboard');
    }

    public function test_guest_cannot_access_event_reviews()
    {
        $response = $this->get('/admin/event-reviews');

        $response->assertRedirect('/login');
    }
} 