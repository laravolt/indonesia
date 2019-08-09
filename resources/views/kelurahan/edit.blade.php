@extends(config('laravolt.epicentrum.view.layout'))

@section('content')

    <div class="ui secondary menu">
        <div class="item">
            <h2>Edit Kelurahan/Desa</h2>
        </div>
        <div class="right menu">
            <div class="item">
                <a href="{{ route('indonesia::kelurahan.index') }}" class="ui button basic small"><i class="icon angle left"></i>
                    Back to index
                </a>
            </div>
        </div>
    </div>

    {!! form()->bind($kelurahan)->put(route('indonesia::kelurahan.update', $kelurahan))->multipart() !!}
    {!! form()->text('id')->label('Id') !!}
	{!! form()->text('name')->label('Name') !!}
    {!! form()->select('district_id', \Laravolt\Indonesia\Models\Kecamatan::pluck('name', 'id'))->label('Kecamatan') !!}
    {!! form()->action([
        form()->submit('Save'),
        form()->link('Cancel', route('indonesia::kelurahan.index'))
    ]) !!}
    {!! form()->close() !!}

@stop
