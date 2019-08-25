@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Kota/Kabupaten'),
            'actions' => [
                [
                    'label' => __('Tambah'),
                    'class' => 'primary',
                    'icon' => 'plus circle',
                    'url' => route('indonesia::kabupaten.create')
                ],
            ]
        ],
    ]
)

@section('content')
    {!! $table !!}
@endsection
