@extends('layouts.main')

@section('title_admin', 'Master Golongan')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <button type="button" id="addGroup" class="btn btn-primary"><i class="ph-plus"></i></button>
            </div>

            <table class="table table-striped datatable-pagination">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Kode</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $row->code }}</td>
                            <td>{{ $row->description }}</td>
                            <td class="text-center">{{ $row->period }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <button type="button" data-id="{{ $row->id }}"
                                                data-code="{{ $row->code }}" data-description="{{ $row->description }}"
                                                data-period="{{ $row->period }}" class="edit-group dropdown-item">
                                                <i class="ph-pencil-line me-2"></i>
                                                Edit
                                            </button>
                                            <button type="button" data-id="{{ $row->id }}"
                                                data-code="{{ $row->code }}" class="delete-group dropdown-item">
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

    <div id="groupModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ph-newspaper me-2"></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGroup" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idGroup" value="{{ old('id') }}">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="form-label">Kode :</label>
                                <input type="text" name="code" id="inputCode" value="{{ old('code') }}"
                                    class="form-control" placeholder="1." required @readonly(true)>
                                @if ($errors->has('code'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('code') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="form-label">Periode :</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                    <input type="text" id="period" name="period"
                                        class="form-control datepicker-basic" value="{{ old('period') }}"
                                        placeholder="Pilih Periode" required>
                                </div>
                                @if ($errors->has('period'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('period') }}</div>
                                @endif
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi :</label>
                                <input type="text" id="description" name="description" value="{{ old('description') }}"
                                    class="form-control" placeholder="Persediaan" required>
                                @if ($errors->has('description'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('description') }}</div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-end">
                        <button data-bs-dismiss="modal" class="btn btn-light">
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

            @if ($errors->any())
                @if (old('id'))
                    $('.modal-title').html(
                        '<i class="ph-pencil-line"></i> Edit Golongan : {{ old('description') }}');
                    $('#formGroup').attr('action',
                        '{{ route('admin.master.group.update', ['id' => ':id']) }}'
                        .replace(
                            ':id', "{{ old('id') }}"));
                    $('#formGroup').append('<input type="hidden" name="_method" value="PUT">');
                @else
                    $('.modal-title').html('<i class="ph-plus"></i> Tambah Golongan');
                    $('#formGroup').attr('action',
                        '{{ route('admin.master.group.store') }}');
                @endif
                $('#groupModal').modal('show');
            @endif

            let form = {
                id: $('#idGroup'),
                code: $('#inputCode'),
                description: $('#description'),
                period: $('#period'),
            }

            $(document).on('click', '.edit-group', function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                const description = $(this).data('description');
                const period = $(this).data('period');

                form.id.val(id);
                form.code.val(code);
                form.description.val(description);
                form.period.val(period);

                $('.modal-title').html(`<i class="ph-pencil-line"></i> Edit Golongan : ${description}`);
                $('#formGroup').attr('action',
                    '{{ route('admin.master.group.update', ['id' => ':id']) }}'
                    .replace(
                        ':id', id));
                $('#formGroup').append('<input type="hidden" name="_method" value="PUT">');
                $('#groupModal').modal('show');
            });

            $('#addGroup').on('click', function() {
                form.id.val('');
                form.description.val('');
                form.period.val('');

                getLastCode()
            })

            $('#inputCode').on('input', function() {
                $(this).val($(this).val().replace(/[^0-9.]/g, '')); // Hanya angka dan titik
            });

            $(document).on('click', '.delete-group', function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                Swal.fire({
                    title: 'Perhatian!',
                    text: `Hapus kategori, code : ${code}?`,
                    icon: 'info',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.delete-form').attr('action',
                            '{{ route('admin.master.group.destroy', ['id' => ':id']) }}'
                            .replace(
                                ':id', id));
                        $('.delete-form').submit();
                    }
                });
            });

            function getLastCode() {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.master.group.last-code') }}",
                    dataType: 'json',
                    success: function(response) {
                        form.code.val(response.code);
                        $('.modal-title').html('<i class="ph-plus"></i> Tambah Golongan');

                        $('#formGroup').attr('action',
                            '{{ route('admin.master.group.store') }}');
                        $('#groupModal').modal('show');

                    },
                    error: function(error) {
                        new Noty({
                            text: "Terjadi kesalahan sistem",
                            type: 'error'
                        }).show();
                    }
                })
            }
        })
    </script>
@endpush
