@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div>
                <a href="{{ route('superadmin.adminList') }}"> <button class=" btn btn-sm btn-secondary  "> User List</button>
                </a>
                <button class="btn btn-sm btn-secondary">Total Admin Count ({{ $totalAdmin }})</button>
            </div>
            <div class="">
                <form action="{{ route('superadmin.adminList') }}" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-hover shadow-sm" style="min-width: 1200px;">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="truncate-one-line">ID</th>
                                <th class="truncate-one-line">Profile</th>
                                <th class="truncate-one-line">Name</th>
                                <th class="truncate-one-line">Nickname</th>
                                <th class="truncate-one-line">Email</th>
                                <th class="truncate-two-line">Address</th>
                                <th class="truncate-one-line">Phone</th>
                                <th class="truncate-one-line">Role</th>
                                <th class="truncate-one-line">Created Date</th>
                                <th class="truncate-one-line">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adminAccounts as $account)
                                <tr>

                                    <td class="truncate-one-line">
                                        @if ($account->id)
                                            {{ $account->id }}
                                        @endif
                                    </td>
                                    <td class="truncate-one-line"><img
                                            src="{{ asset($account->profile != null ? 'admin/profileImages/' . $account->profile : 'admin/profileImages/no image.webp') }}"
                                            alt="profileImage" class="w-25 h-25 img-thumbnail shadow-sm"></td>
                                    <td class="truncate-one-line">
                                        @if ($account->name)
                                            {{ $account->name }}
                                        @endif
                                    </td>
                                    <td class="truncate-one-line">
                                        @if ($account->nickname)
                                            {{ $account->nickname }}
                                        @endif
                                    </td>
                                    <td class="truncate-one-line">
                                        @if ($account->email)
                                            {{ $account->email }}
                                        @endif
                                    </td>
                                    <td class="truncate-two-lines">
                                        @if ($account->address)
                                            {{ $account->address }}
                                        @endif
                                    </td>
                                    <td class="truncate-one-line">
                                        @if ($account->phone)
                                            {{ $account->phone }}
                                        @endif
                                    </td>
                                    <td class="truncate-one-line">
                                        @if ($account->role)
                                            {{ $account->role }}
                                        @endif
                                        @if ($account->role == 'superadmin')
                                            <span class="btn btn-sm bg-danger text-white rounded shadow-sm"></span>
                                        @endif
                                    </td>
                                    <td class="truncate-one-line">
                                        {{ $account->created_at->format('d F Y') }}
                                    </td>
                                    <td class="truncate-one-line">

                                        <a href="" class="btn btn-sm btn-outline-primary"> <i
                                                class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="" class="btn btn-sm btn-outline-secondary"> <i
                                                class="fa-solid fa-pen-to-square"></i> </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteProduct({{ $account->id }})">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                            @if (count($adminAccounts) == 0)
                                <tr>
                                    <td colspan="10">
                                        <h5 class="text-muted text-center">There is no admin account.</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <span class="d-fles justify-content-end">{{ $adminAccounts->links() }}</span>


                <span class=" d-flex justify-content-end"></span>

            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        function deleteProduct($accountId) {
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
                        location.href = '/superadmin/profile/admindelete/' + $accountId
                    }, 1000);
                }
            });
        }
    </script>
@endsection
