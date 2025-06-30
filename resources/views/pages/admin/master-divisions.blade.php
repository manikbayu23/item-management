@extends('layouts.main')

@section('title_admin', 'Master Divisi')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                @if (Auth::user()->role == 'admin')
                    <button type="button" id="addDivision" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                @endif
            </div>

            <table class="table table-striped datatable-pagination">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%">No.</th>
                        <th style="width: 30%">Nama</th>
                        <th style="width: 40%">Deskripsi</th>
                        @if (Auth::user()->role == 'admin')
                            <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($divisions as $index => $division)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $division->name }}</td>
                            <td>{{ $division->description }}</td>
                            @if (Auth::user()->role == 'admin')
                                <td class="text-center">
                                    <button type="button" data-id="{{ $division->id }}" data-name="{{ $division->name }}"
                                        data-description="{{ $division->description }}"
                                        class="edit-division btn btn-flat-warning btn-icon"><i class="ph-pencil-line"></i>
                                    </button>
                                    <button type="button" data-id="{{ $division->id }}" data-name="{{ $division->name }}"
                                        class="delete-division btn btn-flat-danger btn-icon"><i class="ph-trash"></i>
                                    </button>
                                    <form class="delete-form" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            @endif
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
                        <input type="hidden" name="id" id="idDivision" value="{{ old('id', null) }}">
                        <div class="row">
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
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi :</label>
                                <textarea name="description" id="inputDescription" class="form-control" rows="3">{{ old('description') }}</textarea>
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
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {

            let form = {
                id: $('#idDivision'),
                name: $('#inputName'),
                description: $('#inputDescription'),
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
                        '{{ route('admin.master.division.update', ['id' => ':id']) }}'
                        .replace(
                            ':id', "{{ old('id') }}"));
                    $('#formDivision').append('<input type="hidden" name="_method" value="PUT">');
                @else
                    $('.modal-title').html('<i class="ph-plus-circle"></i> Tambah Divisi');
                    $('#formDivision').attr('action',
                        '{{ route('admin.master.division.store') }}');
                @endif
                $('#divisionModal').modal('show');
            @endif


            $(document).on('click', '.edit-division', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const description = $(this).data('description');

                form.id.val(id);
                form.name.val(name);
                form.description.val(description);

                $('.form-text').empty();

                $('.modal-title').html(`<i class="ph-pencil-line"></i> Edit Divisi : ${name}`);
                $('#formDivision').attr('action',
                    '{{ route('admin.master.division.update', ['id' => ':id']) }}'
                    .replace(
                        ':id', id));
                $('#formDivision').append('<input type="hidden" name="_method" value="PUT">');
                $('#divisionModal').modal('show');
            });

            $('#addDivision').on('click', function() {
                form.id.val('');
                form.name.val('');
                form.description.val('');

                $('.form-text').empty();

                $('.modal-title').html('<i class="ph-plus-circle"></i> Tambah Divisi');

                $('#formDivision').attr('action',
                    '{{ route('admin.master.division.store') }}');
                $('#formDivision').append('<input type="hidden" name="_method" value="POST">');

                $('#divisionModal').modal('show');
            })

            $(document).on('click', '.delete-division', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const description = $(this).data('description');

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
                            '{{ route('admin.master.division.destroy', ['id' => ':id']) }}'
                            .replace(
                                ':id', id));
                        $('.delete-form').submit();
                    }
                });
            });
        })
    </script>
@endpush
