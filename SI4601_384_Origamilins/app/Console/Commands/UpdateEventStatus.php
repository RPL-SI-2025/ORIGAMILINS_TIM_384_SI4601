<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class UpdateEventStatus extends Command
{
    protected $signature = 'events:update-status';
    protected $description = 'Update event statuses based on their dates';

    public function handle()
    {
        $this->info('Starting to update event statuses...');

        Event::chunk(100, function($events) {
            foreach($events as $event) {
                $oldStatus = $event->status;
                $event->updateStatusBasedOnDate();
                
                if ($oldStatus !== $event->status) {
                    $this->line("Updated event '{$event->nama_event}' status from {$oldStatus} to {$event->status}");
                }
            }
        });

        $this->info('Finished updating event statuses.');
    }
} 