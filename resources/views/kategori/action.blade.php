<div class="d-flex inline-block">
    <a href="{{ url('/kategori/ubah', $kategori_id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
    <a href="{{ url('/kategori/hapus', $kategori_id) }}" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-sm btn-danger">Hapus</a>
    {{-- <form action="{{ url('/kategori/hapus', $kategori_id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
    </form> --}}
</div>