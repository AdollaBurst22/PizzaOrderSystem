@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div>
                <a href="{{ route('superadmin.accountList', ['accountType' => 'user']) }}"> <button
                        class=" btn btn-sm btn-secondary  "> User
                        List</button>
                </a>
                <button class="btn btn-sm btn-secondary">Total User Count ({{ $totalAccounts }})</button>
            </div>
            <div class="">
                <form action="{{ route('superadmin.accountList', ['accountType' => 'user']) }}" method="get">
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
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-nowrap">ID</th>
                                <th class="text-nowrap">Profile</th>
                                <th class="text-nowrap">Name</th>
                                <th class="text-nowrap">Nickname</th>
                                <th class="text-nowrap">Email</th>
                                <th class="text-nowrap">Address</th>
                                <th class="text-nowrap">Phone</th>
                                <th class="text-nowrap">Role</th>
                                <th class="text-nowrap">Platform</th>
                                <th class="text-nowrap">Created Date</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td class="text-nowrap text-truncate" style="max-width: 50px;">
                                        {{ $account->id ?? '-' }}
                                    </td>
                                    <td class="text-nowrap">
                                        <img src="{{ $account->profile != null && file_exists(public_path('admin/profileImages/' . $account->profile)) ? asset('admin/profileImages/' . $account->profile) : asset('admin/profileImages/no image.webp') }}"
                                            alt="profileImage" class="img-thumbnail shadow-sm"
                                            style="height: 50px; width: 50px; object-fit: cover;">
                                    </td>
                                    <td class="text-nowrap text-truncate" style="max-width: 200px;">
                                        {{ $account->name ?? '-' }}
                                    </td>
                                    <td class="text-nowrap text-truncate" style="max-width: 300px;">
                                        {{ $account->nickname ?? '-' }}
                                    </td>
                                    <td class="text-nowrap text-truncate" style="max-width: 300px;">
                                        {{ $account->email ?? '-' }}
                                    </td>
                                    <td class="text-truncate"
                                        style="max-width: 350px; max-height: 3em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        {{ $account->address ?? '-' }}
                                    </td>
                                    <td class="text-nowrap text-truncate" style="max-width: 200px;">
                                        {{ $account->phone ?? '-' }}
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($account->role == 'superadmin')
                                            <span
                                                class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $account->role }}</span>
                                        @else
                                            {{ $account->role }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
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
                                    <td class="text-nowrap text-truncate" style="max-width: 100px;">
                                        {{ $account->created_at->format('d F Y') }}
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('superadmin.accountView', $account->id) }}"
                                            class="btn btn-sm btn-outline-primary"> <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteAccount({{ $account->id }})">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($accounts) == 0)
                                <tr>
                                    <td colspan="10">
                                        <h5 class="text-muted text-center">There is no user account.</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <span class="d-fles justify-content-end">{{ $accounts->links() }}</span>

            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        function deleteAccount($accountId) {
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
                        location.href = '/superadmin/profile/accountdelete/' + $accountId
                    }, 1000);
                }
            });
        }
    </script>
@endsection
