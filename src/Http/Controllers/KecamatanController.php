<?php

namespace Laravolt\Indonesia\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Http\Requests\Kecamatan\Store;
use Laravolt\Indonesia\Http\Requests\Kecamatan\Update;
use Laravolt\Indonesia\Models\Extended\Kecamatan;
use Laravolt\Indonesia\Tables\KecamatanTable;

class KecamatanController extends Controller
{
    public function index()
    {
        $data = Kecamatan::with('kabupaten')->autoSort()->autoFilter()->search(request('search'))->paginate();

        return (new KecamatanTable($data))
            ->title(__('Daftar Kecamatan'))
            ->view('indonesia::kecamatan.index');
    }

    public function create()
    {
        return view('indonesia::kecamatan.create');
    }

    public function store(Store $request)
    {
        Kecamatan::create($request->validated());

        return redirect()->route('indonesia::kecamatan.index')->withSuccess('Kecamatan saved');
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('indonesia::kecamatan.edit', compact('kecamatan'));
    }

    public function update(Update $request, Kecamatan $kecamatan)
    {
        $kecamatan->update($request->validated());

        return redirect()->route('indonesia::kecamatan.edit', $kecamatan)->withSuccess('Kecamatan saved');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        try {
            $kecamatan->delete();

            return redirect()->route('indonesia::kecamatan.index')->withSuccess('Kecamatan deleted');
        } catch (QueryException $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
