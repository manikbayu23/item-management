@extends('layouts.main')

@section('title_admin', 'Master Divisi')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <button type="button" id="addCategory" class="btn btn-primary"><i class="ph-plus"></i></button>
            </div>

            <table class="table table-striped datatable-pagination">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Kode Departemen</th>
                        <th class="text-center">Kode</th>
                        <th>Nama</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                {{ $row->department->code }}
                            </td>
                            <td class="text-center">
                                {{ $row->code }}
                            </td>
                            <td>{{ $row->name }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <button type="button" data-id="{{ $row->id }}"
                                                data-code="{{ $row->code }}" data-name="{{ $row->name }}"
                                                data-department="{{ $row->department_id }}"
                                                class="edit-division dropdown-item">
                                                <i class="ph-pencil-line me-2"></i>
                                                Edit
                                            </button>
                                            <button type="button" data-id="{{ $row->id }}"
                                                data-name="{{ $row->name }}" class="delete-division dropdown-item">
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

    <div id="divisionModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ph-newspaper me-2"></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formDivision" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idDivision" value="{{ old('id') }}">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="form-label">Departemen :</label>
                                <select name="idDepartment" id="idDepartment" class="form-control select">
                                    <option value="" disabled selected>-- Pilih Departemen --</option>
                                    @foreach ($departments as $departmen)
                                        <option value="{{ $departmen->id }}"
                                            @if ($departmen->id == old('idDepartment')) selected @endif>
                                            [{{ $departmen->code }}]
                                            {{ $departmen->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('idDepartment'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('idDepartment') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="form-label">Kode :</label>
                                <input type="text" name="code" id="inputCode" value="{{ old('code') }}"
                                    class="form-control" placeholder="Example : IT">
                                @if ($errors->has('code'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('code') }}</div>
                                @endif
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama :</label>
                                <input type="text" id="inputName" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="Information Technology">
                                @if ($errors->has('name'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-light">
                            <i class="ph-x me-1"></i>
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ph-floppy-disk me-1"></i>
                            Simpan
                        </button>
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
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {

            let form = {
                id: $('#idDivision'),
                code: $('#inputCode'),
                name: $('#inputName'),
                idDepartment: $('#idDepartment')
            }

            @if (session('success'))
                new Noty({
                    text: "{{ session('success') }}",
                    type: 'success'
                }).show();
            @endif

            @if ($errors->any())
                @if (old('id'))
                    $('.modal-title').html(
                        '<i class="ph-pencil-line"></i> Edit Divisi : {{ old('name') }}');

                    $('#formDivision').attr('action',
                        '{{ route('admin.master.divisions.update', ['id' => ':id']) }}'
                        .replace(
                            ':id', "{{ old('id') }}"));
                    form.idDepartment.val('{{ old('idDepartment') }}').trigger('change').prop('disabled', false);
                    $('#formDivision').append('<input type="hidden" name="_method" value="PUT">');
                @else
                    $('.modal-title').html('<i class="ph-plus"></i> Tambah Departmen');
                    $('#formDivision').attr('action',
                        '{{ route('admin.master.divisions.store') }}');
                @endif
                $('#divisionModal').modal('show');
            @endif


            $(document).on('click', '.edit-division', function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                const name = $(this).data('name');
                const idDepartment = $(this).data('department');

                form.id.val(id);
                form.code.val(code);
                form.name.val(name);
                form.idDepartment.val(idDepartment).prop('disabled', false);

                $('.form-text').empty();

                $('.modal-title').html(`<i class="ph-pencil-line"></i> Edit Divisi : ${name}`);
                $('#formDivision').attr('action',
                    '{{ route('admin.master.divisions.update', ['id' => ':id']) }}'
                    .replace(
                        ':id', id));
                $('#formDivision').append('<input type="hidden" name="_method" value="PUT">');
                $('#divisionModal').modal('show');
            });

            $('#addCategory').on('click', function() {
                form.id.val('');
                form.code.val('');
                form.name.val('');
                form.idDepartment.val('').prop('disabled', false);

                $('.form-text').empty();

                $('.modal-title').html('<i class="ph-plus"></i> Tambah Divisi');

                $('#formDivision').attr('action',
                    '{{ route('admin.master.divisions.store') }}');
                $('#formDivision').append('<input type="hidden" name="_method" value="POST">');

                $('#divisionModal').modal('show');
            })

            $(document).on('click', '.delete-division', function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                const name = $(this).data('name');

                Swal.fire({
                    title: 'Perhatian!',
                    text: `Hapus divisi ${name}?`,
                    icon: 'info',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.delete-form').attr('action',
                            '{{ route('admin.master.divisions.destroy', ['id' => ':id']) }}'
                            .replace(
                                ':id', id));
                        $('.delete-form').submit();
                    }
                });
            });
        })
    </script>
@endpush
