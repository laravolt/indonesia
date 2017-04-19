<?php
namespace Laravolt\Indonesia\Controllers;

use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Models\City;

class CityController extends Controller
{
    public function all()
    {
        return City::all();
    }

    public function detail($id)
    {
        return City::find($id)->with(['districts'])->first();
    }
}
