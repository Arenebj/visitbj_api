<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamService;

class EventController extends Controller
{
    protected ParamService $_paramService;
    public function __construct(ParamService $paramService)
    {
        $this->_paramService = $paramService;
    }

}
