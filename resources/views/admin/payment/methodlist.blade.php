@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment Method List</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('superadmin.paymentMethodCreate') }}" method="post" class="p-3 rounded">
                                @csrf
                                <input type="text" name="accountName" value="{{ old('accountName') }}"
                                    class=" form-control @error('accountName')
                                    is-invalid
                                @enderror mb-3"
                                    placeholder="Account Name...">
                                @error('accountName')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                                <input type="text" name="accountType" value="{{ old('accountType') }}"
                                    class=" form-control @error('accountType')
                                    is-invalid
                                @enderror mb-3"
                                    placeholder="Account Type...">
                                @error('accountType')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                                <input type="text" name="accountNumber" value="{{ old('accountNumber') }}"
                                    class=" form-control @error('accountNumber')
                                    is-invalid
                                @enderror mb-3"
                                    placeholder="Account Number...">
                                @error('accountNumber')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col ">
                    <table class="table table-hover shadow-sm ">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th>Account Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($methods as $method)
                                <tr>
                                    <td>{{ $method->id }}</td>
                                    <td>{{ $method->account_name }}</td>
                                    <td>{{ $method->account_type }}</td>
                                    <td>{{ $method->account_number }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.paymentMethodUpdate', ['methodId' => $method->id]) }}"
                                            class="btn btn-sm btn-outline-secondary"> <i
                                                class="fa-solid fa-pen-to-square"></i> </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteMethod({{ $method->id }})"> <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                    <span class=" d-flex justify-content-end">{{ $methods->links() }}</span>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js-script')
    <script>
        function deleteMethod($methodId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    setInterval(() => {
                        location.href = '/superadmin/paymentmethod/delete/' + $methodId
                    }, 1000);
                }
            });
        }
    </script>
@endsection
