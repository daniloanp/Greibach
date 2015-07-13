<?php
/**
 * This is the model class for table "schemaPrefixAndTableName".
 *
 * The followings are the available columns in table 'schemaPrefixAndTableName':
 * id
 * sender_user_id
 * receiver_user_id
 * message
 * datetime
 * was_read
 * attachment
 *
 * The followings are the available model relations:
headerRelationList
 */
class MeconsulteMessages extends MyActiveRecord {
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
        return 'schemaPrefixAndTableName';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['was_read', 'in', 'range' => ['yes', 'no']],
            ['message', 'safe'],
            ['id, sender_user_id, receiver_user_id, attachment', 'numerical', 'integerOnly' => true],
            ['datetime', 'safe'],

        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
relations
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return [
            'id' => 'id',
            'sender_user_id' => 'sender user id',
            'receiver_user_id' => 'receiver user id',
            'message' => 'message',
            'datetime' => 'datetime',
            'was_read' => 'was read',
            'attachment' => 'attachment',
        ];
    }
}