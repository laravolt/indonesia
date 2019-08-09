<?php

namespace Laravolt\Indonesia\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Http\Requests\Kecamatan\Store;
use Laravolt\Indonesia\Http\Requests\Kecamatan\Update;
use Laravolt\Indonesia\Models\Kecamatan;
use Laravolt\Indonesia\Tables\KecamatanTable;
use Laravolt\Suitable\Builder;
use Laravolt\Suitable\Toolbars\Action;

class KecamatanController extends Controller
{
    public function index()
    {
        $data = Kecamatan::autoSort()->autoFilter()->search(request('search'))->paginate();

        return (new KecamatanTable($data))
            ->decorate(function(Builder $table){
                $table->getDefaultSegment()
                    ->addLeft(
                        Action::make('plus', 'Tambah', route('indonesia::kecamatan.create'))
                            ->addClass('primary')
                    );
            })
            ->title(__('Kecamatan'))
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

        return redirect()->back()->withSuccess('Kecamatan saved');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('indonesia::kecamatan.index')->withSuccess('Kecamatan deleted');
    }
}
