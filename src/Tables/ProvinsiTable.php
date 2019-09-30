<?php

namespace Laravolt\Indonesia\Tables;

use Laravolt\Suitable\Columns\Numbering;

class ProvinsiTable extends \Laravolt\Suitable\TableView
{
    protected function columns()
    {
        return [
            Numbering::make('No'),
            \Laravolt\Suitable\Columns\Id::make('id', 'Kode')->sortable(),
            \Laravolt\Suitable\Columns\Text::make('name', 'Provinsi')->sortable(),
            \Laravolt\Suitable\Columns\RestfulButton::make('indonesia::provinsi', __('Action'))->except('view'),
        ];
    }
}
