@if($completedOrders->isEmpty())
    <p class="text-center">Tidak ada pesanan yang telah diselesaikan.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Nama Produk</th>
                <th>Ekspedisi</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($completedOrders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->nama_pemesan }}</td>
                    <td>{{ $order->nama_produk }}</td>
                    <td>{{ $order->ekspedisi }}</td>
                    <td>{{ $order->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif