@extends('layouts.admin')

@section('title', 'Orders List')
@section('content-header', 'Order List')
@section('content-header', 'Dashboard')

@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary">Open POS</a>
@endsection

@section('content')

<style>
    .hide{
        border-top: 1px solid #dee2e600!important;
        
    }
    @media screen and (max-width: 600px) {
    .hide_responsive {
        white-space: nowrap;
        }

    }
</style>
<div class="card">
    <div class="card-body" style="overflow-x:auto">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{route('orders.index')}}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table responsive_table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Price</th>
                    <th>Cost</th>
                    <th>Received Amount</th>
                    <th>Status</th>
                    <th>To Pay</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedCost()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedReceivedAmount()}}</td>
                    <td>
                        @if($order->receivedAmount() == 0)
                            <span class="badge badge-danger">Not Paid</span>
                        @elseif($order->receivedAmount() < $order->total())
                            <span class="badge badge-warning">Partial</span>
                        @elseif($order->receivedAmount() == $order->total())
                            <span class="badge badge-success">Paid</span>
                        @elseif($order->receivedAmount() > $order->total())
                            <span class="badge badge-info">Change</span>
                        @endif
                    </td>
                    <td>{{config('settings.currency_symbol')}} {{number_format($order->total() - $order->receivedAmount(), 2)}}</td>
                    <td>{{$order->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="hide_responsive"></th>
                    <th class="hide_responsive">Total Price:</th>
                    <th class="hide_responsive">{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                    <th class="hide_responsive"></th>
                    <th class="hide_responsive"></th>
                    <th class="hide_responsive"></th>
                    <th class="hide_responsive"></th>
                </tr>
                <tr>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive">Total Received Amount:</th>
                    <th class="hide hide_responsive">{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                </tr>
                <tr>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive">Total Income:</th>
                    <th class="hide hide_responsive">{{ config('settings.currency_symbol') }} {{ number_format($Income, 2) }}</th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                </tr>
                <tr>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive">Total Profit</th>
                    <th class="hide hide_responsive">{{ config('settings.currency_symbol') }} {{ number_format($cost, 2) }}</th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                    <th class="hide hide_responsive"></th>
                </tr>
            </tfoot>

        </table>
        {{ $orders->render() }}
    </div>
</div>
@endsection

