<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseMetaModel extends Model
{
    protected $table            = '';
    protected $returnType    = 'object';
    protected $allowedFields = ["meta_key", "meta_value", "object_id", "created_at", "updated_at", "deleted_at"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function __construct($tableName)
    {

        $this->table = "{$tableName}_meta";
        parent::__construct();
    }
    function isExists($object_id, $meta, $forceValue = false)
    {
        $where = [
            "object_id" => $object_id,
            "meta_key" => $meta->meta_key
        ];
        if ($meta->meta_value !== null && $forceValue) {
            $where['meta_value'] = $meta->meta_value;
        }
        return $this->where($where)->countAllResults() > 0 ? true : false;
    }
    function addMeta($object_id, $meta, $forceAdd = false)
    {
        $data = $meta->data();
        $data['object_id'] = $object_id;

        if (!$this->isExists($object_id, $meta)) {
            return $this->insert($data);
        }
        if ($forceAdd) {
            $where = [
                "object_id" => $object_id,
                "meta_key" => $meta->meta_key,
            ];
            if ($meta->id != null) {
                $where['id'] = $meta->id;
            }

            return $this->where($where)->update($meta->id, $data);
        }
        return 0;
    }

    function removeMeta($object_id, $meta_key)
    {
        return $this->where([
            "object_id" => $object_id,
            "meta_key" => $meta_key
        ])->delete();
    }
}
