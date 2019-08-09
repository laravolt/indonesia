@extends(config('laravolt.epicentrum.view.layout'))

@section('content')

    <div class="ui secondary menu">
        <div class="item">
            <h2>Add Provinsi</h2>
        </div>
        <div class="right menu">
            <div class="item">
                <a href="{{ route('indonesia::provinsi.index') }}" class="ui button basic small"><i class="icon angle left"></i>
                    Back to index
                </a>
            </div>
        </div>
    </div>

    {!! form()->post(route('indonesia::provinsi.store'))->multipart() !!}
	{!! form()->text('id')->label('Id') !!}
	{!! form()->text('name')->label('Name') !!}
    {!! form()->action([
        form()->submit('Save'),
        form()->link('Cancel', route('indonesia::provinsi.index'))
    ]) !!}
    {!! form()->close() !!}

@stop
