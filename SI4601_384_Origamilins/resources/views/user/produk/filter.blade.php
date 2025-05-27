<div class="filter-sidebar">
  <h5 class="mb-3"><i class="fa fa-filter"></i> FILTER</h5>
  <form method="GET" action="">
    <div class="mb-3">
      <label class="fw-bold mb-2">Kategori</label>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="checkAllKategori">
        <label class="form-check-label" for="checkAllKategori">Semua</label>
      </div>
      @foreach($categories as $category)
        <div class="form-check">
          <input class="form-check-input kategori-checkbox" type="checkbox" name="kategori[]" value="{{ $category }}" id="kategori_{{ $loop->index }}"
            {{ (is_array(request('kategori')) && in_array($category, request('kategori'))) ? 'checked' : '' }}>
          <label class="form-check-label" for="kategori_{{ $loop->index }}">{{ $category }}</label>
        </div>
      @endforeach
    </div>
    <hr>
    <div class="mb-3">
      <label class="fw-bold mb-2">Range Harga</label>
      <div class="input-group mb-2">
        <span class="input-group-text">Rp</span>
        <input type="number" class="form-control" name="harga_min" placeholder="Min" value="{{ request('harga_min') }}">
      </div>
      <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" class="form-control" name="harga_max" placeholder="Max" value="{{ request('harga_max') }}">
      </div>
    </div>
    <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Terapkan</button>
    <a href="{{ route('etalase') }}" class="btn btn-outline-secondary btn-sm mt-2 w-100">Reset</a>
  </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkAllKategori');
    const kategoriCheckboxes = document.querySelectorAll('.kategori-checkbox');
    
    // Fungsi untuk memperbarui status checkbox "Semua"
    function updateCheckAll() {
        const allChecked = Array.from(kategoriCheckboxes).every(cb => cb.checked);
        checkAll.checked = allChecked;
    }

    // Fungsi untuk menangani perubahan checkbox "Semua"
    checkAll.addEventListener('change', function() {
        if (this.checked) {
            // Jika "Semua" dicentang, centang semua checkbox lainnya
            kategoriCheckboxes.forEach(cb => cb.checked = true);
        } else {
            // Jika "Semua" tidak dicentang, hapus centang semua checkbox lainnya
            kategoriCheckboxes.forEach(cb => cb.checked = false);
        }
    });

    // Menangani perubahan checkbox individual
    kategoriCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            // Jika ada checkbox yang tidak dicentang, hapus centang "Semua"
            if (!this.checked) {
                checkAll.checked = false;
            } else {
                // Periksa apakah semua checkbox lain dicentang
                const allChecked = Array.from(kategoriCheckboxes).every(cb => cb.checked);
                checkAll.checked = allChecked;
            }
        });
    });

    // Inisialisasi status awal
    updateCheckAll();

    // Menangani pengiriman form
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const min = form.querySelector('input[name="harga_min"]');
        const max = form.querySelector('input[name="harga_max"]');
        if (min) min.value = min.value.replace(/\./g, '');
        if (max) max.value = max.value.replace(/\./g, '');
    });
});
</script>
<style>
.filter-sidebar {
    background: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}
.filter-sidebar h5 {
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.filter-sidebar hr {
    margin: 1.2rem 0;
    border-color: #eee;
}
.filter-sidebar .form-check-input:checked {
    background-color: #ff6b35;
    border-color: #ff6b35;
}
.filter-sidebar .btn-primary {
    background: #1976d2;
    border: none;
    font-weight: 500;
    border-radius: 8px;
}
.filter-sidebar .btn-primary:hover {
    background: #125ea7;
}
</style> 