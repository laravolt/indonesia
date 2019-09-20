@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Provinsi'),
            'actions' => [
                [
                    'label' => __('Lihat Semua Provinsi'),
                    'class' => '',
                    'icon' => '',
                    'url' => route('indonesia::provinsi.index')
                ],
            ]
        ],
    ]
)

@section('content')
    @component('ui::components.panel', ['title' => __('Edit Provinsi')])
        {!! form()->bind($provinsi)->put(route('indonesia::provinsi.update', $provinsi)) !!}
        {!! form()->hidden('previous_id')->value($provinsi->getKey()) !!}
        {!! form()->text('id')->label('Kode')->required() !!}
        {!! form()->text('name')->label('Name')->required() !!}
        {!! form()->action([
            form()->submit('Save'),
            form()->link('Cancel', route('indonesia::provinsi.index'))
        ]) !!}
        {!! form()->close() !!}
    @endcomponent
@endsection
