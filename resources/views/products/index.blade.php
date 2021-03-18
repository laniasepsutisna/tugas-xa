@extends('layouts.main')

@section('title', 'Products')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Products</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('products.create')  }}" class="btn btn-sm btn-outline-secondary">Tambah Produk</a>
            </div>
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
            <th scope="col">title</th>
            <th scope="col">type</th>
            <th scope="col">description</th>
            <th scope="col">height</th>
            <th scope="col">width</th>
            <th scope="col">price</th>
            <th scope="col">rating</th>
            <th scope="col">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $row)
            <tr>
                <th scope="row">{{ $loop->iteration  }}</th>
                <td><a href="{{ route('products.edit', $row['id'])  }}">{{ $row['title']  }}</a></td>
                <td>{{ $row['type']  }}</td>
                <td>{{ $row['description']  }}</td>
                <td>{{ $row['height']  }}</td>
                <td>{{ $row['width']  }}</td>
                <td>{{ $row['price']  }}</td>
                <td>{{ $row['rating']  }}</td>
                <td>
                    <form action="{{ route('products.destroy', $row['id']) }}" method="post">
                        <input class="btn btn-danger btn-sm" type="submit" value="Delete" />
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak Ada Data</td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

@push('js')
    <script></script>
@endpush
