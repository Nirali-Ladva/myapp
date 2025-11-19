@extends('layouts.app')

@section('content')
<h2>Edit Child: {{ $child->first_name }} {{ $child->last_name }}</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('children.update', $child->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Link Parents to Child:</label>
    <div class="mb-3">
        @forelse($parents as $parent)
            <div>
                <input type="checkbox" name="parents[]" value="{{ $parent->id }}"
                    @if($child->parents->contains($parent->id)) checked @endif
                >
                {{ $parent->first_name }} {{ $parent->last_name }} ({{ $parent->email }})
            </div>
        @empty
            <p>No parents available to link.</p>
        @endforelse
    </div>

    <button class="btn btn-success">Save Linked Parents</button>
</form>
@endsection
