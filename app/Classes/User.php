<?php

namespace App\Classes;

use App\Classes\Core\Base;
use App\Classes\UserMeta;
use App\Models\BaseModel;
use stdClass;

class User extends Base
{

    protected bool $hasMeta = true;
    protected $metaObject = UserMeta::class;
    function __construct()
    {
        $this->baseModel = new BaseModel("users");
    }

    static function new()
    {
        $newUser = new User();
        $newUser->save();
        return $newUser;
    }
}
