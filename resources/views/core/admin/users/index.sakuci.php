@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Kelola User')

@section('content')

@php
    $akunSaatIni  = \App\Models\User::current();
    $adaErrorNama = errors()->has('new_username');
    $no = 1;
@endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Kelola User</h1>
            <p class="admin-subtitle">Tambah akun baru, ubah username akunmu, atau hapus akun yang tidak dipakai.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">&larr; Kembali</a>
    </div>

    {{-- Form tambah user --}}
    <div class="card admin-panel no-hover-lift mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3 align-items-start">
                @csrf
                <div class="col-12 col-md-3">
                    <label for="username" class="form-label admin-label">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                           class="form-control {{ errors()->has('username') ? 'is-invalid' : '' }}" maxlength="50">
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12 col-md-3">
                    <label for="password" class="form-label admin-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="form-control {{ errors()->has('password') ? 'is-invalid' : '' }}">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12 col-md-3">
                    <label for="role" class="form-label admin-label">Role</label>
                    <select name="role" id="role" class="form-select {{ errors()->has('role') ? 'is-invalid' : '' }}">
                        @foreach ($roles as $roleOption)
                            <option value="{{ $roleOption->name }}" @if (old('role') === $roleOption->name) selected @endif>{{ $roleOption->name }}</option>
                        @endforeach
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="admin-hint mt-1">Butuh role lain? <a href="{{ route('admin.roles.index') }}">Kelola Role di sini</a>.</div>
                </div>
                <div class="col-12 col-md-3 text-md-end form-btn-offset">
                    <button type="submit" class="btn btn-brand rounded-pill px-4">Tambah user</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar user --}}
    <div class="card admin-panel no-hover-lift">
        @if(count($users) === 0)
            <div class="admin-empty">
                <strong>Belum ada user</strong>
                Tambahkan user pertama lewat formulir di atas.
            </div>
        @else
        <div class="card-body pb-2">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="form-label admin-label mb-0 me-1">Urutkan</span>
                <a href="{{ route('admin.users.index') }}?urut=role"
                   class="btn btn-sm rounded-pill px-3 {{ $urut === 'role' ? 'btn-brand' : 'btn-outline-secondary' }}">Role &amp; nama</a>
                <a href="{{ route('admin.users.index') }}?urut=terbaru"
                   class="btn btn-sm rounded-pill px-3 {{ $urut === 'terbaru' ? 'btn-brand' : 'btn-outline-secondary' }}">Akun terbaru</a>
                <span class="text-secondary small ms-auto">{{ count($users) }} akun</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table admin-table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $item)
                    @php $akunSendiri = $akunSaatIni && $akunSaatIni->id == $item->id; @endphp
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td>
                            @if($akunSendiri)
                                {{-- Hanya akun yang sedang login yang boleh mengubah username-nya.
                                     Buka/tutup form memakai checkbox + CSS (tanpa JavaScript). --}}
                                <input type="checkbox" id="toggleEditUsername" class="edit-toggle" {{ $adaErrorNama ? 'checked' : '' }}>

                                <div class="edit-row">
                                    <span class="cell-main">{{ $item->username }}</span>
                                    <label for="toggleEditUsername" class="edit-pill" title="Edit username">
                                        <svg class="edit-pill-icon" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                        <span class="edit-pill-text">Edit</span>
                                    </label>
                                    <span class="status-pill status-selesai">Anda</span>
                                </div>

                                <div class="edit-form-wrap">
                                    <form action="{{ route('admin.users.update', [$item->id]) }}" method="POST" class="d-flex flex-wrap align-items-start gap-2">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <input type="text" name="new_username" value="{{ old('new_username') ?: $item->username }}"
                                                   class="form-control form-control-sm input-username-edit {{ $adaErrorNama ? 'is-invalid' : '' }}"
                                                   maxlength="50" required aria-label="Username baru">
                                            @error('new_username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3">Simpan</button>
                                    </form>
                                </div>
                            @else
                                <span class="cell-main">{{ $item->username }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-pill {{ $item->role === 'admin' ? 'status-aktif' : 'status-kosong' }}">{{ $item->role }}</span>
                        </td>
                        <td class="text-end text-nowrap">
                            @if($akunSendiri)
                                <span class="cell-meta">-</span>
                            @else
                                <form action="{{ route('admin.users.destroy', [$item->id]) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus akun {{ $item->username }}? Riwayat peminjaman dan pengajuan keanggotaannya juga ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection