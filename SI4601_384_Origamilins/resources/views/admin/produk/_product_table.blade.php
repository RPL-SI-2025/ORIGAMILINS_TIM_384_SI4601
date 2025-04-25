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
    <td>Rp {{ number_format($product->harga_dasar, 0, ',', '.') }}</td>
    <td>{{ $product->kategori }}</td>
    <td>
        @php
            $ukuranArray = $product->ukuran ? explode(',', $product->ukuran) : [];
            $ukuranList = [];
            if($product->kategori == 'Merchandise') {
                $ukuranList = ['5 x 5 cm', '10 x 10 cm', '15 x 15 cm', '20 x 20 cm'];
            } else {
                $ukuranList = ['1 meter', '2 meter', '3 meter', '4 meter', '5 meter'];
            }
        @endphp
        @if(!empty($ukuranArray))
            @foreach($ukuranList as $ukuran)
                @if(in_array($ukuran, $ukuranArray))
                    <span class="badge bg-info me-1">{{ $ukuran }}</span>
                @endif
            @endforeach
        @else
            <span class="text-muted">-</span>
        @endif
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