<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function show(EventReview $review)
    {
        $review->load(['event', 'user']);
        return view('admin.event-reviews.show', compact('review'));
    }

    public function approve(EventReview $review)
    {
        try {
            $review->update(['status' => 'Disetujui']);
            return redirect()->back()->with('success', 'Ulasan berhasil disetujui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyetujui ulasan');
        }
    }

    public function reject(EventReview $review)
    {
        try {
            $review->update(['status' => 'Ditolak']);
            return redirect()->back()->with('success', 'Ulasan berhasil ditolak');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak ulasan');
        }
    }
} 