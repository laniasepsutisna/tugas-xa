@extends('layouts.main')

@section('title', 'Tambah Products')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Produk</h1>
    </div>

    <form action="{{ route('products.store')  }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Input Title">
                    <small class="form-text text-muted">Input untuk title dari produk yang akan ditampilkan.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Type</label>
                    <input type="text" name="type" class="form-control" placeholder="Input Type">
                    <small class="form-text text-muted">Input untuk type dari produk yang akan ditampilkan.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control" placeholder="Input Description">
                    <small class="form-text text-muted">Input untuk description dari produk yang akan ditampilkan.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Height</label>
                    <input type="number" name="height" class="form-control" placeholder="Input Height">
                    <small class="form-text text-muted">Input untuk height dari produk yang akan ditampilkan.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Width</label>
                    <input type="number" name="width" class="form-control" placeholder="Input Width">
                    <small class="form-text text-muted">Input untuk width dari produk yang akan ditampilkan.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control" placeholder="Input Price">
                    <small class="form-text text-muted">Input untuk price dari produk yang akan ditampilkan.</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label>Rating</label>
                    <input type="number" name="rating" class="form-control" placeholder="Input Rating">
                    <small class="form-text text-muted">Input untuk rating dari produk yang akan ditampilkan.</small>
                </div>
            </div>
        </div>
        <div class="form-group mt-2">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection

@push('js')
    <script></script>
@endpush
