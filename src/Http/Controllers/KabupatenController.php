<?php

namespace Laravolt\Indonesia\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Http\Requests\Kabupaten\Store;
use Laravolt\Indonesia\Http\Requests\Kabupaten\Update;
use Laravolt\Indonesia\Models\Extended\Kabupaten;
use Laravolt\Indonesia\Tables\KabupatenTable;

class KabupatenController extends Controller
{
    public function index()
    {
        $data = Kabupaten::with('province')->autoSort()->autoFilter()->search(request('search'))->paginate();

        return (new KabupatenTable($data))
            ->title(__('Daftar Kota/Kabupaten'))
            ->view('indonesia::kabupaten.index');
    }

    public function create()
    {
        return view('indonesia::kabupaten.create');
    }

    public function store(Store $request)
    {
        Kabupaten::create($request->validated());

        return redirect()->route('indonesia::kabupaten.index')->withSuccess('Kabupaten saved');
    }

    public function edit(Kabupaten $kabupaten)
    {
        return view('indonesia::kabupaten.edit', compact('kabupaten'));
    }

    public function update(Update $request, Kabupaten $kabupaten)
    {
        $kabupaten->update($request->validated());

        return redirect()->route('indonesia::kabupaten.edit', $kabupaten)->withSuccess('Kabupaten saved');
    }

    public function destroy(Kabupaten $kabupaten)
    {
        try {
            $kabupaten->delete();

            return redirect()->route('indonesia::kabupaten.index')->withSuccess('Kabupaten deleted');
        } catch (QueryException $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
