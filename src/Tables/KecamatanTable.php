<?php

namespace Laravolt\Indonesia\Tables;

use Laravolt\Suitable\Columns\Numbering;

class KecamatanTable extends \Laravolt\Suitable\TableView
{
    protected function columns()
    {
        return [
            Numbering::make('No'),
            \Laravolt\Suitable\Columns\Id::make('id', 'Kode')->sortable(),
            \Laravolt\Suitable\Columns\Text::make('name', 'Kecamatan')->sortable(),
            \Laravolt\Suitable\Columns\Text::make('kabupaten.name', 'Kota/Kabupaten')->sortable('kabupaten.name'),
            \Laravolt\Suitable\Columns\RestfulButton::make('indonesia::kecamatan', __('Action'))->except('view'),
        ];
    }
}
