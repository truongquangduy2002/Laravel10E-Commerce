@extends('admin.admin_dashboard')
@section('admin')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Category</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <div class="col">
                            <a href="{{ route('add.category') }}"><button type="button"
                                    class="btn btn-primary px-5 radius-30">Add Category</button></a>
                        </div>
                    </div>
                </div>

            </div>
            <!--end breadcrumb-->
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Image</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categoriesData as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td> <img src="{{ asset($item->category_image) }}"
                                                style="width: 70px; height:40px;">
                                        </td>
                                        <td>{{ $item->category_name }}</td>
                                        <td>
                                            <a href="{{ route('edit.category', $item->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{ route('delete.category', $item->id) }}"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Image</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
