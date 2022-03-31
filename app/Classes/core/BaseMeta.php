<?php

namespace App\Classes\Core;

use stdClass;

class BaseMeta
{
    public $id;
    public $object_id;
    public $meta_key;
    public $meta_value;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    function getValue()
    {
        return  $this->meta_value;
    }
    function setValue($value)
    {
        $this->meta_value = $value;
    }

    function save()
    {
    }
    static function fromData($data = [], $metaObject = BaseMeta::class): BaseMeta
    {
        $meta = new $metaObject;
        $meta->data = new stdClass();
        foreach ($data as $key => $value) {
            $meta->$key = $value;
        }
        return $meta;
    }

    static function new($data)
    {
    }

    function data()
    {
        $data = [
            "object_id" => $this->object_id,
            "meta_key" => $this->meta_key,
            "meta_value" => $this->meta_value,
        ];
        if ($this->id != null) $data['id'] = $this->id;
        if ($this->created_at != null) $data['created_at'] = $this->created_at;
        if ($this->updated_at != null) $data['updated_at'] = $this->updated_at;
        if ($this->deleted_at != null) $data['deleted_at'] = $this->deleted_at;
        return $data;
    }
}
