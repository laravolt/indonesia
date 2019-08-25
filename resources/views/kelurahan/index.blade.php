@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Desa/Kelurahan'),
            'actions' => [
                [
                    'label' => __('Tambah'),
                    'class' => 'primary',
                    'icon' => 'icon plus circle',
                    'url' => route('indonesia::kelurahan.create')
                ],
            ]
        ],
    ]
)

@section('content')
    {!! $table !!}
@endsection
