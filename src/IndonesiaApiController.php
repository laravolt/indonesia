<?php

namespace KodePandai\Indonesia;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use KodePandai\Indonesia\Models\City;
use KodePandai\Indonesia\Models\District;
use KodePandai\Indonesia\Models\Province;
use KodePandai\Indonesia\Models\Village;

class IndonesiaApiController extends Controller
{
    /**
     * Get provinces data.
     */
    public function provinces(Request $request): JsonResponse|string
    {
        $query = Province::select(config('indonesia.api.reponse_columns.province'));

        return $this->getResponse($request, $query);
    }

    /**
     * Get cities data.
     */
    public function cities(Request $request): JsonResponse|string
    {
        $query = City::select(config('indonesia.api.reponse_columns.city'));

        if ($request->filled('province_code')) {
            $query->where('province_code', $request->province_code);
        }

        if ($request->filled('province_name')) {
            $query->whereRelation('province', 'name', $request->province_name);
        }

        return $this->getResponse($request, $query);
    }

    /**
     * Get districts data.
     */
    public function districts(Request $request): JsonResponse|string
    {
        $query = District::select(config('indonesia.api.reponse_columns.district'));

        if ($request->filled('city_code')) {
            $query->where('city_code', $request->city_code);
        }

        if ($request->filled('city_name')) {
            $query->whereRelation('city', 'name', $request->city_name);
        }

        return $this->getResponse($request, $query);
    }

    /**
     * Get villages data.
     */
    public function villages(Request $request): JsonResponse|string
    {
        //
        if (empty($request->district_code) && empty($request->district_name)) {
            //.
            $message = 'Parameter district_code or district_name is required';
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;

            return $this->responseAsJson(null, false, $message, $status);
        }

        $query = Village::select(config('indonesia.api.reponse_columns.village'));

        if ($request->filled('district_code')) {
            $query->where('district_code', $request->district_code);
        }

        if ($request->filled('district_name')) {
            $query->whereRelation('district', 'name', $request->district_name);
        }

        return $this->getResponse($request, $query);
    }

    /**
     * Get response as JSON or as HTML options.
     */
    protected function getResponse(Request $request, Builder $query): string|JsonResponse
    {
        $data = $query->get();

        return $request->as_html
            ? $this->responseAsHtml($data) : $this->responseAsJson($data);
    }

    /**
     * Generate response as json.
     */
    protected function responseAsJson(
        mixed $data,
        bool $success = true,
        string $message = 'Success',
        int $status = Response::HTTP_OK
    ): JsonResponse {
        return response()->json(compact('data', 'success', 'message'), $status);
    }

    /**
     * Generate response as html options.
     */
    protected function responseAsHtml(Collection $data): string
    {
        return $data->map(function ($item) {
            return '<option value="' . $item->code . '">' . $item->name . '</option>';
        })->implode('');
    }
}
