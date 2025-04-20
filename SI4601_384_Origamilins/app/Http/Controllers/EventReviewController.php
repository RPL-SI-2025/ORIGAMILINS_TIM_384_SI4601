<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventReview;
use Illuminate\Http\Request;

class EventReviewController extends Controller
{
    public function index()
    {
        $reviews = EventReview::with(['event', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        
        return view('admin.event-reviews.index', compact('reviews'));
    }

    public function show(Event $event)
    {
        $reviews = $event->reviews()
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        
        return view('admin.event-reviews.show', compact('event', 'reviews'));
    }

    public function getReviews(Event $event)
    {
        $reviews = $event->reviews()
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        
        return response()->json([
            'html' => view('admin.event-reviews._reviews_table', compact('reviews'))->render(),
            'hasMorePages' => $reviews->hasMorePages()
        ]);
    }
} 