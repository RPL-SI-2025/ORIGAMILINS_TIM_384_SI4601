@if($pengrajin->isEmpty())
    <tr>
        <td colspan="6" class="text-center">Pengrajin tidak ditemukan</td>
    </tr>
@else
    @foreach($pengrajin as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                    {{ $user->is_active ? 'Aktif' : 'Non-aktif' }}
                </span>
            </td>
            <td>
                {{ $user->completed_orders_count ?? 0 }} <!-- Jumlah pesanan terselesaikan -->
            </td>
            <td>
                <button class="btn btn-sm btn-primary" onclick="showPengrajinDetails({{ $user->id }})">
                    Lihat Detail
                </button>
            </td>
        </tr>
    @endforeach
@endif