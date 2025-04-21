@if($products->isEmpty())
    <tr>
        <td colspan="7" class="text-center">Produk tidak ditemukan</td>
    </tr>
@else
    @foreach($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
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
        <td>Rp {{ number_format((float)$product->harga, 0, ',', '.') }}</td>
        <td>{{ $product->kategori }}</td>
        <td>{{ $product->deskripsi }}</td>
        <td>
            <div class="btn-group">
                <a href="{{ route('admin.produk.edit', $product->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
@endif 