<?php

namespace App\Classes\Core;

use App\Classes\Core\BaseMeta;
use stdClass;

class Base
{
    public $id;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    protected $baseModel = null;
    protected bool $hasMeta = false;
    protected $metaObject = BaseMeta::class;

    function fromData($data)
    {
        $instance = get_class($this);
        $base = new $instance;
        $base->load($data);
        return $base;
    }
    function isRemoved()
    {
        if ($this->deleted_at != null) return true;
        return false;
    }
    function load($data)
    {
        $this->id = $data->id;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->deleted_at = $data->deleted_at;
        if ($this->hasMeta) {
            $this->metas = new stdClass();
            foreach ($this->baseModel->getAllMeta($this->id) as  $value) {
                $meta_key = $value->meta_key;
                $this->metas->$meta_key = $this->metaObject::fromData($value, $this->metaObject);
            }
        }
    }
    function getMeta($meta_key)
    {
        $data = $this->baseModel->getMeta($this->id, $meta_key);
        if ($data) return $this->metaObject::fromData($data);
        return false;
    }

    function addMeta($meta_key, $meta_value, $isNotExistAdd = false)
    {
        $meta = new $this->metaObject;
        $meta->meta_key = $meta_key;
        $meta->meta_value = $meta_value;
        $this->baseModel->metaModel->addMeta($this->id, $meta, $isNotExistAdd);
    }

    function removeMeta($meta_key)
    {
        $this->baseModel->metaModel->removeMeta($this->id, $meta_key);
    }

    function getData()
    {
        $data = new stdClass();
        if ($this->id != null) $data->id = $this->id;
        return $data;
    }
    function save($newData = [])
    {
        $data = $this->getData();
        foreach ($newData as $key => $value) {
            $data->$key = $value;
        }
        if ($this->id != null) {
            $this->update($data);
        }
        $this->insert($data);
    }
    function update($data)
    {
        $data->updated_at = strtotime(date("d-m-y h:i:s"));
        $id = $this->baseModel->update($data->id, $data);
        return $id;
    }
    function insert($data)
    {
        $data->created_at = strtotime(date("d-m-y h:i:s"));
        $id = $this->baseModel->insert($data);
        return $id;
    }
    function remove()
    {
        $data = new stdClass();
        $data->deleted_at = strtotime(date("d-m-y h:i:s"));
        $this->baseModel->update($this->id, $data);
    }
}
