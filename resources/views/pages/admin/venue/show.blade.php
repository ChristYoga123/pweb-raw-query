@extends('layouts.admin.app')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Edit Data Venue</h2>
</div>
<div class="grid grid-cols-12 lg:grid-cols-none gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <form action="#">
                <div>
                    <label>Nama Venue</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Masukkan nama venue" name="name" value="{{ $venue->name }}" readonly>
                </div>
                <div class="mt-5">
                    <label>Lokasi Venue</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Masukkan lokasi venue" name="location" value="{{ $venue->location }}" readonly>
                </div>
                <div class="mt-5">
                    <label>Harga Venue Per Malam</label>
                    <input type="number" class="input w-full border mt-2" placeholder="Masukkan harga venue" name="price_per_night" value="{{ $venue->price_per_night }}" readonly>
                </div>
                <div class="mt-5">
                    <label>Gambar Utama Venue</label>
                    <img src="/storage/{{ $venue->hero_image }}" alt="" width="300px" class="image-preview" >
                </div>
                <div class="mt-5">
                    <label>Deskripsi Venue</label>
                    <textarea data-feature="basic" class="summernote mt-2" name="description" readonly>{{ $venue->description }}</textarea>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
@endsection