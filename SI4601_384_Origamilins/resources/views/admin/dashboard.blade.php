@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Statistik Dashboard -->
    <div class="row">
        <!-- Statistik Pesanan -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card dashboard-stat-card">
                <div class="card-body stat-card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Pesanan::count() }}</h2>
                            <p class="text-muted mb-0">Total Pesanan</p>
                            <a href="{{ route('admin.pesananproduk.index') }}" class="btn btn-sm mt-2" style="background-color: #f9bd1e; color: #fff; border: none;">
                                <i class="fas fa-shopping-cart me-1"></i> Kelola Pesanan
                            </a>
                        </div>
                        <span class="icon-circle warning">
                            <i class="fas fa-shopping-cart" style="color: #ff8c00"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Produk -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card dashboard-stat-card">
                <div class="card-body stat-card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Produk::count() }}</h2>
                            <p class="text-muted mb-0">Total Produk</p>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-sm mt-2" style="background-color: #f9bd1e; color: #fff; border: none;">
                                <i class="fas fa-box me-1"></i> Kelola Produk
                            </a>
                        </div>
                        <span class="icon-circle warning">
                            <i class="fas fa-box" style="color: #ff8c00"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Event -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card dashboard-stat-card">
                <div class="card-body stat-card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Event::count() }}</h2>
                            <p class="text-muted mb-0">Total Event</p>
                            <a href="{{ route('admin.event.index') }}" class="btn btn-sm mt-2" style="background-color: #f9bd1e; color: #fff; border: none;">
                                <i class="fas fa-calendar me-1"></i> Kelola Event
                            </a>
                        </div>
                        <span class="icon-circle warning">
                            <i class="fas fa-calendar" style="color: #ff8c00"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Artikel -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card dashboard-stat-card">
                <div class="card-body stat-card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="fw-bold mb-0">
                                    {{ \App\Models\Artikel::count() }}
                            </h2>
                            <p class="text-muted mb-0">Total Artikel</p>
                            <a href="{{ route('admin.artikel.index') }}" class="btn btn-sm mt-2" style="background-color: #f9bd1e; color: #fff; border: none;">
                                <i class="fas fa-newspaper me-1"></i> Kelola Artikel
                            </a>
                        </div>
                        <div class="icon-circle warning">
                            <i class="fas fa-newspaper" style="color: #ff8c00"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Statistik Penjualan Produk -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-chart-line me-2" style="color:#f9bd1e;font-size:1.5rem"></i>
                        <h5 class="mb-0">Penjualan Produk</h5>
                    </div>
                    <div class="btn-group mb-3" role="group">
                        <button id="btnThisYear" type="button" class="btn btn-outline-secondary active">Tahun Ini</button>
                        <button id="btnLastMonth" type="button" class="btn btn-outline-secondary">Bulan Lalu</button>
                        <button id="btnCompare" type="button" class="btn btn-outline-secondary">Perbandingan</button>
                    </div>
                    <div style="height:220px;">
                        <canvas id="penjualanChart"></canvas>
                    </div>
                    <div class="mt-2">
                        <span class="badge" style="background:#ff7ca3;color:#fff;">● Dekorasi</span>
                        <span class="badge" style="background:#3f51b5;color:#fff;">● Merchandise</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Perbandingan Pendapatan -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-clipboard-list me-2" style="color:#f9bd1e;font-size:1.5rem"></i>
                        <h5 class="mb-0">Perbandingan Pendapatan</h5>
                        <form method="get" class="ms-auto" style="min-width:120px;">
                            <select name="kuartal" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="all" {{ $kuartal=='all'?'selected':'' }}>12 Bulan</option>
                                <option value="1" {{ $kuartal==1?'selected':'' }}>Kuartal 1</option>
                                <option value="2" {{ $kuartal==2?'selected':'' }}>Kuartal 2</option>
                                <option value="3" {{ $kuartal==3?'selected':'' }}>Kuartal 3</option>
                                <option value="4" {{ $kuartal==4?'selected':'' }}>Kuartal 4</option>
                            </select>
                        </form>
                    </div>
                    <div class="mb-1" style="font-size:1.1rem;">Total Pendapatan</div>
                    <div class="d-flex align-items-center mb-2">
                        <span style="font-size:2rem;font-weight:700;">Rp{{ number_format($totalPendapatanIni,0,',','.') }}</span>
                        <span class="ms-3" style="color:{{ $persen>=0 ? '#27ae60':'#e74c3c' }};font-weight:600;">
                            <i class="fas fa-arrow-{{ $persen>=0 ? 'up':'down' }}"></i>
                            {{ $persen>=0 ? '+' : '' }}{{ $persen }}%
                        </span>
                    </div>
                    <div style="height:180px; max-width:100%; margin-bottom:10px;">
    <canvas id="pendapatanChart" style="max-height:180px;"></canvas>
</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Verifikasi Pembayaran -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-credit-card me-2" style="color:#f9bd1e;font-size:1.5rem"></i>
                            <h5 class="mb-0">Verifikasi Pembayaran</h5>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div style="width:110px;height:110px;">
                                <canvas id="verifikasiChart"></canvas>
                            </div>
                            <div class="d-flex flex-column justify-content-center" style="font-size:1rem; min-height:110px;">
                                <span style="color:#f9bd1e;font-weight:600;">
                                    <span id="belumVerif">0</span> Belum
                                </span>
                                <span style="color:#27ae60;font-weight:600;">
                                    <span id="terverif">0</span> Terverifikasi
                                </span>
                                <span style="color:#e74c3c;font-weight:600;">
                                    <span id="ditolak">0</span> Ditolak
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-muted" style="font-size:0.95rem;">
                        <span id="totalPembayaran">0</span> pembayaran minggu ini
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris Bulan Ini -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-2" style="font-size:1.1rem;">
                            <i class="fas fa-trophy me-2" style="color:#f9bd1e;font-size:1.5rem"></i>
                            <h5 class="mb-0">Produk Terlaris Bulan Ini</h5>
                        </div>
                        <ul class="list-group list-group-flush" style="max-height:110px;overflow-y:auto;min-height:70px;">
                            @forelse($produkTerlaris as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-2 py-2" style="border:none;">
                                    <span class="fw-semibold" style="color:#333;">{{ $item->produk->nama_produk ?? '-' }}</span>
                                    <span class="badge rounded-pill" style="background:#f9bd1e;color:#fff;font-size:1rem;">{{ $item->total }} terjual</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted px-2 py-2" style="border:none;">Belum ada penjualan bulan ini.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kalender Event Modern -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-alt me-2" style="color:#f9bd1e"></i>
                            <h5 class="mb-0">Kalender Event</h5>
                            <form method="get" class="ms-auto" style="min-width:90px;">
                                <select name="bulan_event" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach(['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'] as $num=>$bln)
                                        <option value="{{ $num }}" {{ request('bulan_event', date('m')) == $num ? 'selected' : '' }}>{{ $bln }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div id="calendar-modern" class="calendar-modern" style="min-height:170px;"></div>
                        <div id="event-list-modern" class="event-list-modern mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data dari controller
    const months = @json($months);
    const dekorasiData = @json($dekorasi);
    const merchandiseData = @json($merchandise);
    
    // Last month data (simulation)
    const lastMonthDekorasi = dekorasiData.map(value => Math.max(0, value * 0.8 + Math.random() * 20 - 10));
    const lastMonthMerchandise = merchandiseData.map(value => Math.max(0, value * 0.7 + Math.random() * 15 - 7));

    // Setup chart
    const ctx = document.getElementById('penjualanChart').getContext('2d');
    let penjualanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Dekorasi',
                    data: dekorasiData,
                    borderColor: '#ff7ca3',
                    backgroundColor: 'rgba(255,124,163,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#ff7ca3',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                },
                {
                    label: 'Merchandise',
                    data: merchandiseData,
                    borderColor: '#3f51b5',
                    backgroundColor: 'rgba(63,81,181,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3f51b5',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0,0,0,0.7)',
                    padding: 10,
                    cornerRadius: 4,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y;
                            return label;
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Button functionality
    document.getElementById('btnThisYear').addEventListener('click', function() {
        setActiveButton(this);
        updateChart('thisYear');
    });

    document.getElementById('btnLastMonth').addEventListener('click', function() {
        setActiveButton(this);
        updateChart('lastMonth');
    });

    document.getElementById('btnCompare').addEventListener('click', function() {
        setActiveButton(this);
        updateChart('compare');
    });

    function setActiveButton(activeBtn) {
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        activeBtn.classList.add('active');
    }

    function updateChart(type) {
        // Destroy existing chart
        penjualanChart.destroy();

        let datasets = [];
        let chartLabels = months;

        if (type === 'thisYear') {
            datasets = [
                {
                    label: 'Dekorasi',
                    data: dekorasiData,
                    borderColor: '#ff7ca3',
                    backgroundColor: 'rgba(255,124,163,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#ff7ca3',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                },
                {
                    label: 'Merchandise',
                    data: merchandiseData,
                    borderColor: '#3f51b5',
                    backgroundColor: 'rgba(63,81,181,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3f51b5',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                }
            ];
        } else if (type === 'lastMonth') {
            datasets = [
                {
                    label: 'Dekorasi (Bulan Lalu)',
                    data: lastMonthDekorasi,
                    borderColor: '#ff7ca3',
                    backgroundColor: 'rgba(255,124,163,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#ff7ca3',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                },
                {
                    label: 'Merchandise (Bulan Lalu)',
                    data: lastMonthMerchandise,
                    borderColor: '#3f51b5',
                    backgroundColor: 'rgba(63,81,181,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3f51b5',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                }
            ];
        } else if (type === 'compare') {
            datasets = [
                {
                    label: 'Dekorasi (Tahun Ini)',
                    data: dekorasiData,
                    borderColor: '#ff7ca3',
                    backgroundColor: 'rgba(255,124,163,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#ff7ca3',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                },
                {
                    label: 'Dekorasi (Bulan Lalu)',
                    data: lastMonthDekorasi,
                    borderColor: '#ff7ca3',
                    borderDash: [5, 5],
                    backgroundColor: 'rgba(255,124,163,0)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#ff7ca3',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    borderWidth: 2
                },
                {
                    label: 'Merchandise (Tahun Ini)',
                    data: merchandiseData,
                    borderColor: '#3f51b5',
                    backgroundColor: 'rgba(63,81,181,0.1)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3f51b5',
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    borderWidth: 3
                },
                {
                    label: 'Merchandise (Bulan Lalu)',
                    data: lastMonthMerchandise,
                    borderColor: '#3f51b5',
                    borderDash: [5, 5],
                    backgroundColor: 'rgba(63,81,181,0)',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3f51b5',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    borderWidth: 2
                }
            ];
        }

        penjualanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        padding: 10,
                        cornerRadius: 4,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    const verifikasiData = {
        belum: {{ $belumTerverifikasi ?? 12 }},
        terverif: {{ $terverifikasi ?? 26 }},
        ditolak: {{ $ditolak ?? 0 }},
        total: {{ $totalPembayaran ?? 45 }}
    };

    // Set label
    document.getElementById('belumVerif').textContent = verifikasiData.belum;
    document.getElementById('terverif').textContent = verifikasiData.terverif;
    document.getElementById('ditolak').textContent = verifikasiData.ditolak;
    document.getElementById('totalPembayaran').textContent = verifikasiData.total;

    // Donut Chart
    new Chart(document.getElementById('verifikasiChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Belum Terverifikasi', 'Terverifikasi', 'Ditolak'],
            datasets: [{
                data: [verifikasiData.belum, verifikasiData.terverif, verifikasiData.ditolak],
                backgroundColor: ['#f9bd1e', '#27ae60', '#e74c3c'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false }, 
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed;
                        }
                    }
                }
            }
        }
        });

    // Pendapatan Chart
    const pendapatanCtx = document.getElementById('pendapatanChart').getContext('2d');
    new Chart(pendapatanCtx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: '{{ date('Y', strtotime('-1 year')) }}',
                    data: @json($pendapatanTahunLaluFiltered),
                    backgroundColor: 'rgba(255,193,7,0.4)',
                    borderRadius: 6,
                    barPercentage: 0.5,
                    categoryPercentage: 0.5
                },
                {
                    label: '{{ date('Y') }}',
                    data: @json($pendapatanTahunIniFiltered),
                    backgroundColor: '#f9bd1e',
                    borderRadius: 6,
                    barPercentage: 0.5,
                    categoryPercentage: 0.5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let val = context.parsed.y || 0;
                            return context.dataset.label + ': Rp' + val.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 500000,
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Kalender Modern
    const events = @json($events);
    const calendarEl = document.getElementById('calendar-modern');
    const eventListEl = document.getElementById('event-list-modern');
    const bulan = "{{ request('bulan_event', date('m')) }}";
    const tahun = "{{ date('Y') }}";
    const eventMap = {};
    events.forEach(ev => {
        const tgl = (new Date(ev.tanggal_pelaksanaan)).toISOString().slice(0,10);
        if (!eventMap[tgl]) eventMap[tgl] = [];
        eventMap[tgl].push(ev);
    });

    function renderCalendar() {
        const firstDay = new Date(`${tahun}-${bulan}-01`);
        const lastDay = new Date(tahun, bulan, 0);
        let html = '<table><thead><tr>';
        ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'].forEach(d=>html+=`<th>${d[0]}</th>`);
        html += '</tr></thead><tbody><tr>';
        let day = new Date(firstDay);
        day.setDate(day.getDate() - day.getDay());
        let selectedDate = null;
        for(let week=0; week<6; week++) {
            for(let d=0; d<7; d++) {
                const dateStr = day.toISOString().slice(0,10);
                let classes = [];
                if(day.getMonth()+1 == parseInt(bulan)) {
                    if(eventMap[dateStr]) classes.push('has-event');
                } else {
                    classes.push('text-muted');
                }
                html += `<td class="${classes.join(' ')}" data-date="${dateStr}">${day.getDate()}</td>`;
                day.setDate(day.getDate()+1);
            }
            html += '</tr>';
            if(day.getMonth()+1 > parseInt(bulan) && day.getDay()===0) break;
            if(week<5) html += '<tr>';
        }
        html += '</tbody></table>';
        calendarEl.innerHTML = html;

        // Click event
        calendarEl.querySelectorAll('td').forEach(td => {
            td.onclick = function() {
                calendarEl.querySelectorAll('td').forEach(x=>x.classList.remove('selected'));
                this.classList.add('selected');
                showEvent(this.dataset.date);
            }
        });
    }

    function showEvent(dateStr) {
        const list = eventMap[dateStr] || [];
        if(list.length === 0) {
            eventListEl.innerHTML = '<div class="text-muted">Tidak ada event pada tanggal ini.</div>';
        } else {
            let html = `<div class="event-title">${new Date(dateStr).getDate()} ${calendarEl.querySelector('select')?.options[calendarEl.querySelector('select')?.selectedIndex]?.text || ''}</div>`;
            list.forEach(ev => {
                html += `<div class="event-detail">• ${ev.nama_event} <span class="badge bg-${ev.status=='Terlaksana'?'success':'warning'} ms-2">${ev.status}</span></div>`;
            });
            eventListEl.innerHTML = html;
        }
    }

    renderCalendar();
});
</script>
@endpush

<style>
.dashboard-stat-card {
    transition: all 0.3s ease;
}
.dashboard-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #fff3cd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
.dashboard-list {
    max-height: 350px;
    overflow-y: auto;
}
.btn-outline-secondary.active {
    background-color: #f9bd1e;
    border-color: #f9bd1e;
    color: white;
}
.btn-outline-secondary:hover:not(.active) {
    background-color: #ffe9b0;
    border-color: #f9bd1e;
    color: #212529;
}
.btn-group .btn {
    font-size: 0.8rem;
}
.calendar-container table th, .calendar-container table td {
    padding: 0.3rem !important;
}
.calendar-container table td {
    min-width: 36px;
    max-width: 44px;
    border-radius: 6px;
}
.leaderboard-modern .list-group-item {
    border: none !important;
    margin-bottom: 2px;
    background: transparent;
}
.card {
    border-radius: 16px !important;
}
.card-body {
    border-radius: 16px !important;
    padding: 1.25rem 1.25rem 1rem 1.25rem !important;
    min-height: 270px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.list-group-item {
    border: none !important;
    background: transparent !important;
}
.calendar-modern {
    min-width: 100%;
    max-width: 100%;
    min-height: 170px;
}
.calendar-modern table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0.2rem;
}
.calendar-modern th {
    color: #f9bd1e;
    font-weight: 700;
    background: none;
    border: none;
    font-size: 0.95rem;
    text-align: center;
}
.calendar-modern td {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.2s;
    border: none;
    background: #f8f9fa;
    color: #333;
    position: relative;
    font-size: 0.95rem;
}
.calendar-modern td.has-event {
    background: #f9bd1e;
    color: #fff;
    font-weight: 700;
}
.calendar-modern td.selected {
    border: 2px solid #f9bd1e;
    background: #fffbe7;
    color: #f9bd1e;
}
.event-list-modern {
    min-height: 40px;
}
.event-list-modern .event-title {
    font-weight: 600;
    color: #f9bd1e;
    font-size: 1.05rem;
}
.event-list-modern .event-detail {
    font-size: 0.95rem;
    color: #333;
    margin-bottom: 4px;
    margin-left: 8px;
}
.stat-card-body {
    min-height: unset !important;
    height: auto !important;
    display: block !important;
    padding: 1.25rem 1.25rem 1rem 1.25rem !important;
}
@media (max-width: 991.98px) {
    .col-lg-4.mb-4 {
        margin-bottom: 1.5rem !important;
    }
    .card-body {
        min-height: 200px;
    }
}
</style>