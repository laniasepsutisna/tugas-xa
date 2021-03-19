@extends('layouts.main')

@section('title', 'Data Json')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Json</h1>
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
    </div>

    {{-- notifikasi tambah --}}
    @if ($sukses = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Holy Berhasil!</strong> {{ $sukses }}. <a href="{{ asset('data-json/products.json')  }}" target="_blank">Cek Data Json </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- notifikasi delete --}}
    @if ($sukses = Session::get('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Holy Berhasil!</strong> {{ $sukses }}. <a href="{{ asset('data-json/products.json')  }}" target="_blank">Cek Data Json </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-striped table-nowrap" id="datatable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">name</th>
            <th scope="col">url</th>
        </tr>
        </thead>
        <tbody>
        @forelse($data_json as $row)
            <tr>
                <th scope="row">{{ $loop->iteration  }}</th>
                <td>{{$row['name']}}</td>
                <td><a href="{{asset($row['url'])}}">{{ $row['url'] }}</a></td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Tidak Ada Data</td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

@push('js')
    <script></script>
@endpush
