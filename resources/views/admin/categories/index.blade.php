@extends('layouts.dashboard')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-tags-fill"></i> Kelola Kategori</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Produk</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                <td>
                                    <i class="bi bi-tag-fill text-primary"></i> <strong>{{ $category->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="bi bi-cup-hot"></i> {{ $category->products_count }} produk
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-calendar-check"></i> {{ $category->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-tags fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data kategori.</p>
                                    <small class="text-muted">Klik tombol "Tambah Kategori" untuk menambahkan kategori baru</small>
                                </td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
