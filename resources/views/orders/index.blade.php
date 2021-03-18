@extends('layouts.main')

@section('title', 'Orders')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('orders.create')  }}" class="btn btn-sm btn-outline-secondary">Tambah Order</a>
            </div>
        </div>
    </div>

    {{-- notifikasi tambah --}}
    @if ($sukses = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Holy Berhasil!</strong> {{ $sukses }}. <a href="{{ asset('data-json/orders.json')  }}" target="_blank">Cek Data Json </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- notifikasi delete --}}
    @if ($sukses = Session::get('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Holy Berhasil!</strong> {{ $sukses }}. <a href="{{ asset('data-json/orders.json')  }}" target="_blank">Cek Data Json </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-striped table-nowrap" id="datatable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">customer</th>
            <th scope="col">amount</th>
            <th scope="col">shipping address</th>
            <th scope="col">order address</th>
            <th scope="col">order email</th>
            <th scope="col">order date</th>
            <th scope="col">order status</th>
            <th scope="col">aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $row)
            <tr>
                <th scope="row">{{ $loop->iteration  }}</th>
                <td><a href="{{ route('orders.edit', $row['id'])  }}">{{ $row['customer_id']  }}</a></td>
                <td>{{ $row['amount']  }}</td>
                <td>{{ $row['shipping_address']  }}</td>
                <td>{{ $row['order_address']  }}</td>
                <td>{{ $row['order_email']  }}</td>
                <td>{{ $row['order_date']  }}</td>
                <td>{{ $row['order_status']  }}</td>
                <td>
                    <form action="{{ route('orders.destroy', $row['id']) }}" method="post">
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
