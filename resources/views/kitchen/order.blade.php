@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Listing</h1>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <table id="dishes" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Dish Name</th>
                                <th>Table Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->dish->name }}</td>
                                <td>{{ $order->table_id }}</td>
                                <td>{{ $status[$order->status] }}</td>
                                <td>
                                    <div>
                                        <a href="/order/{{ $order->id }}/approve" class="btn btn-warning">Approve</a>
                                        <a href="/order/{{ $order->id }}/cancel" class="btn btn-danger">Cancel</a>
                                        <a href="/order/{{ $order->id }}/ready" class="btn btn-success">Ready</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

@push('scripts')
<script>
    $(function() {
        $('#dishes').DataTable({
            paging: true,
            lengthChange: false,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
        });
    });
</script>
@endpush

<!-- /.card -->
@endsection