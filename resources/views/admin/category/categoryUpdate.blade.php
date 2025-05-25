@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Category Name</h1>
        </div>

        <div class="">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('admin.categoryUpdateStore') }}" method="post" class="p-3 rounded">
                            @csrf

                            <input type="text" name="categoryName" value="{{ old('categoryName', $category->name) }}"
                                class=" form-control @error('categoryName') is-invalid @enderror "
                                placeholder="Category Name...">
                            @error('categoryName')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                            <a href="{{ route('admin#categoryList') }}"
                                class="btn btn-outline-danger text-danger mt-3">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
