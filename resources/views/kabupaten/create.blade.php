@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Kota/Kabupaten'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Kota/Kabupaten'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::kabupaten.index')
                ],
            ]
        ],
    ]
)

@section('content')
    @component('ui::components.panel', ['title' => __('Tambah Kabupaten/Kota')])
        {!! form()->post(route('indonesia::kabupaten.store')) !!}
        {!! form()->text('id')->label('Kode')->required() !!}
        {!! form()->text('name')->label('Name')->required() !!}
        {!! form()->select('province_id', \Laravolt\Indonesia\Models\Provinsi::pluck('name', 'id'))->label('Provinsi')->required() !!}
        {!! form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::kabupaten.index'))
        ]) !!}
        {!! form()->close() !!}
    @endcomponent
@stop
