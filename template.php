<?php
/**
 * This is the model class for table "__SCHEMAPREFIXANDTABLENAME__".
 *
 * The followings are the available columns in table '__SCHEMAPREFIXANDTABLENAME__':
__HEADERCOLUMNLIST__
 *
 * The followings are the available model relations:
__HEADERRELATIONLIST__
 */
class __CLASSNAME__ extends __BASEPARENTCLASSNAME__ {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return __CLASSNAME_ the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '__SCHEMAPREFIXANDTABLENAME__';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
__RULES__
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
__RELATIONS__
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return [
__LABELS__
        ];
    }
}