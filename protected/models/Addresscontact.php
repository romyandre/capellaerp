<?php

/**
 * This is the model class for table "addresscontact".
 *
 * The followings are the available columns in table 'addresscontact':
 * @property integer $addresscontactid
 * @property integer $contacttypeid
 * @property integer $addressbookid
 * @property string $addresscontactname
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Addressbook $addressbook
 * @property Contacttype $contacttype
 */
class Addresscontact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Addresscontact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'addresscontact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contacttypeid, addressbookid, addresscontactname, recordstatus', 'required'),
			array('contacttypeid, addressbookid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('addresscontactname', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('addresscontactid, contacttypeid, addressbookid, addresscontactname, recordstatus', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'addressbook' => array(self::BELONGS_TO, 'Addressbook', 'addressbookid'),
			'contacttype' => array(self::BELONGS_TO, 'Contacttype', 'contacttypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'addresscontactid' => 'Data',
			'contacttypeid' => 'Contact Type',
			'addressbookid' => 'Name ',
			'addresscontactname' => 'Address Contact',
			'recordstatus' => 'Record Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('addresscontactid',$this->addresscontactid);
		$criteria->compare('contacttypeid',$this->contacttypeid);
		$criteria->compare('addressbookid',$this->addressbookid);
		$criteria->compare('addresscontactname',$this->addresscontactname,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}