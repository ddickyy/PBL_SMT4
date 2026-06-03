@extends('layout.app')

@php
 $dokterLayout = true;
@endphp

@section('content')

<!-- Cropper.js CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<section class="ep-section">
<div class="ep-container">

 {{-- CARD FORM --}}
 <div class="ep-card" data-aos="fade-up">

 {{-- CARD HEAD --}}
 <div class="ep-card__head">
 <div>
 <h2>Edit Profil Anda</h2>
 <p>Perbarui data diri untuk kelancaran layanan kesehatan.</p>
 </div>
 <a href="{{ route('dokter.profil') }}" class="ep-btn-back">
 <i class="fa-solid fa-arrow-left"></i> Kembali
 </a>
 </div>

 @if(session('success'))
 <div style="background: #dcfce7; color: #15803d; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
 <i class="fa-solid fa-circle-check"></i>
 <span>{{ session('success') }}</span>
 </div>
 @endif

 @if($errors->any())
 <div style="background: #fee2e2; color: #dc2626; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 700;">
 <ul style="margin: 0; padding-left: 18px;">
 @foreach($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
 @endif

 @php
 $fotoUrl = $dokter->user->foto
 ? asset('storage/' . $dokter->user->foto)
 : 'https://ui-avatars.com/api/?name=' . urlencode($dokter->user->nama) . '&background=102b57&color=fff&size=120';
 @endphp

 {{-- FORM --}}
 <form action="{{ route('dokter.profil.update') }}" method="POST" enctype="multipart/form-data">
 @csrf
 @method('PUT')

 {{-- FOTO UPLOAD --}}
 <div class="ep-foto-row">
 <div class="ep-foto-wrap">
 <img id="ep-preview" src="{{ $fotoUrl }}" alt="Foto Profil">
 <label for="ep-foto-input" class="ep-foto-overlay" title="Ganti foto">
 <i class="fa-solid fa-camera"></i>
 </label>
 <input type="file" id="ep-foto-input" name="foto" accept="image/*" style="display:none" onchange="previewFoto(event)">
 
 {{-- 4x4 Guide Overlay --}}
 <div class="crop-guide-4x4">
 <span class="guide-label">4x4</span>
 </div>
 </div>
 <div class="ep-foto-info">
 <h4>Foto Profil</h4>
 <p>Format JPG, PNG atau GIF. Ukuran maks 2MB.</p>
 <label for="ep-foto-input" class="ep-btn-upload">
 <i class="fa-solid fa-upload"></i> Upload Foto
 </label>
 </div>
 </div>

 <div class="ep-form-grid">

 {{-- NAMA LENGKAP --}}
 <div class="ep-field">
 <label>NAMA LENGKAP</label>
 <div class="ep-input-wrap">
 <i class="fa-solid fa-user"></i>
 <input type="text" name="nama" value="{{ old('nama', $dokter->user->nama) }}" placeholder="Nama lengkap" required>
 </div>
 </div>

 {{-- SIP --}}
 <div class="ep-field">
 <label>SIP DOKTER</label>
 <div class="ep-input-wrap ep-readonly">
 <i class="fa-solid fa-id-card"></i>
 <input type="text" value="{{ $dokter->sip_dokter }}" readonly class="ep-readonly">
 </div>
 </div>

 {{-- EMAIL --}}
 <div class="ep-field">
 <label>ALAMAT EMAIL</label>
 <div class="ep-input-wrap">
 <i class="fa-regular fa-envelope"></i>
 <input type="email" name="email" value="{{ old('email', $dokter->user->email) }}" placeholder="Email" required>
 </div>
 </div>

 {{-- SPESIALISASI --}}
 <div class="ep-field">
 <label>SPESIALISASI</label>
 <div class="ep-input-wrap ep-select-wrap ep-readonly">
 <i class="fa-solid fa-stethoscope"></i>
 <select name="spesialisasi" disabled class="ep-readonly">
 <option value="1" @if($dokter->id_spesialisasi == 1) selected @endif>Umum</option>
 <option value="2" @if($dokter->id_spesialisasi == 2) selected @endif>Gigi</option>
 </select>
 </div>
 </div>

 {{-- NO HP --}}
 <div class="ep-field">
 <label>NOMOR TELEPON</label>
 <div class="ep-input-wrap">
 <i class="fa-solid fa-phone"></i>
 <input type="text" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}" placeholder="No. Telepon">
 </div>
 </div>

 {{-- TEMPAT PRAKTEK --}}
 <div class="ep-field">
 <label>TEMPAT PRAKTIK</label>
 <div class="ep-input-wrap ep-readonly">
 <i class="fa-solid fa-location-dot"></i>
 <input type="text" value="Poliklinik Politeknik Negeri Malang" readonly class="ep-readonly">
 </div>
 </div>

 </div>

 {{-- FOOTER FORM --}}
 <div class="ep-form-foot">
 <span class="ep-last-update">
 <i class="fa-regular fa-clock"></i>
 Terakhir diperbarui: {{ $dokter->updated_at->translatedFormat('d F Y') }}
 </span>
 <div class="ep-form-actions">
 <a href="{{ route('dokter.profil') }}" class="ep-btn ep-btn--cancel">Batal</a>
 <button type="submit" class="ep-btn ep-btn--save">
 <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
 </button>
 </div>
 </div>

 </form>

 </div>

 <!-- Crop Photo Modal -->
 <div id="cropModal" class="crop-modal" style="display: none;">
 <div class="crop-modal-content">
 <div class="crop-modal-header">
 <h3>Sesuaikan Foto Profil</h3>
 <p>Geser dan perbesar foto agar pas di dalam bingkai 4x4 (kotak).</p>
 </div>
 <div class="crop-modal-body">
 <div class="cropper-wrapper">
 <img id="imageToCrop" src="" alt="Image to crop">
 </div>
 </div>
 <div class="crop-modal-controls">
 <button type="button" class="btn-crop-control" id="btnZoomIn" title="Perbesar">
 <i class="fa-solid fa-magnifying-glass-plus"></i>
 </button>
 <button type="button" class="btn-crop-control" id="btnZoomOut" title="Perkecil">
 <i class="fa-solid fa-magnifying-glass-minus"></i>
 </button>
 <button type="button" class="btn-crop-control" id="btnRotateLeft" title="Putar Kiri">
 <i class="fa-solid fa-rotate-left"></i>
 </button>
 <button type="button" class="btn-crop-control" id="btnRotateRight" title="Putar Kanan">
 <i class="fa-solid fa-rotate-right"></i>
 </button>
 </div>
 <div class="crop-modal-footer">
 <button type="button" class="btn-crop-cancel" id="btnCancelCrop">Batal</button>
 <button type="button" class="btn-crop-apply" id="btnApplyCrop">Potong & Terapkan</button>
 </div>
 </div>
 </div>

</div>
</section>

<script>
let cropper = null;
let selectedFile = null;

function previewFoto(event) {
 const files = event.target.files;
 if (files && files.length> 0) {
 selectedFile = files[0];
 const reader = new FileReader();
 reader.onload = function(e) {
 const cropModal = document.getElementById('cropModal');
 const imageToCrop = document.getElementById('imageToCrop');
 
 imageToCrop.src = e.target.result;
 cropModal.style.display = 'flex';
 // Force reflow for transitions
 cropModal.offsetHeight;
 cropModal.classList.add('show');
 
 if (cropper) {
 cropper.destroy();
 }
 
 cropper = new Cropper(imageToCrop, {
 aspectRatio: 1,
 viewMode: 1,
 dragMode: 'move',
 autoCropArea: 1,
 background: false,
 responsive: true,
 checkOrientation: false
 });
 };
 reader.readAsDataURL(selectedFile);
 }
}

document.addEventListener('DOMContentLoaded', function() {
 const btnCancelCrop = document.getElementById('btnCancelCrop');
 const btnApplyCrop = document.getElementById('btnApplyCrop');
 const btnZoomIn = document.getElementById('btnZoomIn');
 const btnZoomOut = document.getElementById('btnZoomOut');
 const btnRotateLeft = document.getElementById('btnRotateLeft');
 const btnRotateRight = document.getElementById('btnRotateRight');
 const cropModal = document.getElementById('cropModal');
 const fotoInput = document.getElementById('ep-foto-input');
 
 function closeCropModal() {
 cropModal.classList.remove('show');
 setTimeout(() => {
 cropModal.style.display = 'none';
 if (cropper) {
 cropper.destroy();
 cropper = null;
 }
 }, 300);
 }
 
 if (btnCancelCrop) {
 btnCancelCrop.addEventListener('click', function() {
 fotoInput.value = ''; // Reset input
 closeCropModal();
 });
 }
 
 if (btnZoomIn) {
 btnZoomIn.addEventListener('click', function() {
 if (cropper) cropper.zoom(0.1);
 });
 }
 
 if (btnZoomOut) {
 btnZoomOut.addEventListener('click', function() {
 if (cropper) cropper.zoom(-0.1);
 });
 }
 
 if (btnRotateLeft) {
 btnRotateLeft.addEventListener('click', function() {
 if (cropper) cropper.rotate(-90);
 });
 }
 
 if (btnRotateRight) {
 btnRotateRight.addEventListener('click', function() {
 if (cropper) cropper.rotate(90);
 });
 }
 
 if (btnApplyCrop) {
 btnApplyCrop.addEventListener('click', function() {
 if (!cropper) return;
 
 const canvas = cropper.getCroppedCanvas({
 width: 400,
 height: 400,
 imageSmoothingEnabled: true,
 imageSmoothingQuality: 'high'
 });
 
 canvas.toBlob(function(blob) {
 if (!blob) return;
 
 // Create a new File from the blob
 const croppedFile = new File([blob], selectedFile.name, {
 type: selectedFile.type || 'image/jpeg',
 lastModified: Date.now()
 });
 
 // Update file input files list using DataTransfer
 const dataTransfer = new DataTransfer();
 dataTransfer.items.add(croppedFile);
 fotoInput.files = dataTransfer.files;
 
 // Update preview image
 const previewImg = document.getElementById('ep-preview');
 
 previewImg.src = canvas.toDataURL(selectedFile.type || 'image/jpeg');
 
 closeCropModal();
 }, selectedFile.type || 'image/jpeg', 0.9);
 });
 }
});
</script>

<style>

.ep-section { padding: 110px 24px 60px; background: #f5f7fb; }
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
.ep-card__head p { margin: 0; font-size: 14px; color: #64748b; }
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
 width: 120px; height: 120px; flex-shrink: 0;
}
.ep-foto-wrap img {
 width: 100%; height: 100%;
 border-radius: 16px; object-fit: cover;
 border: 3px solid #f6c40b;
}
.ep-foto-overlay {
 position: absolute; inset: 0;
 background: rgba(16,43,87,.55);
 border-radius: 16px;
 display: flex; align-items: center; justify-content: center;
 color: #fff; font-size: 18px;
 opacity: 0; cursor: pointer;
 transition: opacity .2s;
 z-index: 5;
}
.ep-foto-wrap:hover .ep-foto-overlay { opacity: 1; }
.ep-foto-info h4 { margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #102b57; }

.crop-guide-4x4 {
 position: absolute;
 inset: 0;
 border: 2px dashed rgba(255, 255, 255, 0.4);
 margin: 8px;
 border-radius: 10px;
 display: flex;
 align-items: flex-end;
 justify-content: center;
 pointer-events: none;
 box-sizing: border-box;
 z-index: 2;
}

.guide-label {
 font-size: 9px;
 font-weight: 800;
 color: rgba(255, 255, 255, 0.85);
 background: rgba(16, 43, 87, 0.65);
 padding: 2px 6px;
 border-radius: 4px;
 margin-bottom: 4px;
 letter-spacing: 0.5px;
 text-transform: uppercase;
}
.ep-foto-info p { margin: 0 0 12px; font-size: 13px; color: #94a3b8; }
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

/* Crop Modal styling */
.crop-modal {
 position: fixed;
 inset: 0;
 z-index: 9999;
 display: flex;
 align-items: center;
 justify-content: center;
 background: rgba(16, 43, 87, 0.45);
 backdrop-filter: blur(8px);
 -webkit-backdrop-filter: blur(8px);
 opacity: 0;
 transition: opacity 0.3s ease;
 padding: 20px;
}

.crop-modal.show {
 opacity: 1;
}

.crop-modal-content {
 background: #ffffff;
 border-radius: 24px;
 width: 100%;
 max-width: 480px;
 box-shadow: 0 25px 50px -12px rgba(16, 43, 87, 0.25);
 overflow: hidden;
 transform: scale(0.9);
 transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
 display: flex;
 flex-direction: column;
}

.crop-modal.show .crop-modal-content {
 transform: scale(1);
}

.crop-modal-header {
 padding: 20px 24px;
 border-bottom: 1px solid #f1f5f9;
}

.crop-modal-header h3 {
 margin: 0 0 6px;
 font-size: 18px;
 font-weight: 800;
 color: #102b57;
}

.crop-modal-header p {
 margin: 0;
 font-size: 13px;
 color: #64748b;
 line-height: 1.4;
}

.crop-modal-body {
 padding: 24px;
 background: #f8fafc;
 display: flex;
 justify-content: center;
 align-items: center;
}

.cropper-wrapper {
 width: 100%;
 max-height: 300px;
 background: #f1f5f9;
 border-radius: 12px;
 overflow: hidden;
 display: flex;
 justify-content: center;
 align-items: center;
}

.cropper-wrapper img {
 max-width: 100%;
 max-height: 300px;
 display: block;
}

.crop-modal-controls {
 display: flex;
 justify-content: center;
 gap: 12px;
 padding: 12px 24px;
 background: #f8fafc;
 border-top: 1px dashed #e2e8f0;
}

.btn-crop-control {
 border: 1.5px solid #e2e8f0;
 background: #ffffff;
 color: #102b57;
 width: 40px;
 height: 40px;
 border-radius: 10px;
 display: flex;
 align-items: center;
 justify-content: center;
 cursor: pointer;
 transition: all 0.2s;
 font-size: 14px;
}

.btn-crop-control:hover {
 border-color: #102b57;
 background: #f8fafc;
}

.crop-modal-footer {
 display: flex;
 justify-content: flex-end;
 gap: 12px;
 padding: 20px 24px;
 border-top: 1px solid #f1f5f9;
 background: #ffffff;
}

.btn-crop-cancel {
 border: none;
 background: #f1f5f9;
 color: #64748b;
 padding: 12px 20px;
 border-radius: 12px;
 font-size: 14px;
 font-weight: 700;
 cursor: pointer;
 transition: background 0.2s;
}

.btn-crop-cancel:hover {
 background: #e2e8f0;
}

.btn-crop-apply {
 border: none;
 background: #102b57;
 color: #ffffff;
 padding: 12px 20px;
 border-radius: 12px;
 font-size: 14px;
 font-weight: 700;
 cursor: pointer;
 transition: background 0.2s, transform 0.2s;
}

.btn-crop-apply:hover {
 background: #1d4ed8;
}

</style>

@endsection