
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
        <td>{{ ucfirst($user->role) }}</td>
        <td>
            <div class="form-check form-switch d-flex align-items-center gap-2">
                <input 
                    type="checkbox" 
                    class="form-check-input" 
                    id="status_{{ $user->id }}" 
                    role="switch"
                    {{ $user->is_active ? 'checked' : '' }}
                    onchange="togglePengrajinStatus({{ $user->id }})"
                >
                <label class="form-check-label mb-0" for="status_{{ $user->id }}">
                    {{ $user->is_active ? 'Aktif' : 'Non-aktif' }}
                </label>
            </div>
        </td>
        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
    </tr>
    @endforeach
@endif