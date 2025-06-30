@extends('layouts.main')

@section('title_admin', 'Master Ruangan')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                @if (Auth::user()->role == 'admin')
                    <button type="button" id="addCategory" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                @endif
            </div>

            <table class="table table-striped datatable-pagination">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%">No.</th>
                        <th style="width: 25%">Nama</th>
                        <th style="width: 30%">Deskripsi</th>
                        <th class="text-center">Divisi</th>
                        <th class="text-center">Print QR</th>
                        @if (Auth::user()->role == 'admin')
                            <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $index => $room)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->description }}</td>
                            <td class="text-center">{{ $room->division->name }}</td>
                            @if (Auth::user()->role == 'admin')
                                <td class="text-center">
                                    <button type="button" data-name="{{ $room->name }}" data-slug="{{ $room->slug }}"
                                        class="print-room btn btn-flat-success btn-icon"><i class="ph-qr-code"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" data-id="{{ $room->id }}" data-name="{{ $room->name }}"
                                        data-division="{{ $room->division_id }}" data-description="{{ $room->description }}"
                                        class="edit-room btn btn-flat-warning btn-icon"><i class="ph-pencil-line"></i>
                                    </button>
                                    <button type="button" data-id="{{ $room->id }}" data-name="{{ $room->name }}"
                                        class="delete-room btn btn-flat-danger btn-icon"><i class="ph-trash"></i>
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

    <div id="roomModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ph-newspaper me-2"></i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formRoom" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idRoom" value="{{ old('id', null) }}">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama Ruangan :</label>
                                <input type="text" id="inputName" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="Ruangan 1">
                                @if ($errors->has('name'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Divisi :</label>
                                <select name="division" id="inputDivision" class="form-control select"
                                    data-placeholder="Pilih Divisi...">
                                    <option></option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            @if ($division->id == old('division')) selected @endif>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('division'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('division') }}</div>
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
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>

    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {

            let form = {
                id: $('#idRoom'),
                name: $('#inputName'),
                division: $('#inputDivision'),
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
                        '<i class="ph-pencil-line"></i> Edit Rungan : {{ old('name') }}');

                    $('#formRoom').attr('action',
                        '{{ route('admin.master.room.update', ['id' => ':id']) }}'
                        .replace(
                            ':id', "{{ old('id') }}"));
                    $('#formRoom').append('<input type="hidden" name="_method" value="PUT">');
                @else
                    $('.modal-title').html('<i class="ph-plus-circle"></i> Tambah Rungan');
                    $('#formRoom').attr('action',
                        '{{ route('admin.master.room.store') }}');
                @endif
                $('#roomModal').modal('show');
            @endif


            $(document).on('click', '.edit-room', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const division = $(this).data('division');
                const description = $(this).data('description');

                form.id.val(id);
                form.name.val(name);
                form.division.val(division).trigger('change');
                form.description.val(description);

                $('.form-text').empty();

                $('.modal-title').html(`<i class="ph-pencil-line"></i> Edit Rungan : ${name}`);
                $('#formRoom').attr('action',
                    '{{ route('admin.master.room.update', ['id' => ':id']) }}'
                    .replace(
                        ':id', id));
                $('#formRoom').append('<input type="hidden" name="_method" value="PUT">');
                $('#roomModal').modal('show');
            });

            $('#addCategory').on('click', function() {
                form.id.val('');
                form.name.val('');
                form.division.val('').trigger('change');
                form.description.val('');

                $('.form-text').empty();

                $('.modal-title').html('<i class="ph-plus-circle"></i> Tambah Rungan');

                $('#formRoom').attr('action',
                    '{{ route('admin.master.room.store') }}');
                $('#formRoom').append('<input type="hidden" name="_method" value="POST">');

                $('#roomModal').modal('show');
            })

            $(document).on('click', '.print-room', function() {
                const params = {
                    name: $(this).data('name'),
                    slug: $(this).data('slug'),
                }
                printRoom(params);
            });

            const printRoom = (params) => {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: '{{ route('admin.master.room.print') }}', // URL untuk mengakses controller
                    type: 'POST',
                    data: {
                        params,
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // CSRF Token untuk keamanan
                    },
                    xhrFields: {
                        responseType: 'blob' // penting agar respon dianggap sebagai file
                    },
                    success: function(response) {
                        const blob = new Blob([response], {
                            type: 'application/pdf'
                        });
                        const url = window.URL.createObjectURL(blob);

                        window.open(url); // buka tab baru untuk cetak
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal cetak PDF:', error);
                    },
                    complete: function() {
                        Swal.close();
                    }
                });
            }

            $(document).on('click', '.delete-room', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const description = $(this).data('description');

                Swal.fire({
                    title: 'Perhatian!',
                    text: `Hapus ruangan ${name}?`,
                    icon: 'info',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-light'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.delete-form').attr('action',
                            '{{ route('admin.master.room.destroy', ['id' => ':id']) }}'
                            .replace(
                                ':id', id));
                        $('.delete-form').submit();
                    }
                });
            });


        })
    </script>
@endpush
