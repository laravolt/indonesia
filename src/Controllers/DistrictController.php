<?php
namespace Laravolt\Indonesia\Controllers;

use Illuminate\Routing\Controller;
use Laravolt\Indonesia\Models\District;

class DistrictController extends Controller
{
    public function all()
    {
        return District::all();
    }

    public function detail($id)
    {
        return District::find($id)->with(['villages'])->first();
    }
}
