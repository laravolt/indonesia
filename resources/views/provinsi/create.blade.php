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
    @component('ui::components.panel', ['title' => __('Tambah Provinsi')])
        {!! form()->post(route('indonesia::provinsi.store')) !!}
        {!! form()->text('id')->label('Kode')->required() !!}
        {!! form()->text('name')->label('Name')->required() !!}
        {!! form()->action([
            form()->submit(__('Save')),
            form()->link(__('Cancel'), route('indonesia::provinsi.index'))
        ]) !!}
        {!! form()->close() !!}
    @endcomponent
@endsection
