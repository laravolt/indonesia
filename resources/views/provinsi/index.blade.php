@extends(
    config('laravolt.indonesia.view.layout'),
    [
        '__page' => [
            'title' => __('Provinsi'),
            'actions' => [
                [
                    'label' => __('Tambah'),
                    'class' => 'primary',
                    'icon' => 'icon plus circle',
                    'url' => route('indonesia::provinsi.create')
                ],
            ]
        ],
    ]
)

@section('content')
    {!! $table !!}
@endsection
