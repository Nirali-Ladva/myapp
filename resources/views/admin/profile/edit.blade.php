@extends('layouts.app')

@section('content')
<h3>Edit Profile</h3>

<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
  @csrf

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row">
    <div class="col-md-6">
      <label>First Name</label>
      <input name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control">
      @error('first_name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label>Last Name</label>
      <input name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control">
      @error('last_name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="mt-3 row">
    <div class="col-md-6">
      <label>Birth Date</label>
      <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" class="form-control">
      @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label>Country</label>
      <input name="country" value="{{ old('country', $user->country) }}" class="form-control">
    </div>
  </div>

  <div class="mt-3">
    <label>Profile Image</label>
    <input type="file" name="profile_image" class="form-control">
    @if($user->profile_image)
      <div class="mt-2">
        <img src="{{ asset('storage/'.$user->profile_image) }}" width="100">
        <a href="javascript:void(0)" onclick="previewFile('{{ asset('storage/'.$user->profile_image) }}')">Preview</a>
      </div>
    @endif
  </div>

  <div class="mt-3">
    <label>Residential Proofs (multiple)</label>
    <input type="file" name="residential_proofs[]" multiple class="form-control">
    @if(!empty($user->residential_proofs))
      <div class="row mt-2">
        @foreach($user->residential_proofs as $file)
          <div class="col-md-2">
            <div class="card">
              <div class="card-body">
                <a href="javascript:void(0)" onclick="previewFile('{{ asset('storage/'.$file) }}')">View</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
<div class="mt-3 row">
    <div class="col-md-6">
        <label>State</label>
        <select name="state" id="state" class="form-control" required>
            <option value="">Select State</option>
            <option value="Gujarat" {{ old('state', $user->state) == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
            <option value="Maharashtra" {{ old('state', $user->state) == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
            <!-- Add more -->
        </select>
        @error('state') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label>City</label>
        <select name="city" id="city" class="form-control" required>
            <option value="">Select City</option>
            <option value="Ahmedabad" {{ old('city', $user->city) == 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
            <option value="Surat" {{ old('city', $user->city) == 'Surat' ? 'selected' : '' }}>Surat</option>
            <option value="Mumbai" {{ old('city', $user->city) == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
        </select>
        @error('city') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>

  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
  </div>
</form>
@endsection
