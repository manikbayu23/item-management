@extends('layouts.main')

@section('page_name2', 'Akun Pengguna')
@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Akun Pengguna</h5>
                <div>
                    <a href="{{ route('admin.user-account.create') }}" class="btn btn-primary"><i
                            class="ph-plus-circle me-1"></i>
                        Buat
                        Akun</a>
                </div>
            </div>
            <table class="table table-striped datatable-pagination">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Divisi</th>
                        <th class="text-center">Jabatan</th>
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
                            <td class="text-center">{{ $row->division->name ?? '-' }}</td>
                            <td class="text-center">{{ $row->position->name ?? '-' }}</td>
                            <td class="text-center">
                                @php
                                    $role = $row->role ?? '-';
                                @endphp
                                <span
                                    class="badge 
                                    @if ($role == 'admin') bg-teal 
                                    @elseif ($role == 'pic')
                                    bg-warning
                                    @else
                                    bg-secondary @endif">{{ $role }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @if (Auth::user()->role == 'pic')
                                                @if ($row->id == Auth::user()->id || $role !== 'pic')
                                                    <a href="{{ route('admin.user-account.edit', $row->id) }}"
                                                        class="edit-scope dropdown-item">
                                                        <i class="ph-pencil-line me-2"></i>
                                                        Edit
                                                    </a>
                                                    @if ($role == 'staff')
                                                        <button type="button" class="delete-user dropdown-item"
                                                            data-id={{ $row->id }} data-name={{ $row->name }}>
                                                            <i class="ph-trash me-2"></i>
                                                            Delete
                                                        </button>
                                                    @endif
                                                @endif
                                            @elseif (Auth::user()->role == 'admin')
                                                <a href="{{ route('admin.user-account.edit', $row->id) }}"
                                                    class="edit-scope dropdown-item">
                                                    <i class="ph-pencil-line me-2"></i>
                                                    Edit
                                                </a>
                                                <button type="button" class="delete-user dropdown-item"
                                                    data-id={{ $row->id }} data-name={{ $row->name }}>
                                                    <i class="ph-trash me-2"></i>
                                                    Delete
                                                </button>
                                            @endif
                                            @if (Auth::user()->role == 'admin')
                                                <button type="button" class="rooms-user dropdown-item"
                                                    data-id={{ $row->id }}>
                                                    <i class="ph-door me-2"></i>
                                                    Akses Ruangan
                                                </button>
                                            @endif
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

    <div id="roomsModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ph-door me-2"></i> Akses Ruangan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formUserRooms" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <select multiple="multiple" id="selectRooms" name="rooms[]" data-placeholder="Pilih ruangan..."
                            class="form-control select">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary"><i class="ph-floppy-disk me-1"></i>
                                Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
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
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>

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
            @if (session('error'))
                new Noty({
                    text: "{{ session('error') }}",
                    type: 'error'
                }).show();
            @endif

            $(document).on('click', '.rooms-user', function() {
                const id = $(this).data('id');
                const url = "{{ route('admin.user-account.rooms', ':id') }}".replace(':id', id);
                $.ajax({
                    method: 'GET',
                    url: url,
                    success: function(response) {
                        $('#selectRooms').empty();
                        const rooms = response.rooms;
                        const userRooms = response.user_rooms;
                        let options = '<option></option>';

                        rooms.forEach((room) => {
                            const isSelected = userRooms.includes(room.id);
                            options +=
                                `<option value="${room.id}" ${isSelected ? 'selected' : ''}>${room.name}</option>`;
                        });
                        $('#selectRooms').append(options);
                        $('#formUserRooms').attr('action',
                            '{{ route('admin.user-account.update-rooms', ['id' => ':id']) }}'
                            .replace(
                                ':id', id));
                        $('#roomsModal').modal('show');
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        console.log(responseJSON);
                        Swal.fire({
                            title: 'Perhatian!',
                            text: `Terjadi kesalahan pada jaringan, mohon diulangi.`,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            },
                        })
                    }
                })
            });

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
                            '{{ route('admin.user-account.destroy', ['id' => ':id']) }}'
                            .replace(
                                ':id', id));
                        $('.delete-form').submit();
                    }
                });
            });

        })
    </script>
@endpush
