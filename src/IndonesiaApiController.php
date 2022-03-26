<?php

namespace KodePandai\Indonesia;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use KodePandai\Indonesia\Models\Province;

class IndonesiaApiController extends Controller
{
    public function provinces(Request $request): JsonResponse|string
    {
        $query = Province::query();

        if(! config('response_include_latitude_longitude')) {
            $query->select('code', 'name');
        }

        if ($request->filled('search_by_name')) {
            $query->where('name', 'like', '%'.$request->search_by_name.'%');
        }

        $data = $request->paginate ? $query->paginate($request->per_page) : $query->get();

        return $request->as_html ? $this->responseAsHtml($data) : $this->responseAsJson($data);
    }

    protected function responseAsJson(mixed $data, bool $success = true, string $message = 'Success')
    {
        return response()->json([
            'data' => $data,
            'success' => $success,
            'message' => $message,
        ]);
    }

    protected function responseAsHtml(Collection|LengthAwarePaginator $data): string
    {
        return $data->map(function($item) {
            return '<option value="'.$item->code.'">'.$item->name.'</option>';
        })->implode('');
    }
}
