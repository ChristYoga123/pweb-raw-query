@extends('layouts.admin.app')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Data Galeri Venue
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a href="{{ route("admin.galeri_venue.create") }}" class="button text-white bg-theme-1 shadow-md mr-2">+ Tambah Data Venue</a>
    </div>
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">NAMA VENUE</th>
                <th class="border-b-2 text-center whitespace-no-wrap">GAMBAR</th>
                <th class="border-b-2 text-center whitespace-no-wrap">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($galleries as $gallery)
                <tr>
                    <td class="border-b">
                        <div class="font-medium whitespace-no-wrap">{{ $gallery->venue_name }}</div>
                    </td>
                    <td class="text-center border-b">
                        <div class="flex sm:justify-center">
                            <div class="intro-x w-10 h-10 image-fit"></div>
                            <div class="intro-x w-10 h-10 image-fit -ml-5">
                                <img alt="" class="rounded-full" src="/storage/{{ $gallery->gallery }}">
                            </div>
                            <div class="intro-x w-10 h-10 image-fit -ml-5"></div>
                        </div>
                    </td>
                    <td class="border-b w-5">
                        <div class="flex sm:justify-center items-center">
                            <form action="{{ route("admin.galeri_venue.destroy", $gallery->id) }}" method="POST" class="flex items-center mr-3 text-red-500">
                                @csrf
                                @method('DELETE')
                                <button class="flex">
                                    <i data-feather="trash" class="w-4 h-4 mr-1"></i>
                                    <p>Hapus</p>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>          
            @endforeach
        </tbody>
    </table>
</div>
<!-- END: Datatable -->

@push('script')
    {{-- Alert Script --}}
    @if (session("success"))
        <script>
            // success alert
            Swal.fire(
                "Sukses",
                `{{ session("success") }}`,
                "success"
            );
        </script>
    @elseif(session("error"))
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
    
    {{-- Additional Script --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
@endpush
@endsection