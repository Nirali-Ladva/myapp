<?php
namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ChildController extends Controller
{
    public function index()
    {
        $children = Child::paginate(20);
        return view('children.index', compact('children'));
    }
        
    public function create()
    {
        $parents = ParentModel::all();
        return view('children.create', compact('parents'));
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
            'birth_certificate'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'parents'=>'nullable|array'
        ]);

        if (!empty($data['birth_date'])) {
            $data['age'] = Carbon::parse($data['birth_date'])->age;
        }

        if ($request->hasFile('birth_certificate')) {
            $data['birth_certificate'] = $request->file('birth_certificate')->store('children/birth_certificates','public');
        }

        $child = Child::create($data);

        if (!empty($data['parents'])) {
            $child->parents()->attach($data['parents']);
            foreach ($data['parents'] as $parentId) {
                dispatch(new \App\Jobs\NotifyParentJob($parentId, $child->id))->delay(now()->addMinutes(5));
            }
        }

        return redirect()->route('children.index')->with('success','Child added.');
    }

        
// ChildController.php
public function edit(Child $child)
{
    $parents = ParentModel::all();
    return view('children.edit', compact('child', 'parents'));
}

    public function update(Request $request, Child $child)
    {
        $data = $request->validate([
            'first_name'=>'required|string',
            'last_name'=>'nullable|string',
            'email'=>'nullable|email',
            'country'=>'nullable|string',
            'birth_date'=>'nullable|date',
            'state'=>'nullable|string',
            'city'=>'nullable|string',
            'birth_certificate'=>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'parents'=>'nullable|array'
        ]);

        if (!empty($data['birth_date'])) {
            $data['age'] = Carbon::parse($data['birth_date'])->age;
        }

        if ($request->hasFile('birth_certificate')) {
            if ($child->birth_certificate) Storage::disk('public')->delete($child->birth_certificate);
            $data['birth_certificate'] = $request->file('birth_certificate')->store('children/birth_certificates','public');
        }

        $child->update($data);

        if (isset($data['parents'])) {
            $child->parents()->sync($data['parents']);
            foreach ($data['parents'] as $parentId) {
                dispatch(new \App\Jobs\NotifyParentJob($parentId, $child->id))->delay(now()->addMinutes(5));
            }
        }

        return back()->with('success','Child updated.');
    }
public function show(Child $child)
{
    // Optional: redirect somewhere if you don't need a show page
    return redirect()->route('children.index');
}

   public function destroy($id)
{
    $child = Child::findOrFail($id);
    $child->delete();

    return redirect()->back()->with('success', 'Child deleted successfully.');
}

}
