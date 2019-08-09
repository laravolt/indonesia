<?php

namespace Laravolt\Indonesia\Tables;

use Laravolt\Suitable\Columns\Numbering;

class KelurahanTable extends \Laravolt\Suitable\TableView
{
    protected function columns()
    {
        return [
            Numbering::make('No'),
            \Laravolt\Suitable\Columns\Id::make('id', 'Kode'),
            \Laravolt\Suitable\Columns\Text::make('name'),
            \Laravolt\Suitable\Columns\Text::make('district_name'),
            \Laravolt\Suitable\Columns\RestfulButton::make('indonesia::kelurahan')->except('view'),
        ];
    }
}
