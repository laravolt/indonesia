@extends(config('laravolt.epicentrum.view.layout'))

@section('content')

    <div class="ui secondary menu">
        <div class="item">
            <h2>Edit Kabupaten/Kota</h2>
        </div>
        <div class="right menu">
            <div class="item">
                <a href="{{ route('indonesia::kabupaten.index') }}" class="ui button basic small"><i class="icon angle left"></i>
                    Back to index
                </a>
            </div>
        </div>
    </div>

    {!! form()->bind($kabupaten)->put(route('indonesia::kabupaten.update', $kabupaten))->multipart() !!}
    {!! form()->text('id')->label('Id') !!}
	{!! form()->text('name')->label('Name') !!}
    {!! form()->select('province_id', \Laravolt\Indonesia\Models\Provinsi::pluck('name', 'id'))->label('Provinsi') !!}
    {!! form()->action([
        form()->submit('Save'),
        form()->link('Cancel', route('indonesia::kabupaten.index'))
    ]) !!}
    {!! form()->close() !!}

@stop
