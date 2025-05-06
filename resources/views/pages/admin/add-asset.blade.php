@extends('layouts.main')

@section('title_admin', 'Tambah Asset')

@section('content_admin')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.asset.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-9 col-sm-12 mb-3 row">
                            <div class="col-12 col-md-4  mb-3">
                                <label class="form-label">Sub Kelompok:</label>
                                <select name="idSubCategory" id="idSubCategory" class="form-control select"
                                    data-placeholder="Pilih Sub Kelompok...">
                                    <option></option>
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            @if ($subCategory->id == old('idSubCategory')) selected @endif>
                                            [{{ rtrim($subCategory->code, '.') }}]
                                            {{ $subCategory->description }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('idSubCategory'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('idSubCategory') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-12 mb-3">
                                <label class="form-label">Code :</label>
                                <input type="text" name="code" id="code" value="{{ old(key: 'code') }}"
                                    class="form-control" placeholder="">
                                @if ($errors->has('code'))
                                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                                        {{ $errors->first('code') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_admin')
    <script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <!-- Theme JS files -->
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_select2.js') }}"></script>
@endpush

@push('script_admin')
    <script>
        $(document).ready(function() {
            @if (session('error'))
                new Noty({
                    text: "{{ session('error') }}",
                    type: 'error'
                }).show();
            @endif

            $('#idSubCategory').on('change', function() {
                const id = $(this).val();

                // if (!id) return;

                // if (id == form.oldGroup.val()) {
                //     form.code.val(form.oldCode.val());
                //     return;
                // }
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.asset.last-code') }}?idSubCategory=" + id,
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
        });
    </script>
@endpush
