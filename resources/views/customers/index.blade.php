@extends('layouts.admin')

@section('title', 'Customer List')
@section('content-header', 'Customer List')
@section('content-actions')
    <a href="{{route('customers.create')}}" class="btn btn-primary">Add Customer</a>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<style>

    @media screen and (max-width: 600px) {
    .hide_responsive {
        white-space: nowrap;
        }

    }
</style>
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <table class="table responsive_table ">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td class="hide_responsive">{{$customer->id}}</td>
                        <td class="hide_responsive">
                            <img width="50" src="{{$customer->getAvatarUrl()}}" alt="">
                        </td>
                        <td class="hide_responsive">{{$customer->first_name}}</td>
                        <td class="hide_responsive">{{$customer->last_name}}</td>
                        <td class="hide_responsive">{{$customer->email}}</td>
                        <td class="hide_responsive">{{$customer->phone}}</td>
                        <td class="hide_responsive">{{$customer->address}}</td>
                        <td class="hide_responsive">{{$customer->created_at}}</td>
                        <td class="hide_responsive">
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            <button class="btn btn-danger btn-delete" data-url="{{route('customers.destroy', $customer)}}"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $customers->render() }}
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-delete', function () {
                $this = $(this);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this customer?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.post($this.data('url'), {_method: 'DELETE', _token: '{{csrf_token()}}'}, function (res) {
                            $this.closest('tr').fadeOut(500, function () {
                                $(this).remove();
                            })
                        })
                    }
                })
            })
        })
    </script>
@endsection
