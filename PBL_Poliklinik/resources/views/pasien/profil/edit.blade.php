@extends('layout.app')

@section('title', 'Edit Profil')

@section('content')

<!-- Cropper.js CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

@php
 $user = auth()->user();
@endphp

<section class="profile-edit-page">

 <div class="page-container">

 <div class="hero-section">

 <div class="profile-card" data-aos="fade-up">

 <div class="page-header">

 <h1>Edit Profil Anda</h1>

 <p>
 Perbarui informasi pribadi Anda untuk
 kelancaran layanan kesehatan.
 </p>

 </div>

 @if ($errors->any())

 <div class="alert-error">

 <ul>

 @foreach ($errors->all() as $error)

 <li>{{ $error }}</li>

 @endforeach

 </ul>

 </div>

 @endif

 @if(session('success'))

 <div class="alert-success">

 {{ session('success') }}

 </div>

 @endif

 <form
 action="{{ route('pasien.profil.update') }}"
 method="POST"
 enctype="multipart/form-data"
>

 @csrf
 @method('PUT')

 <div class="form-grid">

 {{-- FOTO --}}
 <div class="form-group full-width">

 <label>FOTO PROFIL</label>

 <div class="photo-upload">

 <div class="photo-preview">

 @if($user->foto)

 <img
 id="previewFoto"
 src="{{ asset('storage/' . $user->foto) }}"
 alt="Foto Profil"
>

 @else

 <div id="initialsPreview" class="profile-initials">
 {{ strtoupper(substr($user->nama, 0, 1)) }}
 </div>
 <img
 id="previewFoto"
 src=""
 alt="Foto Profil"
 style="display: none;"
>

 @endif

 {{-- 4x4 Guide Overlay --}}
 <div class="crop-guide-4x4">
 <span class="guide-label">4x4</span>
 </div>

 </div>

 <div class="photo-actions">

 <input
 type="file"
 name="foto"
 id="fotoInput"
 accept="image/*"
 onchange="previewImage(event)"
>

 <small>
 JPG, PNG, JPEG maksimal 2MB
 </small>

 </div>

 </div>

 @error('foto')

 <small class="error-text">

 {{ $message }}

 </small>

 @enderror

 </div>

 {{-- NAMA --}}
 <div class="form-group">

 <label>Nama Lengkap</label>

 <div class="input-icon">

 <i class="fa-regular fa-user"></i>

 <input
 type="text"
 name="nama"
 value="{{ old('nama', $user->nama) }}"
 placeholder="Nama lengkap"
>

 </div>

 @error('nama')

 <small class="error-text">

 {{ $message }}

 </small>

 @enderror

 </div>

 {{-- EMAIL --}}
 <div class="form-group">

 <label>Email</label>

 <div class="input-icon">

 <i class="fa-regular fa-envelope"></i>

 <input
 type="email"
 name="email"
 value="{{ old('email', $user->email) }}"
 placeholder="Email aktif"
>

 </div>

 @error('email')

 <small class="error-text">

 {{ $message }}

 </small>

 @enderror

 </div>

 {{-- MAHASISWA --}}
 @if($user->mahasiswa)

 <div class="form-group">

 <label>NIM</label>

 <div class="input-icon">

 <i class="fa-regular fa-id-badge"></i>

 <input
 type="text"
 value="{{ $user->mahasiswa->nim }}"
 readonly
 class="readonly-input"
>

 </div>

 </div>

 <div class="form-group">

 <label>Program Studi</label>

 <div class="input-icon">

 <i class="fa-solid fa-graduation-cap"></i>

 <input
 type="text"
 value="{{ optional($user->mahasiswa->prodi)->nama_prodi ?? '-' }}"
 readonly
 class="readonly-input"
>

 </div>

 </div>

 <div class="form-group full-width">

 <label>Nomor Telepon</label>

 <div class="input-icon">

 <i class="fa-solid fa-phone"></i>

 <input
 type="text"
 name="no_hp"
 value="{{ old('no_hp', $user->mahasiswa->no_hp ?? '') }}"
 placeholder="Nomor telepon aktif"
>

 </div>

 @error('no_hp')

 <small class="error-text">

 {{ $message }}

 </small>

 @enderror

 </div>

 @endif

 {{-- DOSEN --}}
 @if($user->dosen)

 <div class="form-group">

 <label>NIDN / NIP</label>

 <div class="input-icon">

 <i class="fa-regular fa-id-badge"></i>

 <input
 type="text"
 value="{{ $user->dosen->nip }}"
 readonly
 class="readonly-input"
>

 </div>

 </div>

 <div class="form-group">

 <label>Nomor Telepon</label>

 <div class="input-icon">

 <i class="fa-solid fa-phone"></i>

 <input
 type="text"
 name="no_hp"
 value="{{ old('no_hp', $user->dosen->no_hp ?? '') }}"
 placeholder="Nomor telepon aktif"
>

 </div>

 </div>

 @endif

 {{-- TENDIK --}}
 @if($user->tendik)

 <div class="form-group">

 <label>NIP</label>

 <div class="input-icon">

 <i class="fa-regular fa-id-badge"></i>

 <input
 type="text"
 value="{{ $user->tendik->nip }}"
 readonly
 class="readonly-input"
>

 </div>

 </div>

 <div class="form-group">

 <label>Jabatan</label>

 <div class="input-icon">

 <i class="fa-solid fa-briefcase"></i>

 <input
 type="text"
 value="{{ optional($user->tendik->jabatan)->nama_jabatan ?? '-' }}"
 readonly
 class="readonly-input"
>

 </div>

 </div>

 <div class="form-group full-width">

 <label>Nomor Telepon</label>

 <div class="input-icon">

 <i class="fa-solid fa-phone"></i>

 <input
 type="text"
 name="no_hp"
 value="{{ old('no_hp', $user->tendik->no_hp ?? '') }}"
 placeholder="Nomor telepon aktif"
>

 </div>

 </div>

 @endif

 {{-- PASSWORD --}}
 <div class="form-group full-width password-section">

 <div class="password-header">

 <h3>Ubah Password</h3>

 <p>
 Kosongkan jika tidak ingin mengubah password.
 </p>

 </div>

 </div>

 <div class="form-group">

 <label>Password Baru</label>

 <div class="input-icon">

 <i class="fa-solid fa-lock"></i>

 <input
 type="password"
 name="password"
 placeholder="Masukkan password baru"
>

 </div>

 @error('password')

 <small class="error-text">

 {{ $message }}

 </small>

 @enderror

 </div>

 <div class="form-group">

 <label>Konfirmasi Password</label>

 <div class="input-icon">

 <i class="fa-solid fa-lock"></i>

 <input
 type="password"
 name="password_confirmation"
 placeholder="Konfirmasi password baru"
>

 </div>

 </div>

 </div>

 <div class="save-row">

 <button
 type="submit"
 class="btn-save"
>

 <i class="fa-solid fa-floppy-disk"></i>

 Simpan Perubahan

 </button>

 </div>

 </form>

 </div>

 </div>

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

</section>

<script>
let cropper = null;
let selectedFile = null;

function previewImage(event)
{
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
 const fotoInput = document.getElementById('fotoInput');
 
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
 const previewImg = document.getElementById('previewFoto');
 const initialsDiv = document.getElementById('initialsPreview');
 
 previewImg.src = canvas.toDataURL(selectedFile.type || 'image/jpeg');
 previewImg.style.display = 'block';
 if (initialsDiv) {
 initialsDiv.style.display = 'none';
 }
 
 closeCropModal();
 }, selectedFile.type || 'image/jpeg', 0.9);
 });
 }
});
</script>

<style>

.profile-edit-page{
 padding:28px 24px 64px;
 background:#f5f7fb;
 min-height:100vh;
}

.page-container{
 max-width:1200px;
 margin:0 auto;
 padding:0 32px;
}

.hero-section{
 padding-top:100px;
}

.profile-card{
 background:#fff;
 border-radius:28px;
 padding:34px;
 box-shadow:0 20px 40px rgba(15,23,42,.06);
}

.page-header{
 margin-bottom:28px;
}

.page-header h1{
 margin:0 0 8px;
 font-size:36px;
 line-height:1.1;
 color:#102b57;
 font-weight:900;
}

.page-header p{
 margin:0;
 color:#64748b;
 font-size:15px;
}

.alert-success{
 background:#dcfce7;
 color:#166534;
 padding:14px 18px;
 border-radius:14px;
 margin-bottom:20px;
 font-size:14px;
 font-weight:600;
}

.alert-error{
 background:#fee2e2;
 color:#991b1b;
 padding:14px 18px;
 border-radius:14px;
 margin-bottom:20px;
 font-size:14px;
}

.alert-error ul{
 margin:0;
 padding-left:18px;
}

.form-grid{
 display:grid;
 grid-template-columns:1fr 1fr;
 gap:22px 24px;
}

.full-width{
 grid-column:1 / -1;
}

.form-group{
 display:flex;
 flex-direction:column;
}

.form-group label{
 margin-bottom:10px;
 font-size:12px;
 font-weight:800;
 color:#102b57;
 letter-spacing:.06em;
 text-transform:uppercase;
}

.input-icon{
 position:relative;
 display:flex;
 align-items:center;
}

.input-icon i{
 position:absolute;
 left:16px;
 color:#4b5563;
 font-size:16px;
 pointer-events:none;
}

.input-icon input{
 width:100%;
 border:none;
 outline:none;
 background:#f4f4f6;
 border-radius:14px;
 padding:16px 18px 16px 48px;
 font-size:15px;
 color:#2d3137;
 transition:.25s ease;
}

.input-icon input:focus{
 background:#eef4ff;
 box-shadow:0 0 0 3px rgba(29,78,216,.12);
}

.readonly-input{
 background:#eceff3 !important;
 color:#64748b !important;
 cursor:not-allowed;
}

.error-text{
 margin-top:8px;
 color:#dc2626;
 font-size:13px;
 font-weight:600;
}

.photo-upload{
 display:flex;
 align-items:center;
 gap:18px;
 flex-wrap:wrap;
}

.photo-preview{
 width: 120px;
 height: 120px;
 border-radius: 16px;
 overflow: hidden;
 flex-shrink: 0;
 background: #102b57;
 display: flex;
 align-items: center;
 justify-content: center;
 box-shadow: 0 6px 15px rgba(16, 43, 87, 0.12);
 position: relative;
 border: 2px solid #eef2f6;
}

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

.photo-preview img{
 width:100%;
 height:100%;
 object-fit:cover;
}

.profile-initials {
 display: flex;
 align-items: center;
 justify-content: center;
 background: #102b57;
 color: white;
 font-weight: 800;
 text-transform: uppercase;
 text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
 width: 100%;
 height: 100%;
 font-size: 38px;
}

.photo-actions{
 display:flex;
 flex-direction:column;
 gap:8px;
}

.photo-actions small{
 color:#64748b;
 font-size:12px;
}

.save-row{
 display:flex;
 justify-content:flex-end;
 margin-top:30px;
 padding-top:24px;
 border-top:1px solid #e5e7eb;
}

.btn-save{
 border:none;
 background:#facc15;
 color:#102b57;
 padding:16px 28px;
 border-radius:16px;
 font-size:15px;
 font-weight:800;
 cursor:pointer;
 box-shadow:0 10px 24px rgba(250,204,21,.18);
 transition:.25s ease;
 display:inline-flex;
 align-items:center;
 gap:10px;
}

.btn-save:hover{
 background:#eab308;
 transform:translateY(-2px);
}

.password-section{
 margin-top:10px;
}

.password-header{
 padding-top:10px;
 border-top:1px solid #e5e7eb;
}

.password-header h3{
 margin:0 0 6px;
 font-size:22px;
 font-weight:800;
 color:#102b57;
}

.password-header p{
 margin:0;
 color:#64748b;
 font-size:14px;
}

@media (max-width:1024px){

 .form-grid{
 grid-template-columns:1fr;
 }

}

@media (max-width:768px){

 .profile-edit-page{
 padding:18px 14px 50px;
 }

 .page-container{
 padding:0;
 }

 .profile-card{
 padding:22px;
 }

 .page-header h1{
 font-size:28px;
 }

 .save-row{
 justify-content:stretch;
 }

 .btn-save{
 width:100%;
 justify-content:center;
 }

 .photo-upload{
 flex-direction:column;
 align-items:flex-start;
 }

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