<?php

namespace Laravolt\Indonesia\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Http\Requests\Kelurahan\Store;
use Laravolt\Indonesia\Http\Requests\Kelurahan\Update;
use Laravolt\Indonesia\Models\Kelurahan;
use Laravolt\Indonesia\Tables\KelurahanTable;
use Laravolt\Suitable\Builder;
use Laravolt\Suitable\Toolbars\Action;

class KelurahanController extends Controller
{
    public function index()
    {
        $data = Kelurahan::autoSort()->autoFilter()->search(request('search'))->paginate();

        return (new KelurahanTable($data))
            ->decorate(function(Builder $table){
                $table->getDefaultSegment()
                    ->addLeft(
                        Action::make('plus', 'Tambah', route('indonesia::kelurahan.create'))
                            ->addClass('primary')
                    );
            })
            ->title(__('Kelurahan'))
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

        return redirect()->back()->withSuccess('Kelurahan saved');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();

        return redirect()->route('indonesia::kelurahan.index')->withSuccess('Kelurahan deleted');
    }
}
