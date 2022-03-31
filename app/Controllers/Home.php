<?php

namespace App\Controllers;

use App\Classes\User;
use App\Models\BaseModel;
use stdClass;

class Home extends BaseController
{
    private $userModel;

    function __construct()
    {
        $this->userModel = new BaseModel("users", User::class);
    }
    public function index()
    {
    }
}
