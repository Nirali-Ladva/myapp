<form method="POST" action="{{ route('children.store') }}" enctype="multipart/form-data">
@csrf

<label>First Name</label>
<input name="first_name" value="{{ old('first_name') }}" class="form-control">

<label>Last Name</label>
<input name="last_name" value="{{ old('last_name') }}" class="form-control">

<label>Birth Date</label>
<input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">

<label>Parents</label>
@foreach($parents as $parent)
    <div>
        <input type="checkbox" name="parents[]" value="{{ $parent->id }}"> {{ $parent->first_name }} {{ $parent->last_name }}
    </div>
@endforeach

<button type="submit">Save</button>
</form>
