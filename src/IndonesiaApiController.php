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
     *
     * @return JsonResponse|string
     */
    public function provinces(Request $request)
    {
        $query = Province::select(config('indonesia.api.response_columns.province'));

        return $this->getResponse($request, $query);
    }

    /**
     * Get cities data.
     *
     * @return JsonResponse|string
     */
    public function cities(Request $request)
    {
        $query = City::select(config('indonesia.api.response_columns.city'));

        if ($request->filled('province_code')) {
            $query->where('province_code', $request->province_code);
        }

        if ($request->filled('province_name')) {
            $query->whereHas('province', function ($sQuery) use ($request) {
                $sQuery->where('name', $request->province_name);
            });
        }

        return $this->getResponse($request, $query);
    }

    /**
     * Get districts data.
     *
     * @return JsonResponse|string
     */
    public function districts(Request $request)
    {
        $query = District::select(config('indonesia.api.response_columns.district'));

        if ($request->filled('city_code')) {
            $query->where('city_code', $request->city_code);
        }

        if ($request->filled('city_name')) {
            $query->whereHas('city', function ($sQuery) use ($request) {
                $sQuery->where('name', $request->city_name);
            });
        }

        return $this->getResponse($request, $query);
    }

    /**
     * Get villages data.
     *
     * @return JsonResponse|string
     */
    public function villages(Request $request)
    {
        //
        if (empty($request->district_code) && empty($request->district_name)) {
            //.
            $message = 'Parameter district_code or district_name is required';
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;

            return $this->responseAsJson(null, false, $message, $status);
        }

        $query = Village::select(config('indonesia.api.response_columns.village'));

        if ($request->filled('district_code')) {
            $query->where('district_code', $request->district_code);
        }

        if ($request->filled('district_name')) {
            $query->whereHas('district', function ($sQuery) use ($request) {
                $sQuery->where('name', $request->district_name);
            });
        }

        return $this->getResponse($request, $query);
    }

    /**
     * Get response as JSON or as HTML options.
     *
     * @return JsonResponse|string
     */
    protected function getResponse(Request $request, Builder $query)
    {
        $data = $query->get();

        return $request->as_html
            ? $this->responseAsHtml($data) : $this->responseAsJson($data);
    }

    /**
     * Generate response as json.
     *
     * @param mixed $data
     */
    protected function responseAsJson(
        $data,
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
