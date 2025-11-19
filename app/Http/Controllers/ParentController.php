<?php
namespace App\Http\Controllers;

use App\Models\ParentModel;
use App\Models\Child;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ParentController extends Controller
{
    public function index()
    {
        $parents = ParentModel::paginate(20);
        return view('parents.index', compact('parents'));
    }

    public function create()
    {
        $children = Child::all();
        return view('parents.create', compact('children'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'=>'required|string',
            'last_name'=>'nullable|string',
            'email'=>'nullable|email',
            'country'=>'nullable|string',
            'birth_date'=>'nullable|date',
            'state'=>'nullable|string',
            'city'=>'nullable|string',
            'profile_image'=>'nullable|image|max:2048',
            'residential_proofs.*'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'education'=>'nullable|string',
            'occupation'=>'nullable|string',
            'children'=>'nullable|array'
        ]);

        if (!empty($data['birth_date'])) {
            $data['age'] = Carbon::parse($data['birth_date'])->age;
        }

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('parents/profiles','public');
        }

        $proofs = [];
        if ($request->hasFile('residential_proofs')) {
            foreach ($request->file('residential_proofs') as $file) {
                $proofs[] = $file->store('parents/residential','public');
            }
        }
        $data['residential_proofs'] = $proofs;

        $parent = ParentModel::create($data);

        if (!empty($data['children'])) {
            $parent->children()->attach($data['children']);
            foreach ($data['children'] as $childId) {
                dispatch(new \App\Jobs\NotifyParentJob($parent->id, $childId))->delay(now()->addMinutes(5));
            }
        }

        return redirect()->route('parents.index')->with('success','Parent added.');
    }

    public function edit(ParentModel $parent)
    {
        $related = $parent->children()->paginate(10);
        $children = Child::all();
        return view('parents.edit', compact('parent','related','children'));
    }

    public function update(Request $request, ParentModel $parent)
    {
        $data = $request->validate([
            'first_name'=>'required|string',
            'last_name'=>'nullable|string',
            'email'=>'nullable|email',
            'country'=>'nullable|string',
            'birth_date'=>'nullable|date',
            'state'=>'nullable|string',
            'city'=>'nullable|string',
            'profile_image'=>'nullable|image|max:2048',
            'residential_proofs.*'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'education'=>'nullable|string',
            'occupation'=>'nullable|string',
            'children'=>'nullable|array'
        ]);

        if (!empty($data['birth_date'])) {
            $data['age'] = Carbon::parse($data['birth_date'])->age;
        }

        if ($request->hasFile('profile_image')) {
            if ($parent->profile_image) Storage::disk('public')->delete($parent->profile_image);
            $data['profile_image'] = $request->file('profile_image')->store('parents/profiles','public');
        }

        $proofs = $parent->residential_proofs ?? [];
        if ($request->hasFile('residential_proofs')) {
            foreach ($request->file('residential_proofs') as $file) {
                $proofs[] = $file->store('parents/residential','public');
            }
        }
        $data['residential_proofs'] = $proofs;

        $parent->update($data);

        if (isset($data['children'])) {
            $parent->children()->sync($data['children']);
            foreach ($data['children'] as $childId) {
                dispatch(new \App\Jobs\NotifyParentJob($parent->id, $childId))->delay(now()->addMinutes(5));
            }
        }

        return back()->with('success','Parent updated.');
    }

   public function destroy(Request $request, $id = null) {
    if($id) {
        // Single delete
        ParentModel::findOrFail($id)->delete();
        return back()->with('success','Parent deleted.');
    }

    // Multiple delete
    $ids = $request->input('ids', []);
    if (empty($ids)) return back()->with('error','No parents selected.');
    ParentModel::whereIn('id', $ids)->delete();
    return back()->with('success','Selected parents deleted.');
}


    public function deleteProof(ParentModel $parent, Request $request)
    {
        $file = $request->input('file');
        $proofs = $parent->residential_proofs ?? [];
        if (in_array($file,$proofs)) {
            Storage::disk('public')->delete($file);
            $proofs = array_values(array_filter($proofs, fn($p)=> $p!=$file));
            $parent->residential_proofs = $proofs;
            $parent->save();
        }
        return back()->with('success','File deleted.');
    }
}
