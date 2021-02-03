@extends('layouts.appadmin')
@section('title')
    Orders
@endsection
@section('content')
    {{Form::hidden('',$increment=1)}}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"> Orders</h4>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Client Name</th>
                                    <th>Addres</th>
                                    <th>Cart</th>
                                    <th>Payment_id</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$increment}}</td>
                                    <td>{{$order->name}}</td>
                                    <td>{{$order->address}}</td>

                                    <td>
                                        @foreach($order->cart->items as $item)
                                            @if(end($order->cart->items) === $item )
                                                {{  $item['product_name'] }}
                                            @else
                                                {{  $item['product_name'].' ,' }}

                                            @endif
                                        @endforeach


                                    </td>
                                    <td>{{$order->payment_id}}</td>
                                    <td>
                                        <button class="btn btn-outline-primary">View</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('backend/js/data-table.js') }}"></script>
@endsection
