<?php

namespace App\Services;
use App\Repositories\ParamRepository;
class OperationService
{

    public ParamRepository $_paramRepository;
    public function __construct(ParamRepository $paramRepository)
    {
        $this->_paramRepository = $paramRepository;
    }
    //
}
