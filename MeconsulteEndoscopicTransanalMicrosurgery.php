<?php
/**
 * This is the model class for table "protected.meconsulte_endoscopic_transanal_microsurgery".
 *
 * The followings are the available columns in table 'protected.meconsulte_endoscopic_transanal_microsurgery':
 * id
 * interaction_id
 * diagnosis
 * diagnosis_cid10
 * colonoscopy
 * colonoscopy_observations
 * ultrasound_endoanal
 * ultrasound_endoanal_observations
 * magnetic_resonance_of_pelvis
 * magnetic_resonance_of_pelvis_observations
 * tumour_position_of_wall_letal_lesion
 * tumour_dimension_width
 * tumour_dimension_length
 * tumour_dimension_percent_of_rectal_circumference
 * tumour_dimension_area
 * anesthesia_type
 * preparation_of_the_colon
 * preparation_of_the_colon_text
 * antibiotic_therapy
 * antibiotic_therapy_which
 * intraoperative_complications
 * conversion
 * conversion_cause
 * conversion_for
 * conversion_for_observations
 * operation
 * closure_of_the_wall
 * running_suture
 * operation_duration
 * postoperative_complications
 * postoperative_complications_description
 * hospitalization_duration
 * surgical_specimen_fragmentation
 * surgical_specimen_resection_margins
 * pinned_surgical_specimen_longitudinal_diameter
 * pinned_surgical_specimen_transversal_diameter
 * pinned_surgical_specimen_wall_thickness
 * pinned_surgical_specimen_margins
 * pinned_surgical_histopathological_diagnosis
 * rectosigmoidoscopy_duration
 * colonoscopy_duration
 * colonoscopy_every_5_years
 * local_recurrence
 * local_recurrence_duration
 * local_recurrence_treatment_type
 * at_distance_recurrence
 * at_distance_recurrence_duration
 * at_distance_recurrence_position
 * at_distance_recurrence_treatment_type
 *
 * The followings are the available model relations:
headerRelationList
 */
class MeconsulteEndoscopicTransanalMicrosurgery extends MyActiveRecord {
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
        return 'protected.meconsulte_endoscopic_transanal_microsurgery';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['tumour_dimension_percent_of_rectal_circumference, tumour_dimension_area', 'ext.validators.CLocaleNumberValidator', 'integerOnly' => false],
            ['surgical_specimen_fragmentation', 'in', 'range' => ['1', '2', '3', '4']],
            ['colonoscopy, ultrasound_endoanal, magnetic_resonance_of_pelvis, antibiotic_therapy, intraoperative_complications, conversion, closure_of_the_wall, running_suture, postoperative_complications, colonoscopy_every_5_years, local_recurrence, at_distance_recurrence', 'in', 'range' => ['yes', 'no']],
            ['preparation_of_the_colon', 'in', 'range' => ['yes_washing', 'no_manitol', 'another']],
            ['id, interaction_id, diagnosis_cid10, tumour_dimension_width, tumour_dimension_length, operation_duration, hospitalization_duration, pinned_surgical_specimen_longitudinal_diameter, pinned_surgical_specimen_transversal_diameter, pinned_surgical_specimen_wall_thickness, local_recurrence_duration, at_distance_recurrence_duration', 'numerical', 'integerOnly' => true],
            ['anesthesia_type', 'in', 'range' => ['general anaesthetic', 'epidural anesthesia', 'rachianesthesia']],
            ['rectosigmoidoscopy_duration', 'in', 'range' => ['6 months', '18 months', '24 months', '36 months']],
            ['colonoscopy_duration', 'in', 'range' => ['12 months', '48 months']],
            ['operation', 'in', 'range' => ['mucosectomy', 'full thickness excision', 'mesorretal excision']],
            ['diagnosis, colonoscopy_observations, ultrasound_endoanal_observations, magnetic_resonance_of_pelvis_observations, preparation_of_the_colon_text, antibiotic_therapy_which, conversion_cause, conversion_for_observations, postoperative_complications_description, pinned_surgical_histopathological_diagnosis, local_recurrence_treatment_type, at_distance_recurrence_position, at_distance_recurrence_treatment_type', 'safe'],
            ['pinned_surgical_specimen_margins', 'in', 'range' => ['positive-complete', 'negative-complete', 'undefined']],
            ['conversion_for', 'in', 'range' => ['regular', 'laparoscopic', 'transanal', 'posterior access']],
            ['tumour_position_of_wall_letal_lesion', 'in', 'range' => ['anterior', 'posterior', 'left-side', 'right-side', 'circular']],
            ['surgical_specimen_resection_margins', 'in', 'range' => ['positive', 'negative']],

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
            'id' => Yii::t('patient', 'id'),
            'interaction_id' => Yii::t('patient', 'interaction id'),
            'diagnosis' => Yii::t('patient', 'diagnosis'),
            'diagnosis_cid10' => Yii::t('patient', 'diagnosis cid10'),
            'colonoscopy' => Yii::t('patient', 'colonoscopy'),
            'colonoscopy_observations' => Yii::t('patient', 'colonoscopy observations'),
            'ultrasound_endoanal' => Yii::t('patient', 'ultrasound endoanal'),
            'ultrasound_endoanal_observations' => Yii::t('patient', 'ultrasound endoanal observations'),
            'magnetic_resonance_of_pelvis' => Yii::t('patient', 'magnetic resonance of pelvis'),
            'magnetic_resonance_of_pelvis_observations' => Yii::t('patient', 'magnetic resonance of pelvis observations'),
            'tumour_position_of_wall_letal_lesion' => Yii::t('patient', 'tumour position of wall letal lesion'),
            'tumour_dimension_width' => Yii::t('patient', 'tumour dimension width'),
            'tumour_dimension_length' => Yii::t('patient', 'tumour dimension length'),
            'tumour_dimension_percent_of_rectal_circumference' => Yii::t('patient', 'tumour dimension percent of rectal circumference'),
            'tumour_dimension_area' => Yii::t('patient', 'tumour dimension area'),
            'anesthesia_type' => Yii::t('patient', 'anesthesia type'),
            'preparation_of_the_colon' => Yii::t('patient', 'preparation of the colon'),
            'preparation_of_the_colon_text' => Yii::t('patient', 'preparation of the colon text'),
            'antibiotic_therapy' => Yii::t('patient', 'antibiotic therapy'),
            'antibiotic_therapy_which' => Yii::t('patient', 'antibiotic therapy which'),
            'intraoperative_complications' => Yii::t('patient', 'intraoperative complications'),
            'conversion' => Yii::t('patient', 'conversion'),
            'conversion_cause' => Yii::t('patient', 'conversion cause'),
            'conversion_for' => Yii::t('patient', 'conversion for'),
            'conversion_for_observations' => Yii::t('patient', 'conversion for observations'),
            'operation' => Yii::t('patient', 'operation'),
            'closure_of_the_wall' => Yii::t('patient', 'closure of the wall'),
            'running_suture' => Yii::t('patient', 'running suture'),
            'operation_duration' => Yii::t('patient', 'operation duration'),
            'postoperative_complications' => Yii::t('patient', 'postoperative complications'),
            'postoperative_complications_description' => Yii::t('patient', 'postoperative complications description'),
            'hospitalization_duration' => Yii::t('patient', 'hospitalization duration'),
            'surgical_specimen_fragmentation' => Yii::t('patient', 'surgical specimen fragmentation'),
            'surgical_specimen_resection_margins' => Yii::t('patient', 'surgical specimen resection margins'),
            'pinned_surgical_specimen_longitudinal_diameter' => Yii::t('patient', 'pinned surgical specimen longitudinal diameter'),
            'pinned_surgical_specimen_transversal_diameter' => Yii::t('patient', 'pinned surgical specimen transversal diameter'),
            'pinned_surgical_specimen_wall_thickness' => Yii::t('patient', 'pinned surgical specimen wall thickness'),
            'pinned_surgical_specimen_margins' => Yii::t('patient', 'pinned surgical specimen margins'),
            'pinned_surgical_histopathological_diagnosis' => Yii::t('patient', 'pinned surgical histopathological diagnosis'),
            'rectosigmoidoscopy_duration' => Yii::t('patient', 'rectosigmoidoscopy duration'),
            'colonoscopy_duration' => Yii::t('patient', 'colonoscopy duration'),
            'colonoscopy_every_5_years' => Yii::t('patient', 'colonoscopy every 5 years'),
            'local_recurrence' => Yii::t('patient', 'local recurrence'),
            'local_recurrence_duration' => Yii::t('patient', 'local recurrence duration'),
            'local_recurrence_treatment_type' => Yii::t('patient', 'local recurrence treatment type'),
            'at_distance_recurrence' => Yii::t('patient', 'at distance recurrence'),
            'at_distance_recurrence_duration' => Yii::t('patient', 'at distance recurrence duration'),
            'at_distance_recurrence_position' => Yii::t('patient', 'at distance recurrence position'),
            'at_distance_recurrence_treatment_type' => Yii::t('patient', 'at distance recurrence treatment type'),
        ];
    }
}