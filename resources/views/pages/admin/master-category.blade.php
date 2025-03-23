@extends('layouts.main')

@section('title_admin', 'Master Kelompok')

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
                            <td class="text-center"><span
                                    class="badge text-reset bg-dark bg-opacity-20">{{ rtrim($row->code, '.') }}</span></td>
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
                                                data-code="{{ rtrim($row->code, '.') }}"
                                                data-description="{{ $row->description }}" data-period="{{ $row->period }}"
                                                data-scope-id="{{ $row->scope_id }}" class="edit-scope dropdown-item">
                                                <i class="ph-pencil-line me-2"></i>
                                                Edit
                                            </button>
                                            <button type="button" data-id="{{ $row->id }}"
                                                data-code="{{ rtrim($row->code, '.') }}"
                                                class="delete-scope dropdown-item">
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

    <div id="categoryModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ph-newspaper me-2"></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCategory" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idCategory" value="{{ old('id') }}">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="form-label">Bidang :</label>
                                <select name="idScope" id="idScope" class="form-control select">
                                    <option value="" disabled selected>-- Pilih Bidang --</option>
                                    @foreach ($scopes as $scope)
                                        <option value="{{ $scope->id }}"
                                            @if ($scope->id == old('idScope')) selected @endif>
                                            [{{ rtrim($scope->code, '.') }}]
                                            {{ $scope->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="form-label">Kode :</label>
                                <input type="text" name="code" id="inputCode" value="{{ old('code') }}"
                                    class="form-control" placeholder="Example : 1.00.00" required @readonly(true)>
                                @if ($errors->has('code'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('code') }}</div>
                                @endif
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
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

                            <div class="col-md-8 mb-3">
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
    <script src="{{ asset('assets/js/vendor/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickers/datepicker.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/picker_date.js') }}"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {

            let form = {
                id: $('#idCategory'),
                code: $('#inputCode'),
                description: $('#description'),
                period: $('#period'),
                idScope: $('#idScope'),
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
                        '<i class="ph-pencil-line"></i> Edit Kelompok : {{ old('description') }}');

                    $('#formCategory').attr('action',
                        '{{ route('admin.master.category.update', ['id' => ':id']) }}'
                        .replace(
                            ':id', "{{ old('id') }}"));
                    form.idScope.val('{{ old('idScope') }}').trigger('change').prop('disabled', false);
                    $('#formCategory').append('<input type="hidden" name="_method" value="PUT">');
                @else
                    $('.modal-title').html('<i class="ph-plus"></i> Tambah Kelompok');
                    $('#formCategory').attr('action',
                        '{{ route('admin.master.category.store') }}');
                @endif
                $('#categoryModal').modal('show');
            @endif


            $(document).on('click', '.edit-scope', function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                const description = $(this).data('description');
                const period = $(this).data('period');
                const idScope = $(this).data('scope-id');

                form.id.val(id);
                form.code.val(code);
                form.description.val(description);
                form.period.val(period);
                form.idScope.val(idScope).prop('disabled', false);

                $('.modal-title').html(`<i class="ph-pencil-line"></i> Edit Kelompok : ${description}`);
                $('#formCategory').attr('action',
                    '{{ route('admin.master.category.update', ['id' => ':id']) }}'
                    .replace(
                        ':id', id));
                $('#formCategory').append('<input type="hidden" name="_method" value="PUT">');
                $('#categoryModal').modal('show');
            });

            $('#addCategory').on('click', function() {
                form.id.val('');
                form.description.val('');
                form.period.val('');
                form.code.val('');
                form.idScope.val('').prop('disabled', false);

                $('.modal-title').html('<i class="ph-plus"></i> Tambah Kelompok');

                $('#formCategory').attr('action',
                    '{{ route('admin.master.category.store') }}');
                $('#formSubCategory').append('<input type="hidden" name="_method" value="POST">');

                $('#categoryModal').modal('show');
            })

            $('#inputCode').on('input', function() {
                $(this).val($(this).val().replace(/[^0-9.]/g, '')); // Hanya angka dan titik
            });

            $(document).on('click', '.delete-scope', function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                Swal.fire({
                    title: 'Perhatian!',
                    text: `Hapus kelompok, code : ${code}?`,
                    icon: 'info',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.delete-form').attr('action',
                            '{{ route('admin.master.category.destroy', ['id' => ':id']) }}'
                            .replace(
                                ':id', id));
                        $('.delete-form').submit();
                    }
                });
            });

            $('#idScope').on('change', function() {
                const id = $(this).val();

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.master.category.last-code') }}?idScope=" + id,
                    dataType: 'json',
                    success: function(response) {
                        form.code.val(response.code);
                    },
                    error: function(error) {
                        new Noty({
                            text: "Terjadi kesalahan sistem",
                            type: 'error'
                        }).show();
                    }
                })
            });
        })
    </script>
@endpush
