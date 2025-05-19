<div class="row">
    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">Nama: <span class="text-danger">*</span></label>
        <div class="col-12 col-md-6">
            <input type="text" name="name" id="name"
                value="{{ old('name', isset($user->name) ? $user->name : '') }}" class="form-control"
                placeholder="Masukan nama lengkap">
            @if ($errors->has('name'))
                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                    {{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">Username: <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5">
            <input type="text" name="username"
                value="{{ old('username', isset($user->username) ? $user->username : '') }}" class="form-control"
                placeholder="Masukan username">
            @if ($errors->has('username'))
                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                    {{ $errors->first('username') }}</div>
            @endif
        </div>
    </div>
    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">No Telepon: <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5">
            <input type="text" name="phone" id="phone"
                value="{{ old('phone', isset($user->phone_number) ? $user->phone_number : '') }}" class="form-control"
                placeholder="Masukan no handpone">
            @if ($errors->has('phone'))
                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                    {{ $errors->first('phone') }}</div>
            @endif
        </div>
    </div>
    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">Email: <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5">
            <input type="email" name="email" id="email"
                value="{{ old('email', isset($user->email) ? $user->email : '') }}" class="form-control"
                placeholder="Masukan alamat email">
            @if ($errors->has('email'))
                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                    {{ $errors->first('email') }}</div>
            @endif
        </div>
    </div>
    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">Divisi: <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5">
            <select name="division" id="division" class="form-control select" data-placeholder="Pilih Divisi...">
                <option></option>
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}" @if ($division->id == old('division', isset($user->division_id) ? $user->division_id : '')) selected @endif>
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
    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">Jabatan: <span class="text-danger">*</span></label>
        <div class="col-12 col-md-5">
            <select name="position" id="position" class="form-control select" data-placeholder="Pilih Jabatan...">
                <option></option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}" @if ($position->id == old('position', isset($user->position_id) ? $user->position_id : '')) selected @endif>
                        {{ $position->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('position'))
                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                    {{ $errors->first('position') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">Role: <span class="text-danger">*</span></label>
        <div class="col-12 col-md-4">
            <select name="role" id="role" class="form-control select" data-placeholder="Pilih Role...">
                <option></option>
                <option value="superadmin" @if ('superadmin' == old('role', isset($user->role) ? $user->role : '')) selected @endif>
                    Superadmin
                </option>
                <option value="admin" @if ('admin' == old('role', isset($user->role) ? $user->role : '')) selected @endif>Admin
                </option>
                <option value="user" @if ('user' == old('role', isset($user->role) ? $user->role : '')) selected @endif>User
                </option>
            </select>
            @if ($errors->has('role'))
                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                    {{ $errors->first('role') }}</div>
            @endif
        </div>
    </div>

    <div class="col-12 mb-3 row">
        <label class="form-label col-12 col-md-2">Password: @if (!isset($user))
                <span class="text-danger">*</span>
            @endif
        </label>
        <div class="col-12 col-md-6">
            <div class="input-group">
                <input type="text" name="password" id="password" value="{{ old('password') }}"
                    class="form-control">
                <button class="btn btn-light" type="button" id="repeat-password"><i class="ph-repeat"></i>
                </button>
            </div>
            @if ($errors->has('password'))
                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>
                    {{ $errors->first('password') }}</div>
            @endif
        </div>
    </div>
</div>
