@extends('layouts.app')

@section('title', 'NEX-LIB ADMIN -- Kelola Role')

@section('content')

@php $no = 1; @endphp

<div class="admin-page">

    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 admin-title">Kelola Role</h1>
            <p class="admin-subtitle">Tambah role, ganti namanya, atau atur apakah role boleh dipakai untuk daftar mandiri.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">&larr; Kembali</a>
    </div>

    {{-- Form tambah role --}}
    <div class="card admin-panel no-hover-lift mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.roles.store') }}" method="POST" class="row g-3 align-items-start">
                @csrf
                <div class="col-12 col-md-5">
                    <label for="name" class="form-label admin-label">Nama role</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" maxlength="50"
                           placeholder="contoh: siswa"
                           class="form-control {{ errors()->has('name') ? 'is-invalid' : '' }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="admin-hint mt-1">Huruf, angka, strip (-), dan garis bawah (_). Route dan middleware-nya dibuat otomatis.</div>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label admin-label">Pendaftaran</label>
                    <div class="form-check pt-1">
                        <input class="form-check-input" type="checkbox" name="can_register" value="1" id="can_register" {{ old('can_register') ? 'checked' : '' }}>
                        <label class="form-check-label" for="can_register">Boleh daftar mandiri</label>
                    </div>
                </div>
                <div class="col-12 col-md-3 text-md-end form-btn-offset">
                    <button type="submit" class="btn btn-brand px-4">Tambah role</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar role --}}
    <div class="card admin-panel no-hover-lift">
        @if(count($roles) === 0)
            <div class="admin-empty">
                <strong>Belum ada role</strong>
                Tambahkan role pertama lewat formulir di atas.
            </div>
        @else
        <div class="card-body pb-2">
            <div class="d-flex justify-content-end">
                <span class="text-secondary small">{{ count($roles) }} role</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Nama role</th>
                        <th>Daftar mandiri</th>
                        <th>Jumlah user</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    @php
                        $bawaan = $role->name === 'admin'; // role admin tidak bisa diubah / dihapus
                        $jumlahUser = \App\Models\User::where('role', $role->name)->count();
                    @endphp
                    <tr>
                        <td class="cell-meta">{{ $no++ }}</td>
                        <td>
                            @if($bawaan)
                                <div class="edit-row">
                                    <span class="cell-main">{{ $role->name }}</span>
                                    <span class="badge badge-role badge-anda">Bawaan</span>
                                </div>
                            @else
                                {{-- Buka/tutup form ubah memakai checkbox + CSS (tanpa JavaScript),
                                     id-nya dibuat unik per role. --}}
                                <input type="checkbox" id="toggleEditRole{{ $role->id }}" class="edit-toggle">

                                <div class="edit-row">
                                    <span class="cell-main">{{ $role->name }}</span>
                                    <label for="toggleEditRole{{ $role->id }}" class="edit-pill" title="Ubah role" aria-label="Ubah role {{ $role->name }}">
                                        <svg class="edit-pill-icon" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </label>
                                </div>

                                <div class="edit-form-wrap">
                                    <form action="{{ route('admin.roles.update', [$role->id]) }}" method="POST" class="d-flex flex-wrap align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $role->name }}"
                                               class="form-control form-control-sm input-username-edit"
                                               maxlength="50" required aria-label="Nama role baru">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" name="can_register" value="1" id="canRegister{{ $role->id }}" {{ $role->can_register ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="canRegister{{ $role->id }}">Boleh daftar mandiri</label>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-brand px-3">Simpan</button>
                                    </form>
                                    <div class="admin-hint mt-1">Mengganti nama juga memindahkan semua user ke nama baru.</div>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($role->can_register)
                                <span class="status-pill status-aktif">Boleh</span>
                            @else
                                <span class="status-pill status-kosong">Tidak</span>
                            @endif
                        </td>
                        <td class="cell-meta">{{ $jumlahUser }} user</td>
                        <td class="text-end text-nowrap">
                            @if($bawaan)
                                <span class="cell-meta">-</span>
                            @else
                                <form action="{{ route('admin.roles.destroy', [$role->id]) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus role {{ $role->name }}? {{ $jumlahUser }} user dengan role ini juga ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary px-3">Hapus</button>
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