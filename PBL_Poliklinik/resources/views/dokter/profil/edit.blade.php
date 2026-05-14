@extends('layout.app')

@php
    $dokterLayout = true;
@endphp

@section('content')

<section class="ep-section">
<div class="ep-container">

    {{-- CARD FORM --}}
    <div class="ep-card">

        {{-- CARD HEAD --}}
        <div class="ep-card__head">
            <div>
                <h2>Edit Profil Anda</h2>
                <p>Perbarui data diri untuk kelancaran layanan kesehatan.</p>
            </div>
            <a href="{{ route('dokter.profil.show') }}" class="ep-btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- FOTO UPLOAD --}}
        <div class="ep-foto-row">
            <div class="ep-foto-wrap">
                <img id="ep-preview" src="https://ui-avatars.com/api/?name=Satra+Wiyanto&background=102b57&color=fff&size=120" alt="Foto Profil">
                <label for="ep-foto-input" class="ep-foto-overlay" title="Ganti foto">
                    <i class="fa-solid fa-camera"></i>
                </label>
                <input type="file" id="ep-foto-input" accept="image/*" style="display:none" onchange="previewFoto(event)">
            </div>
            <div class="ep-foto-info">
                <h4>Foto Profil</h4>
                <p>Format JPG, PNG atau GIF. Ukuran maks 2MB.</p>
                <label for="ep-foto-input" class="ep-btn-upload">
                    <i class="fa-solid fa-upload"></i> Upload Foto
                </label>
            </div>
        </div>

        {{-- FORM --}}
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="ep-form-grid">

                {{-- NAMA LENGKAP --}}
                <div class="ep-field">
                    <label>NAMA LENGKAP</label>
                    <div class="ep-input-wrap">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="nama" value="dr. dr. Satra Wiyanto, MARS" placeholder="Nama lengkap">
                    </div>
                </div>

                {{-- NIP --}}
                <div class="ep-field">
                    <label>NIP (NOMOR INDUK PEGAWAI)</label>
                    <div class="ep-input-wrap">
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="nip" value="052057527572" placeholder="NIP" readonly class="ep-readonly">
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="ep-field">
                    <label>ALAMAT EMAIL</label>
                    <div class="ep-input-wrap">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" value="SatraWiyanto@gmail.com" placeholder="Email">
                    </div>
                </div>

                {{-- SPESIALISASI --}}
                <div class="ep-field">
                    <label>SPESIALISASI</label>
                    <div class="ep-input-wrap ep-select-wrap">
                        <i class="fa-solid fa-stethoscope"></i>
                        <select name="spesialisasi">
                            <option value="umum" selected>Umum</option>
                            <option value="gigi">Gigi</option>
                            <option value="anak">Anak</option>
                            <option value="kulit">Kulit & Kelamin</option>
                        </select>
                    </div>
                </div>

                {{-- NO HP --}}
                <div class="ep-field">
                    <label>NOMOR TELEPON</label>
                    <div class="ep-input-wrap">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="telepon" value="+62 852-0575-2757" placeholder="No. Telepon">
                    </div>
                </div>

                {{-- ALAMAT PRAKTEK --}}
                <div class="ep-field">
                    <label>ALAMAT PRAKTIK</label>
                    <div class="ep-input-wrap">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="alamat" value="Gedung Teknik, Politeknik Negeri Malang" placeholder="Alamat Praktik">
                    </div>
                </div>

            </div>

            {{-- BIOGRAFI --}}
            <div class="ep-field ep-field--full">
                <label>BIOGRAFI SINGKAT</label>
                <div class="ep-textarea-wrap">
                    <i class="fa-solid fa-quote-left"></i>
                    <textarea name="bio" rows="3" placeholder="Tulis biografi singkat Anda...">Berkomitmen untuk memberikan layanan kesehatan primer yang holistik dan berkelanjutan bagi seluruh civitas akademika Polinema.</textarea>
                </div>
            </div>

            {{-- FOOTER FORM --}}
            <div class="ep-form-foot">
                <span class="ep-last-update">
                    <i class="fa-regular fa-clock"></i>
                    Terakhir diperbarui: 12 Oktober 2025
                </span>
                <div class="ep-form-actions">
                    <a href="{{ route('dokter.profil.show') }}" class="ep-btn ep-btn--cancel">Batal</a>
                    <button type="submit" class="ep-btn ep-btn--save">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </div>

        </form>

    </div>

</div>
</section>

<script>
function previewFoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('ep-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>

<style>

.ep-section   { padding: 110px 24px 60px; background: #f5f7fb; }
.ep-container { max-width: 860px; margin: 0 auto; padding: 0 16px; }

.ep-card {
    background: #fff;
    border-radius: 28px;
    padding: 36px;
    box-shadow: 0 20px 50px rgba(16,43,87,.08);
}

/* HEAD */
.ep-card__head {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 28px; gap: 16px; flex-wrap: wrap;
}
.ep-card__head h2 { margin: 0 0 6px; font-size: 24px; font-weight: 800; color: #102b57; }
.ep-card__head p  { margin: 0; font-size: 14px; color: #64748b; }
.ep-btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px; border-radius: 12px;
    background: #f1f5f9; color: #102b57;
    font-size: 13px; font-weight: 700;
    text-decoration: none;
    transition: background .2s;
    white-space: nowrap;
}
.ep-btn-back:hover { background: #e2e8f0; }

/* FOTO */
.ep-foto-row {
    display: flex; align-items: center; gap: 24px;
    background: #f8fafc; border-radius: 18px; padding: 22px;
    margin-bottom: 28px; flex-wrap: wrap;
}
.ep-foto-wrap {
    position: relative;
    width: 90px; height: 90px; flex-shrink: 0;
}
.ep-foto-wrap img {
    width: 100%; height: 100%;
    border-radius: 20px; object-fit: cover;
    border: 3px solid #f6c40b;
}
.ep-foto-overlay {
    position: absolute; inset: 0;
    background: rgba(16,43,87,.55);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 18px;
    opacity: 0; cursor: pointer;
    transition: opacity .2s;
}
.ep-foto-wrap:hover .ep-foto-overlay { opacity: 1; }
.ep-foto-info h4 { margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #102b57; }
.ep-foto-info p  { margin: 0 0 12px; font-size: 13px; color: #94a3b8; }
.ep-btn-upload {
    display: inline-flex; align-items: center; gap: 7px;
    background: #102b57; color: #fff;
    padding: 9px 16px; border-radius: 10px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; transition: opacity .2s;
}
.ep-btn-upload:hover { opacity: .88; }

/* FORM GRID */
.ep-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}
.ep-field { display: flex; flex-direction: column; gap: 8px; }
.ep-field--full { margin-bottom: 20px; }
.ep-field label {
    font-size: 11px; font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase; letter-spacing: .5px;
}
.ep-input-wrap {
    display: flex; align-items: center; gap: 10px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    transition: border-color .2s;
}
.ep-input-wrap:focus-within { border-color: #f6c40b; }
.ep-input-wrap i { color: #94a3b8; font-size: 14px; flex-shrink: 0; }
.ep-input-wrap input,
.ep-input-wrap select {
    border: none; outline: none; background: transparent;
    font-size: 14px; color: #1e293b; width: 100%;
    font-family: inherit;
}
.ep-readonly { color: #94a3b8 !important; cursor: not-allowed; }
.ep-select-wrap { position: relative; }
.ep-select-wrap select { appearance: none; cursor: pointer; }
.ep-select-wrap::after {
    content: '▾'; position: absolute; right: 14px;
    color: #94a3b8; font-size: 12px; pointer-events: none;
}

.ep-textarea-wrap {
    display: flex; align-items: flex-start; gap: 10px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    transition: border-color .2s;
}
.ep-textarea-wrap:focus-within { border-color: #f6c40b; }
.ep-textarea-wrap i { color: #94a3b8; font-size: 14px; flex-shrink: 0; margin-top: 2px; }
.ep-textarea-wrap textarea {
    border: none; outline: none; background: transparent;
    font-size: 14px; color: #1e293b; width: 100%;
    resize: vertical; min-height: 80px;
    font-family: inherit; line-height: 1.6;
}

/* FORM FOOT */
.ep-form-foot {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 20px; border-top: 1px solid #f1f5f9;
    gap: 16px; flex-wrap: wrap;
}
.ep-last-update { font-size: 12px; color: #94a3b8; display: flex; align-items: center; gap: 6px; }
.ep-form-actions { display: flex; gap: 10px; }
.ep-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; border-radius: 12px;
    font-size: 14px; font-weight: 700;
    cursor: pointer; border: none;
    text-decoration: none;
    transition: transform .2s, box-shadow .2s, opacity .2s;
}
.ep-btn:hover { transform: translateY(-1px); }
.ep-btn--cancel { background: #f1f5f9; color: #64748b; }
.ep-btn--cancel:hover { background: #e2e8f0; }
.ep-btn--save { background: #f6c40b; color: #102b57; }
.ep-btn--save:hover { box-shadow: 0 8px 20px rgba(246,196,11,.35); }

@media (max-width: 700px) {
    .ep-form-grid { grid-template-columns: 1fr; }
    .ep-card { padding: 22px; }
    .ep-form-foot { flex-direction: column; align-items: flex-start; }
}

</style>

@endsection