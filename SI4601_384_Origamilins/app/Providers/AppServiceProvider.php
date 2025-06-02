<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Log::info('MIDTRANS_SERVER_KEY: ' . env('MIDTRANS_SERVER_KEY'));
        \Log::info('MIDTRANS_CLIENT_KEY: ' . env('MIDTRANS_CLIENT_KEY'));

        View::composer('user.navigation-menu', function ($view) {
            $userId = Auth::id();

            // Hitung notifikasi belum dibaca
            $notifBelumDibuka = Pesanan::where('user_id', $userId)
                ->whereIn('status', ['Dalam Proses', 'Siap Dikirim', 'Dikirim'])
                ->where('is_read', false)
                ->count();

            // Ambil data notif terbaru (misalnya 5 notif terbaru)
            $notifikasi = Pesanan::where('user_id', $userId)
                ->whereIn('status', ['Dalam Proses', 'Siap Dikirim', 'Dikirim'])
                ->where('is_read', false)
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();

            $view->with(compact('notifBelumDibuka', 'notifikasi'));
        });

        // Global View Composer untuk notifikasi
        View::composer('*', function ($view) {
            $notifBelumDibuka = 0;
            $notifikasi = collect();
            
            if (auth()->check()) {
                $notifBelumDibuka = Pesanan::where('user_id', auth()->id())
                    ->whereIn('status', ['Dalam Proses', 'Siap Dikirim', 'Dikirim'])
                    ->where('is_read', 0)
                    ->count();
                    
                $notifikasi = Notification::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

                // Hitung jumlah item di keranjang (total kuantitas)
                $cart = auth()->user()->cart()->first();
                $cartItemCount = 0;
                if ($cart) {
                    $cartItemCount = $cart->items()->sum('jumlah');
                }
            }
            
            $view->with([
                'notifBelumDibuka' => $notifBelumDibuka,
                'notifikasi' => $notifikasi,
                'cartItemCount' => $cartItemCount ?? 0 // Pastikan selalu ada nilai default
            ]);
        });
    }
}
