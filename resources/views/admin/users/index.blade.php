@extends('layouts.dashboard')

@section('title', 'Kelola User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill"></i> Kelola User</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td>
                                    <i class="bi bi-person-circle text-primary"></i> <strong>{{ $user->name }}</strong>
                                </td>
                                <td>
                                    <i class="bi bi-envelope-fill text-muted"></i> {{ $user->email }}
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-shield-fill-check"></i> {{ ucfirst($user->role) }}
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="bi bi-person-badge"></i> {{ ucfirst($user->role) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-calendar-plus"></i> {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data user.</p>
                                    <small class="text-muted">Klik tombol "Tambah User" untuk menambahkan user baru</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
