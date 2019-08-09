@extends(config('laravolt.epicentrum.view.layout'))

@section('content')

    <div class="ui secondary menu">
        <div class="item">
            <h2>Edit Kecamatan</h2>
        </div>
        <div class="right menu">
            <div class="item">
                <a href="{{ route('indonesia::kecamatan.index') }}" class="ui button basic small"><i class="icon angle left"></i>
                    Back to index
                </a>
            </div>
        </div>
    </div>

    {!! form()->bind($kecamatan)->put(route('indonesia::kecamatan.update', $kecamatan))->multipart() !!}
    {!! form()->text('id')->label('Id') !!}
	{!! form()->text('name')->label('Name') !!}
    {!! form()->select('city_id', \Laravolt\Indonesia\Models\Kabupaten::pluck('name', 'id'))->label('Kabupaten') !!}
    {!! form()->action([
        form()->submit('Save'),
        form()->link('Cancel', route('indonesia::kecamatan.index'))
    ]) !!}
    {!! form()->close() !!}

@stop
