<?php

namespace phalouvas\Httpquery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    /**
     * Count a table
     *
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function query(Request $request) {
        $validated = $this->validate($request, [
            'connection' => ['string', 'required'],
            'statement' => ['string', 'required'],
        ]);
        return response(DB::connection($validated['connection'])->select(DB::raw($validated['statement'])));
    }

}
