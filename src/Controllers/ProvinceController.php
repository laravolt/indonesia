<?php
namespace Laravolt\Indonesia\Controllers;

use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Models\Province;

class ProvinceController extends Controller
{
    public function all()
    {
        return Province::all();
    }

    public function detail($id)
    {
        return Province::find($id)->with(['cities'])->first();
    }
}
