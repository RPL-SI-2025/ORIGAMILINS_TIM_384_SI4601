<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['produk', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.product-reviews.index', compact('reviews'));
    }

    public function show(ProductReview $review)
    {
        $review->load(['produk', 'user']);
        return view('admin.product-reviews.show', compact('review'));
    }

    public function approve(ProductReview $review)
    {
        $review->approve();
        return redirect()->route('admin.product-reviews.index')
            ->with('success', 'Ulasan berhasil disetujui');
    }

    public function reject(ProductReview $review)
    {
        $review->reject();
        return redirect()->route('admin.product-reviews.index')
            ->with('success', 'Ulasan berhasil ditolak');
    }

    public function getReviews(Produk $produk)
    {
        $reviews = $produk->reviews()
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        
        return response()->json([
            'html' => view('admin.product-reviews._reviews_table', compact('reviews'))->render(),
            'hasMorePages' => $reviews->hasMorePages()
        ]);
    }
} 