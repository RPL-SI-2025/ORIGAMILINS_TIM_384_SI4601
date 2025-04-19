<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class EventFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'role' => 'admin'
        ]);

        Event::create([
            'nama_event' => 'Event Pertama',
            'deskripsi' => 'Deskripsi event pertama',
            'tanggal_pelaksanaan' => '2024-03-01',
            'harga' => 100000,
            'lokasi' => 'Jakarta',
            'poster' => '/uploads/test1.jpg'
        ]);

        Event::create([
            'nama_event' => 'Event Kedua',
            'deskripsi' => 'Deskripsi event kedua',
            'tanggal_pelaksanaan' => '2024-03-15',
            'harga' => 200000,
            'lokasi' => 'Bandung',
            'poster' => '/uploads/test2.jpg'
        ]);

        Event::create([
            'nama_event' => 'Event Ketiga',
            'deskripsi' => 'Deskripsi event ketiga',
            'tanggal_pelaksanaan' => '2024-04-01',
            'harga' => 300000,
            'lokasi' => 'Surabaya',
            'poster' => '/uploads/test3.jpg'
        ]);
    }

    public function it_can_filter_events_by_name()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.event.index', ['nama_event' => 'Pertama']));
        
        $response->assertStatus(200);
        $response->assertSee('Event Pertama');
        $response->assertDontSee('Event Kedua');
        $response->assertDontSee('Event Ketiga');
    }

    public function it_can_filter_events_by_location()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.event.index', ['lokasi' => 'Bandung']));
        
        $response->assertStatus(200);
        $response->assertSee('Event Kedua');
        $response->assertDontSee('Event Pertama');
        $response->assertDontSee('Event Ketiga');
    }

    public function it_can_filter_events_by_date_range()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.event.index', [
                'tanggal_awal' => '2024-03-01',
                'tanggal_akhir' => '2024-03-31'
            ]));
        
        $response->assertStatus(200);
        $response->assertSee('Event Pertama');
        $response->assertSee('Event Kedua');
        $response->assertDontSee('Event Ketiga');
    }

    public function it_can_filter_events_by_price_range()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.event.index', [
                'harga_min' => 150000,
                'harga_max' => 250000
            ]));
        
        $response->assertStatus(200);
        $response->assertSee('Event Kedua');
        $response->assertDontSee('Event Pertama');
        $response->assertDontSee('Event Ketiga');
    }

    public function it_can_combine_multiple_filters()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.event.index', [
                'nama_event' => 'Event',
                'tanggal_awal' => '2024-03-01',
                'harga_max' => 250000
            ]));
        
        $response->assertStatus(200);
        $response->assertSee('Event Pertama');
        $response->assertSee('Event Kedua');
        $response->assertDontSee('Event Ketiga');
    }

    public function it_returns_all_events_when_no_filters_are_applied()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.event.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Event Pertama');
        $response->assertSee('Event Kedua');
        $response->assertSee('Event Ketiga');
    }

    public function it_returns_no_events_when_filters_dont_match()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.event.index', [
                'nama_event' => 'NonExistent',
                'tanggal_awal' => '2024-01-01',
                'tanggal_akhir' => '2024-01-31'
            ]));
        
        $response->assertStatus(200);
        $response->assertSee('Tidak ada event');
        $response->assertDontSee('Event Pertama');
        $response->assertDontSee('Event Kedua');
        $response->assertDontSee('Event Ketiga');
    }

    public function it_redirects_to_login_when_not_authenticated()
    {
        $response = $this->get(route('admin.event.index'));
        $response->assertRedirect(route('login'));
    }
} 