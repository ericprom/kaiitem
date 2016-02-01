<?php


/**
 * Description of JSONUtil
 *
 * @author
 */

namespace app\commands;


class JSONUtil {
    public static function encode($models, array $filterAttributes = null,array $ignoreRelations=array()) {
        $array = self::convertModelToArray($models, $filterAttributes, $ignoreRelations);
        return JSON::encode($array);
    }
     /**
     * Converting a Yii model with all relations to a an array.
     * @param mixed $models A single model or an array of models for converting to array.
     * @param array $filterAttributes should be like array('table name'=>'column names','user'=>'id,firstname,lastname'
     * 'comment'=>'*') to filter attributes.
     * @param array $ignoreRelations an array contains the model names in relations that will not be converted to array
     * @return array array of converted model with all related relations.
     */


    public static function convertModelToArray($models, array $filterAttributes = null,array $ignoreRelations=array()) {
        if((!is_array($models))&&(is_null($models))) return null;

        if (is_array($models))
            $arrayMode = TRUE;
        else {
            $models = array($models);
            $arrayMode = FALSE;
        }

        $result = array();
        foreach ($models as $model) {
            $attributes = $model->getAttributes();

            if (isset($filterAttributes) && is_array($filterAttributes)) {
                foreach ($filterAttributes as $key => $value) {

                    if (strtolower($key) == strtolower($model->tableName())) {
                        $value = str_replace(' ', '', $value);
                        $arrColumn = explode(",", $value);

                        if (strpos($value, '*') === FALSE) {
                            $attributes = array();
                        }

                        foreach ($arrColumn as $column) {
                            if (($column!='')&&($column != '*')) {
                                $attributes[$column] = $model->$column;
                            }
                        }
                        //foreach ($attributes as $key => $value) {
                        //if (!in_array($key, $arrColumn))
                        //unset($attributes[$key]);
                        //}
                    }
                }
            }

            $relations = array();
            $key_ignores = array();

            if($modelClass = get_class($model)){
                if(array_key_exists($modelClass,$ignoreRelations)){
                    $key_ignores = explode(',',$ignoreRelations[$modelClass]);
                }
            }

            foreach ($model->relations() as $key => $related) {

                if ($model->hasRelated($key)) {
                    if(!in_array($key,$key_ignores))
                            $relations[$key] = self::convertModelToArray($model->$key, $filterAttributes,$ignoreRelations);
                }
            }
            $all = array_merge($attributes, $relations);

            if ($arrayMode)
                array_push($result, $all);
            else
                $result = $all;
        }
        return $result;
    }
}
