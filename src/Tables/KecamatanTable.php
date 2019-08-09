<?php

namespace Laravolt\Indonesia\Tables;

use Laravolt\Suitable\Columns\Numbering;

class KecamatanTable extends \Laravolt\Suitable\TableView
{
    protected function columns()
    {
        return [
            Numbering::make('No'),
            \Laravolt\Suitable\Columns\Id::make('id', 'Kode'),
            \Laravolt\Suitable\Columns\Text::make('name'),
            \Laravolt\Suitable\Columns\Text::make('city_name'),
            \Laravolt\Suitable\Columns\RestfulButton::make('indonesia::kecamatan')->except('view'),
        ];
    }
}
