@extends('layouts.admin.app')

@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Tambah Data Kategori</h2>
</div>
<div class="grid grid-cols-12 lg:grid-cols-none gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <form action="{{ route("admin.kategori_venue.store") }}" method="POST">
                @csrf
                <div>
                    <label>Nama Kategori</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Masukkan nama kategori venue" name="name">
                </div>
                <div class="text-right mt-5">
                    <button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Form Layout -->
    </div>
</div>
@push('script')
    @if(session("error"))
    <script>
        // error alert
        Swal.fire(
            "Gagal",
            `{{ session("error") }}`,
            "error"
        );
    </script>
    @elseif($errors->any())
    <script>
        // erro alert
        Swal.fire(
            "Gagal",
            `@foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach`,
            "error"
        );
    </script>
    @endif
@endpush
@endsection