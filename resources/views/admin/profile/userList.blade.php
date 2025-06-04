@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div>
                <a href="{{ route('superadmin.userList') }}"> <button class=" btn btn-sm btn-secondary  "> User List</button>
                </a>
                <button class="btn btn-sm btn-secondary">Total User Count ({{ $totalAdmin }})</button>
            </div>
            <div class="">
                <form action="{{ route('superadmin.userList') }}" method="get">

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
                                <th class="truncate-one-line">Platform</th>
                                <th class="truncate-one-line">Created Date</th>
                                <th class="truncate-one-line">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userAccounts as $account)
                                <tr>

                                    <td class="truncate-one-line">
                                        {{ $account->id ?? '-' }}
                                    </td>
                                    <td class="truncate-one-line"><img
                                            src="{{ asset($account->profile != null ? 'admin/profileImages/' . $account->profile : 'admin/profileImages/no image.webp') }}"
                                            alt="profileImage" class="img-thumbnail shadow-sm"></td>
                                    <td class="truncate-one-line">
                                        {{ $account->name ?? '-' }}
                                    </td>
                                    <td class="truncate-one-line">
                                        {{ $account->nickname ?? '-' }}
                                    </td>
                                    <td class="truncate-one-line">
                                        {{ $account->email ?? '-' }}
                                    </td>
                                    <td class="truncate-two-lines">
                                        {{ $account->address ?? '-' }}
                                    </td>
                                    <td class="truncate-one-line">
                                        {{ $account->phone ?? '-' }}
                                    </td>

                                    <td class="truncate-two-lines">
                                        @if ($account->provider == 'google')
                                            <i class="fa-brands fa-google text-primary"></i>
                                        @endif
                                        @if ($account->provider == 'github')
                                            <i class="fa-brands fa-github text-primary"></i>
                                        @endif
                                        @if ($account->provider == 'simple')
                                            <i class="fa-solid fa-right-to-bracket text-primary"></i>
                                        @endif
                                    </td>
                                    <td class="truncate-one-line">
                                        {{ $account->created_at->format('d F Y') }}
                                    </td>
                                    <td class="truncate-one-line">

                                        <a href="{{ route('superadmin.userAccountView', $account->id) }}"
                                            class="btn btn-sm btn-outline-primary"> <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteProduct({{ $account->id }})">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                            @if (count($userAccounts) == 0)
                                <tr>
                                    <td colspan="10">
                                        <h5 class="text-muted text-center">There is no admin account.</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <span class="d-fles justify-content-end">{{ $userAccounts->links() }}</span>

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
                        location.href = '/superadmin/profile/userdelete/' + $accountId
                    }, 1000);
                }
            });
        }
    </script>
@endsection
