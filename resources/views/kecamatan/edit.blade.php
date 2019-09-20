@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Kecamatan'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Kecamatan'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::kecamatan.index')
                ],
            ]
        ],
    ]
)

@section('content')
    @component('ui::components.panel', ['title' => __('Edit Kecamatan')])
        {!! form()->bind($kecamatan)->put(route('indonesia::kecamatan.update', $kecamatan)) !!}
        {!! form()->hidden('previous_id')->value($kecamatan->getKey()) !!}
        {!! form()->text('id')->label('Kode')->required() !!}
        {!! form()->text('name')->label('Nama')->required() !!}
        {!! form()->select('city_id', \Laravolt\Indonesia\Models\Kabupaten::pluck('name', 'id'))->label('Kabupaten')->required() !!}
        {!! form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::kecamatan.index'))
        ]) !!}
        {!! form()->close() !!}
    @endcomponent
@endsection
