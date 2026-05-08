@extends('layout.app')

@section('title', 'Edit Profil')

@section('content')
@php
    $userData = $user ?? (object) [
        'name' => 'Ahmad Sulaiman',
        'email' => 'ahmad.sulaiman@univ.ac.id',
    ];

    $mahasiswaData = $mahasiswa ?? (object) [
        'nim' => '20210810054',
        'prodi' => (object) [
            'nama_prodi' => 'Informatika',
        ],
    ];

    $prodis = $prodis ?? collect([
        (object) ['id' => 1, 'nama_prodi' => 'Informatika'],
        (object) ['id' => 2, 'nama_prodi' => 'Teknik Komputer'],
        (object) ['id' => 3, 'nama_prodi' => 'Sistem Informasi'],
        (object) ['id' => 4, 'nama_prodi' => 'Teknik Elektro'],
    ]);

    $rekamMedis = $rekamMedis ?? collect([
        'Alergi Paracetamol',
        'Alergi Antibiotik',
        'Maag',
    ]);

    $lastUpdated = $lastUpdated ?? '12 Oktober 2025';
@endphp

<section class="profile-edit-page">
    <div class="page-container">

        <div class="hero-section">
        <div class="profile-card">
            <div class="page-header">
                <h1>Edit Profil Anda</h1>
                <p>Perbarui data diri untuk kelancaran layanan kesehatan.</p>
            </div>

            <form action="{{ route('pasien.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-icon">
                            <i class="fa-regular fa-user"></i>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $userData->name ?? '') }}"
                                placeholder="Nama lengkap"
                            >
                        </div>
                        @error('name')
                            <small class="error-text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nim">NIM (Nomor Induk Mahasiswa)</label>
                        <div class="input-icon">
                            <i class="fa-regular fa-id-badge"></i>
                            <input
                                type="text"
                                id="nim"
                                name="nim"
                                value="{{ old('nim', $mahasiswaData->nim ?? '') }}"
                                placeholder="NIM"
                            >
                        </div>
                        @error('nim')
                            <small class="error-text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-icon">
                            <i class="fa-regular fa-envelope"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $userData->email ?? '') }}"
                                placeholder="Email aktif"
                            >
                        </div>
                        @error('email')
                            <small class="error-text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prodi_id">Program Studi (Prodi)</label>
                        <div class="input-icon select-wrap">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <select id="prodi_id" name="prodi_id">
                                <option value="">Pilih Prodi</option>
                                @foreach($prodis as $prodi)
                                    <option
                                        value="{{ $prodi->id }}"
                                        @selected(old('prodi_id', optional($mahasiswaData->prodi)->id ?? null) == $prodi->id)
                                    >
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down select-arrow"></i>
                        </div>
                        @error('prodi_id')
                            <small class="error-text">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="medical-section">
                    <div class="section-title">
                        <h2>Rekam Medis</h2>
                    </div>

                    <div class="medical-list">
                        @forelse($rekamMedis as $item)
                            <div class="medical-item">
                                <input
                                    type="text"
                                    name="rekam_medis[]"
                                    value="{{ old('rekam_medis.' . $loop->index, $item) }}"
                                    placeholder="Tambah riwayat penyakit..."
                                >
                            </div>
                        @empty
                            <div class="medical-item">
                                <input
                                    type="text"
                                    name="rekam_medis[]"
                                    value="{{ old('rekam_medis.0') }}"
                                    placeholder="Tambah riwayat penyakit..."
                                >
                            </div>
                        @endforelse

                        <div class="medical-item add-item">
                            <input
                                type="text"
                                name="rekam_medis[]"
                                value="{{ old('rekam_medis.999') }}"
                                placeholder="Tambah riwayat penyakit..."
                            >
                        </div>
                    </div>
                </div>

                <div class="save-row">
                    <div class="updated-info">
                        <i class="fa-regular fa-circle-info"></i>
                        <span>Terakhir diperbarui: {{ $lastUpdated }}</span>
                    </div>

                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <div class="action-grid">
                <a href="#" class="action-card">
                    <div class="action-icon navy">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div class="action-text">
                        <h3>Ubah Kata Sandi</h3>
                        <p>Tingkatkan keamanan akun Anda secara berkala.</p>
                    </div>
                </a>

                <a href="#" class="action-card danger">
                    <div class="action-icon red">
                        <i class="fa-regular fa-trash-can"></i>
                    </div>
                    <div class="action-text">
                        <h3>Nonaktifkan Akun</h3>
                        <p>Hapus akses Anda dari layanan poliklinik.</p>
                    </div>
                </a>
            </div>
        </div>
        </div>

    </div>
</section>

<style>
    .profile-edit-page {
        padding: 28px 24px 64px;
        background: #f5f7fb;
    }

    .page-container {
        width: 100%;
    }

    .hero-section {
        padding: 24px;
        background: #f3f4f6;
        padding-top: 100px;
    }
    .profile-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 34px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
    }

    .page-header {
        margin-bottom: 28px;
    }

    .page-header h1 {
        margin: 0 0 8px;
        font-size: 36px;
        line-height: 1.1;
        color: #102b57;
        font-weight: 900;
    }

    .page-header p {
        margin: 0;
        color: #64748b;
        font-size: 15px;
    }

    form {
        width: 100%;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 10px;
        font-size: 12px;
        font-weight: 800;
        color: #102b57;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .input-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon i:not(.select-arrow) {
        position: absolute;
        left: 16px;
        color: #4b5563;
        font-size: 16px;
        pointer-events: none;
    }

    .input-icon input,
    .input-icon select {
        width: 100%;
        border: none;
        outline: none;
        background: #f4f4f6;
        border-radius: 14px;
        padding: 16px 18px 16px 48px;
        font-size: 15px;
        color: #2d3137;
        transition: .25s ease;
        appearance: none;
    }

    .input-icon input:focus,
    .input-icon select:focus {
        background: #eef4ff;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12);
    }

    .select-wrap {
        position: relative;
    }

    .select-arrow {
        position: absolute;
        right: 16px;
        color: #4b5563;
        font-size: 14px;
        pointer-events: none;
    }

    .medical-section {
        margin-top: 26px;
    }

    .section-title {
        margin-bottom: 14px;
    }

    .section-title h2 {
        margin: 0;
        font-size: 16px;
        color: #102b57;
        font-weight: 900;
    }

    .medical-list {
        display: grid;
        gap: 12px;
    }

    .medical-item input {
        width: 100%;
        border: none;
        outline: none;
        background: #f4f4f6;
        border-radius: 14px;
        padding: 16px 18px;
        font-size: 15px;
        color: #2d3137;
        transition: .25s ease;
    }

    .medical-item input:focus {
        background: #eef4ff;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12);
    }

    .save-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding-top: 24px;
        margin-top: 26px;
        border-top: 1px solid #e5e7eb;
    }

    .updated-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #64748b;
    }

    .btn-save {
        border: none;
        background: #facc15;
        color: #102b57;
        padding: 16px 28px;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 10px 24px rgba(250, 204, 21, 0.18);
        transition: .25s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-save:hover {
        background: #eab308;
        transform: translateY(-2px);
    }

    .action-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-top: 26px;
    }

    .action-card {
        text-decoration: none;
        background: #f8fafc;
        border-radius: 18px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: .25s ease;
        border: 1px solid #eef2f7;
    }

    .action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
    }

    .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
        flex-shrink: 0;
    }

    .action-icon.navy {
        color: #102b57;
    }

    .action-icon.red {
        color: #dc2626;
    }

    .action-text h3 {
        margin: 0 0 4px;
        font-size: 16px;
        color: #102b57;
        font-weight: 800;
    }

    .action-text p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    .error-text {
        margin-top: 8px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .action-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profile-edit-page {
            padding: 18px 14px 50px;
        }

        .profile-card {
            padding: 22px;
        }

        .page-header h1 {
            font-size: 28px;
        }

        .save-row {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-save {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection