<?php

namespace App\Models;

use App\Classes\Core\Base;
use CodeIgniter\Model;
use stdClass;

class BaseModel extends Model
{
    protected $table            = '';
    protected $returnType    = 'object';
    protected $allowedFields = ["id", "created_at", "updated_at", "deleted_at"];
    protected $metaModel = null;
    protected  $objectClass = Base::class;
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function __construct($tableName, $objectClass = null)
    {
        if ($objectClass != null) $this->objectClass = $objectClass;

        $this->table = $tableName;
        $this->metaModel =  new BaseMetaModel($tableName);
        parent::__construct();
    }
    function fromId($object_id)
    {
        $where = ['id' => $object_id];
        $baseResponse = $this->where($where)->first();
        if ($baseResponse) {
            return (new $this->objectClass)->fromData($baseResponse);
        }
        return false;
    }
    function fromMeta($meta_key, $meta_value)
    {
        $metaResponse = $this->metaModel->where(["meta_key" => $meta_key, "meta_value" => $meta_value])->first();
        if ($metaResponse) {
            $baseResponse = $this->where(['id' => $metaResponse->object_id])->first();
            if ($baseResponse) {
                return (new $this->objectClass)->fromData($baseResponse);
            }
            return false;
        }
        return false;
    }

    function getAllMeta($object_id)
    {
        $response = $this->metaModel->where(["object_id" => $object_id])->findAll();
        return $response;
    }
    function getMeta($object_id, $meta_key)
    {
        $response = $this->metaModel->where(["object_id" => $object_id, "meta_key" => $meta_key])->first();
        return $response;
    }
}
