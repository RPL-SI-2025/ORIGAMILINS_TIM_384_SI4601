@if($users->isEmpty())
    <tr>
        <td colspan="7" class="text-center">User tidak ditemukan</td>
    </tr>
@else
    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ ucfirst($user->role) }}</td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" 
                       id="status_{{ $user->id }}" 
                       {{ $user->is_active ? 'checked' : '' }}
                       onchange="toggleUserStatus({{ $user->id }})"
                       {{ $user->role === 'admin' ? 'disabled' : '' }}>
                <label class="form-check-label" for="status_{{ $user->id }}">
                    {{ $user->is_active ? 'Aktif' : 'Non-aktif' }}
                </label>
            </div>
        </td>
        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-info btn-sm" 
                        onclick="viewUserDetails({{ $user->id }})" 
                        title="Lihat Detail">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </td>
    </tr>
    @endforeach
@endif 