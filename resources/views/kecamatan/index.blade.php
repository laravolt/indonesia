@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Kecamatan'),
            'actions' => [
                [
                    'label' => __('Tambah'),
                    'class' => 'primary',
                    'icon' => 'icon plus circle',
                    'url' => route('indonesia::kecamatan.create')
                ],
            ]
        ],
    ]
)
@section('content')
    {!! $table !!}
@endsection
