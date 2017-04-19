<?php
namespace Laravolt\Indonesia\Controllers;

use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Models\Village;

class VillageController extends Controller
{
    public function all()
    {
        return Village::all();
    }

    public function detail($id)
    {
        return Village::find($id);
    }
}
