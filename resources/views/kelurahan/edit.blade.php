@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Desa/Kelurahan'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Desa/Kelurahan'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::kelurahan.index')
                ],
            ]
        ],
    ]
)

@section('content')
    @component('ui::components.panel', ['title' => __('Edit Desa/Kelurahan')])
        {!! form()->bind($kelurahan)->put(route('indonesia::kelurahan.update', $kelurahan)) !!}
        {!! form()->hidden('previous_id')->value($kelurahan->getKey()) !!}
        {!! form()->text('id')->label('Kode')->required() !!}
        {!! form()->text('name')->label('Nama Desa/Kelurahan')->required() !!}
        {!! form()->select('district_id', \Laravolt\Indonesia\Models\Kecamatan::pluck('name', 'id'))->label('Kecamatan')->required() !!}
        {!! form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::kelurahan.index'))
        ]) !!}
        {!! form()->close() !!}
    @endcomponent
@endsection
