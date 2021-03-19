@extends('layouts.main')

@section('title', 'Tambah Orders')

@section('content')

    <form action="{{ route('orders.update', $order['id'])  }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card" style="margin-top: 20px;">
            <div class="card-header">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h3 class="h3">Order Information</h3>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="{{ route('orders.invoice', $order['id']) }}" class="btn btn-sm btn-outline-secondary" target="_blank">Print Invoice</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Customer</label>
                            <select name="customer_id" class="form-control" readonly>
                                <option disabled selected>Pilih Customer</option>
                                @foreach($customers as $row)
                                    <option value="{{ $row['id']  }}" {{ $row['id'] == $order['customer_id'] ? 'selected' : '' }}>{{ $row['name'] }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Input untuk customer dari order yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="Input Amount" value="{{ $order['amount'] }}" readonly>
                            <small class="form-text text-muted">Input untuk type dari amount yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Ahipping Address</label>
                            <input type="text" name="shipping_address" class="form-control" value="{{ $order['shipping_address'] }}" placeholder="Input Shipping Address" readonly>
                            <small class="form-text text-muted">Input untuk shipping address dari order yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Order Address</label>
                            <input type="text" name="order_address" class="form-control" value="{{ $order['order_address'] }}" placeholder="Order Address" readonly>
                            <small class="form-text text-muted">Input untuk height dari order address yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Order Email</label>
                            <input type="email" name="order_email" class="form-control" value="{{ $order['order_email'] }}" placeholder="Input Order Email" readonly>
                            <small class="form-text text-muted">Input untuk order_email dari order yang akan ditampilkan.</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label>Erder Date</label>
                            <input type="date" name="order_date" class="form-control" value="{{ $order['order_date'] }}" placeholder="Input Date" readonly>
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
                        </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach($order_details as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration  }}<input name="order_detail_id[]" hidden value="{{ $item['id']  }}"><input name="order_id[]" hidden value="{{ $item['order_id']  }}"></td>
                                    <td class="row-index text-center"><select name="product_id[]" class="form-control" readonly> <option disabled selected>Pilih Product</option> @foreach($products as $row) <option value="{{ $row['id'] }}" {{  $item['product_id'] == $row['id'] ? 'selected' : '' }}>{{ $row['title'] }}</option> @endforeach </select></td>
                                    <td class="row-index text-center"><label for="">Rp.{{ $a[] = $item['price'] }}</label></td>
                                    <td class="row-index text-center"><label for="">{{ $b[] = $item['quantity'] }} Pcs</label></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="row-index text-center text-middle" colspan="2" rowspan="2"><label for="">Total Order</label></td>
                                <td class="row-index text-center"><label for="">Rp.{{ array_sum($a) }}</label></td>
                                <td class="row-index text-center"><label for="">{{ array_sum($b) }} Pcs</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-group mt-4" style="margin-buttom: 20px;">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
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
