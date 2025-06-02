<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event; // Pastikan untuk mengimpor model Event

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        
        $dekorasi = [];
        $merchandise = [];

        $today = Carbon::now();
        $currentYear = $today->year;
        $currentMonth = $today->month;

        foreach (range(1, 12) as $month) {
            if ($month <= $currentMonth) {
                $baseDekorasi = 100 + (sin(($month/12) * 2 * pi()) * 50) + rand(-10, 30);
                $baseMerchandise = 80 + (sin(($month/12) * 2 * pi() + 1) * 30) + rand(-15, 20);
                
                $dekorasi[] = max(0, round($baseDekorasi));
                $merchandise[] = max(0, round($baseMerchandise));
            } else {
                $dekorasi[] = null;
                $merchandise[] = null;
            }
        }

        $actualDekorasi = Pesanan::whereYear('created_at', $currentYear)
            ->whereHas('produk', function($q) {
                $q->where('kategori', 'Dekorasi');
            })
            ->selectRaw('MONTH(created_at) as month, SUM(jumlah) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        $actualMerchandise = Pesanan::whereYear('created_at', $currentYear)
            ->whereHas('produk', function($q) {
                $q->where('kategori', 'Merchandise');
            })
            ->selectRaw('MONTH(created_at) as month, SUM(jumlah) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        if (count($actualDekorasi) > 0 || count($actualMerchandise) > 0) {
            $dekorasi = array_fill(0, 12, 0);
            $merchandise = array_fill(0, 12, 0);
            
            foreach ($actualDekorasi as $month => $total) {
                $dekorasi[$month-1] = (int)$total;
            }
            
            foreach ($actualMerchandise as $month => $total) {
                $merchandise[$month-1] = (int)$total;
            }
        }

        $tahunIni = date('Y');
        $tahunLalu = $tahunIni - 1;

        // Filter kuartal (1-4) atau 'all'
        $kuartal = $request->get('kuartal', 'all');
        $bulanMap = [
            1 => [1,2,3],
            2 => [4,5,6],
            3 => [7,8,9],
            4 => [10,11,12],
            'all' => range(1,12)
        ];
        $bulanDipilih = $bulanMap[$kuartal] ?? $bulanMap['all'];

        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $pendapatanTahunIni = [];
        $pendapatanTahunLalu = [];

        foreach (range(1,12) as $bulan) {
            $pendapatanTahunIni[] = in_array($bulan, $bulanDipilih)
                ? Pesanan::whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahunIni)
                    ->where('status', 'Selesai')
                    ->sum('total_harga')
                : null;
            $pendapatanTahunLalu[] = in_array($bulan, $bulanDipilih)
                ? Pesanan::whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahunLalu)
                    ->where('status', 'Selesai')
                    ->sum('total_harga')
                : null;
        }

        // Hitung total dan persentase naik/turun
        $totalPendapatanIni = array_sum(array_filter($pendapatanTahunIni));
        $totalPendapatanLalu = array_sum(array_filter($pendapatanTahunLalu));
        $persen = $totalPendapatanLalu > 0
            ? round((($totalPendapatanIni - $totalPendapatanLalu) / $totalPendapatanLalu) * 100, 1)
            : 0;

        $pendapatan = $totalPendapatanIni;

        $labelsAll = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $kuartalMap = [
            '1' => [0,1,2],    // Jan, Feb, Mar
            '2' => [3,4,5],    // Apr, Mei, Jun
            '3' => [6,7,8],    // Jul, Agt, Sep
            '4' => [9,10,11],  // Okt, Nov, Des
            'all' => range(0,11)
        ];
        $idxs = $kuartalMap[$kuartal] ?? $kuartalMap['all'];
        $labels = array_map(fn($i) => $labelsAll[$i], $idxs);
        $pendapatanTahunIniFiltered = array_map(fn($i) => $pendapatanTahunIni[$i], $idxs);
        $pendapatanTahunLaluFiltered = array_map(fn($i) => $pendapatanTahunLalu[$i], $idxs);

        // Ambil event bulan terpilih
        $bulanEvent = $request->get('bulan_event', date('m'));
        $events = Event::whereMonth('tanggal_pelaksanaan', $bulanEvent)
            ->whereYear('tanggal_pelaksanaan', date('Y'))
            ->get();

        // Produk terlaris bulan ini
        $bulanNow = date('m');
        $produkTerlaris = Pesanan::with('produk')
            ->whereMonth('created_at', $bulanNow)
            ->selectRaw('produk_id, SUM(jumlah) as total')
            ->groupBy('produk_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Pass variables to the view using compact
        return view('admin.dashboard', compact(
            'months', 'dekorasi', 'merchandise',
            'labels', 'pendapatanTahunIniFiltered', 'pendapatanTahunLaluFiltered',
            'totalPendapatanIni', 'totalPendapatanLalu', 'persen', 'kuartal',
            'pendapatan', 'events', 'produkTerlaris'
        ));
    }
}