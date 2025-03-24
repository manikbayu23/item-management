@extends('layouts.main')

@section('title_admin', 'Buat Akun Pengguna')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <a href="{{ route('admin.user-accounts.create') }}" class="btn btn-primary"><i class="ph-plus me-1"></i> Buat
                    Akun</a>
            </div>
            <table class="table table-striped datatable-pagination">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Divisi</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->account->division->code ?? '-' }}</td>
                            <td class="text-center">
                                @php
                                    $role = $row->account->role ?? '-';
                                @endphp
                                <span
                                    class="badge @if ($role == 'admin') bg-warning 
                                @else
                                bg-light text-body @endif">{{ $role }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.user-accounts.edit', $row->id) }}"
                                                class="edit-scope dropdown-item">
                                                <i class="ph-pencil-line me-2"></i>
                                                Edit
                                            </a>
                                            <button type="button" class="delete-user dropdown-item"
                                                data-id={{ $row->id }} data-name={{ $row->name }}>
                                                <i class="ph-trash me-2"></i>
                                                Delete
                                            </button>
                                            <form class="delete-form" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script_admin')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/datepicker.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/picker_date.js') }}"></script>
@endpush
@push('script_admin')
    <script>
        $(document).ready(function() {
            @if (session('success'))
                new Noty({
                    text: "{{ session('success') }}",
                    type: 'success'
                }).show();
            @endif
        })

        $(document).on('click', '.delete-user', function() {
            const id = $(this).data('id');
            const code = $(this).data('name');
            Swal.fire({
                title: 'Perhatian!',
                text: `Hapus User : ${code}?`,
                icon: 'info',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.delete-form').attr('action',
                        '{{ route('admin.user-accounts.destroy', ['id' => ':id']) }}'
                        .replace(
                            ':id', id));
                    $('.delete-form').submit();
                }
            });
        });
    </script>
@endpush
