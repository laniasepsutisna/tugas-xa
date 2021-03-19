@extends('layouts.main')

@section('title', 'Tambah Orders')

@section('content')

    <form action="{{ route('orders.store')  }}" method="POST">
        @csrf

        <div class="card" style="margin-top: 20px;">
            <div class="card-header">
                <h4 class="card-title">Oder Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Customer</label>
                            <select name="customer_id" class="form-control">
                                <option disabled selected>Pilih Customer</option>
                                @foreach($customers as $row)
                                    <option value="{{ $row['id']  }}">{{ $row['name'] }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Input untuk customer dari order yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="Input Amount">
                            <small class="form-text text-muted">Input untuk type dari amount yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Ahipping Address</label>
                            <input type="text" name="shipping_address" class="form-control" placeholder="Input Shipping Address">
                            <small class="form-text text-muted">Input untuk shipping address dari order yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Order Address</label>
                            <input type="text" name="order_address" class="form-control" placeholder="Order Address">
                            <small class="form-text text-muted">Input untuk height dari order address yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Order Email</label>
                            <input type="email" name="order_email" class="form-control" placeholder="Input Order Email">
                            <small class="form-text text-muted">Input untuk order_email dari order yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Erder Date</label>
                            <input type="date" name="order_date" class="form-control" placeholder="Input Date" value="{{ date('Y-m-d')  }}">
                            <small class="form-text text-muted">Input untuk order date dari order yang akan ditampilkan.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 20px; margin-bottom: 20px">
            <div class="card-header">
                <h4 class="card-title">Order Detail</h4>
            </div>
            <div class="card-body">
                <div class="row">

                    <table class="table table-bordered">
                        <thead>

                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Item Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Remove</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                    <button class="btn btn-md btn-primary" id="addBtn" type="button">Add New Product</button>
                </div>

                <div class="form-group mt-4" style="margin-buttom: 20px;">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('js')
    <script>
        $(document).ready(function () {

            // Denotes total number of rows
            var rowIdx = 0;

            // jQuery button click event to add a row
            $('#addBtn').on('click', function () {

                // Adding a row inside the tbody.
                $('#tbody').append(`
                    <tr id="R${++rowIdx}">
                        <td class="text-center">${rowIdx}</td>
                        <td class="row-index text-center"><select name="product_id[]" class="form-control"> <option disabled selected>Pilih Product</option> @foreach($products as $row) <option value="{{ $row['id'] }}">{{ $row['title'] }}</option> @endforeach </select></td>
                        <td class="row-index text-center"><input type="text" name="price[]" class="form-control" placeholder="Input Price"></td>
                        <td class="row-index text-center"><input type="text" name="quantity[]" class="form-control" placeholder="Input Quantity"></td>
                        <td class="text-center"><button class="btn btn-danger btn-sm remove" type="button">Remove</button></td>
                    </tr>`);
            });

            // jQuery button click event to remove a row.
            $('#tbody').on('click', '.remove', function () {

                // Getting all the rows next to the row
                // containing the clicked button
                var child = $(this).closest('tr').nextAll();

                // Iterating across all the rows
                // obtained to change the index
                child.each(function () {

                    // Getting <tr> id.
                    var id = $(this).attr('id');

                    // Getting the <p> inside the .row-index class.
                    var idx = $(this).children('.row-index').children('p');

                    // Gets the row number from <tr> id.
                    var dig = parseInt(id.substring(1));

                    // Modifying row index.
                    idx.html(`Row ${dig - 1}`);

                    // Modifying row id.
                    $(this).attr('id', `R${dig - 1}`);
                });

                // Removing the current row.
                $(this).closest('tr').remove();

                // Decreasing total number of rows by 1.
                rowIdx--;
            });
        });
    </script>
@endpush
