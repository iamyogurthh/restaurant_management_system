@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kitchen Panel</h1>
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
                    <h3 class="card-title">Dishes</h3>
                    <a href="/dish/create" style="float: right;" class="btn btn-success">Create</a>
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
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishes as $dish)
                            <tr>
                                <td>{{ $dish->name }}</td>
                                <td>{{ $dish->category->name }}</td>
                                <td>{{ $dish->created_at }}</td>
                                <td>
                                    <div class="d-flex align-items-center ">
                                        <a href="/dish/{{ $dish->id }}/edit" class="btn btn-warning me-2">Edit</a>

                                        <form action="{{ route('dish.destroy', $dish->id) }}" method="post"
                                            class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('ဖြတ်ရန် သေချာပါသလား?')">
                                                Delete
                                            </button>
                                        </form>
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