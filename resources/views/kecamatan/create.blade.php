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
    @component('ui::components.panel', ['title' => __('Tambah Kecamatan')])
        {!! form()->post(route('indonesia::kecamatan.store')) !!}
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
