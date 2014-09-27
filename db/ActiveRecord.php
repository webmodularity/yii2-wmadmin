<?php

namespace wma\db;

class ActiveRecord extends \yii\db\ActiveRecord
{

    /**
     * Takes a full AR model with an unset PK and returns AR result if record is found
     * @param array $attributes attributes to use in where clause
     * @return ActiveRecord|null null if no result found
     */

    public function findOneFromAttributes($attributes = []) {
        if (!is_array($attributes) || count($attributes) < 1) {
            // Defaults to all attributes except PK(s)
            $attributes = $this->getAttributes(null, $this->primaryKey());
            return $this->findOne($attributes);
        }
    }

}