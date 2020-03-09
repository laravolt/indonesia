<?php

namespace Laravolt\Indonesia\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Http\Requests\Kelurahan\Store;
use Laravolt\Indonesia\Http\Requests\Kelurahan\Update;
use Laravolt\Indonesia\Models\Extended\Kelurahan;
use Laravolt\Indonesia\Tables\KelurahanTable;

class KelurahanController extends Controller
{
    public function index()
    {
        $data = Kelurahan::with('kecamatan')->autoSort()->autoFilter()->search(request('search'))->paginate();

        return (new KelurahanTable($data))
            ->title(__('Daftar Desa/Kelurahan'))
            ->view('indonesia::kelurahan.index');
    }

    public function create()
    {
        return view('indonesia::kelurahan.create');
    }

    public function store(Store $request)
    {
        Kelurahan::create($request->validated());

        return redirect()->route('indonesia::kelurahan.index')->withSuccess('Kelurahan saved');
    }

    public function edit(Kelurahan $kelurahan)
    {
        return view('indonesia::kelurahan.edit', compact('kelurahan'));
    }

    public function update(Update $request, Kelurahan $kelurahan)
    {
        $kelurahan->update($request->validated());

        return redirect()->route('indonesia::kelurahan.edit', $kelurahan)->withSuccess('Kelurahan saved');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        try {
            $kelurahan->delete();

            return redirect()->route('indonesia::kelurahan.index')->withSuccess('Kelurahan deleted');
        } catch (QueryException $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
