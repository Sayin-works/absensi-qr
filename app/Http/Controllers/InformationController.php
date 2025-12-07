<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        $infos = Information::latest()->paginate(10);
        return view('information.index', compact('infos'));
    }

    public function create()
    {
        return view('information.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'nullable|date',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('information_images', 'public');
    }

    Information::create($data);

    return redirect()->route('information.index')->with('success', 'Informasi berhasil ditambahkan.');
}
public function show($id)
{
    $info = \App\Models\Information::findOrFail($id);
    return view('information.show', compact('info'));
}


    public function edit(Information $information)
    {
        return view('information.edit', compact('information'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'nullable|date',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $info = Information::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('information_images', 'public');
    }

    $info->update($data);

    return redirect()->route('information.index')->with('success', 'Informasi berhasil diperbarui.');
}


    public function destroy(Information $information)
    {
        $information->delete();

        return redirect()->route('information.index')->with('success', 'Informasi berhasil dihapus');
    }
}
