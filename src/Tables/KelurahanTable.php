<?php

namespace Laravolt\Indonesia\Tables;

use Laravolt\Suitable\Columns\Numbering;

class KelurahanTable extends \Laravolt\Suitable\TableView
{
    protected function columns()
    {
        return [
            Numbering::make('No'),
            \Laravolt\Suitable\Columns\Id::make('id', 'Kode')->sortable(),
            \Laravolt\Suitable\Columns\Text::make('name', 'Desa/Kelurahan')->sortable(),
            \Laravolt\Suitable\Columns\Text::make('kecamatan.name', 'Kecamatan')->sortable('kecamatan.name'),
            \Laravolt\Suitable\Columns\RestfulButton::make('indonesia::kelurahan', __('Action'))->except('view'),
        ];
    }
}
