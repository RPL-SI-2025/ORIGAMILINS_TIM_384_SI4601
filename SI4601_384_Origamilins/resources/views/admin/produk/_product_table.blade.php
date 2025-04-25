@foreach($products as $key => $product)
<tr>
    <td>{{ $products->firstItem() + $key }}</td>
    <td>
        @if($product->gambar)
            @if(filter_var($product->gambar, FILTER_VALIDATE_URL))
                <img src="{{ $product->gambar }}" alt="{{ $product->nama }}" class="img-thumbnail" style="max-width: 100px;">
            @else
                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="img-thumbnail" style="max-width: 100px;">
            @endif
        @else
            <span class="text-muted">No Image</span>
        @endif
    </td>
    <td>{{ $product->nama }}</td>
    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
    <td>{{ $product->kategori }}</td>
    <td>
        <span class="badge {{ $product->stok > 0 ? 'bg-success' : 'bg-danger' }}">
            {{ $product->stok }}
        </span>
    </td>
    <td>{{ Str::limit($product->deskripsi, 100) }}</td>
    <td>
        <div class="btn-group">
            <a href="{{ route('admin.produk.show', $product->id) }}" class="btn btn-info btn-sm me-2">
                <i class="fas fa-eye"></i> View
            </a>
            <a href="{{ route('admin.produk.edit', $product->id) }}" class="btn btn-warning btn-sm me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="d-inline" id="delete-form-{{ $product->id }}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $product->id }}')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </td>
</tr>
@endforeach 