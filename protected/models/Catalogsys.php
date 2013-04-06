<?php

/**
 * This is the model class for table "catalogsys".
 *
 * The followings are the available columns in table 'catalogsys':
 * @property integer $catalogsysid
 * @property integer $languageid
 * @property string $catalogname
 * @property string $catalogval
 * @property integer $recordstatus
 */
class Catalogsys extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Catalogsys the static model class
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
		return 'catalogsys';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('languageid, messagesid, catalogval, recordstatus', 'required'),
			array('languageid, recordstatus,messagesid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('catalogsysid, languageid, messagesid, catalogval, recordstatus', 'safe', 'on'=>'search'),
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
			'language' => array(self::BELONGS_TO, 'Language', 'languageid'),
			'messages' => array(self::BELONGS_TO, 'Messages', 'messagesid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catalogsysid' => 'Data',
			'languageid' => 'Language',
			'catalogval' => 'Catalog Value',
			'recordstatus' => 'Record Status',
			'messagesid'=>'Messages'
		);
	}
	
	private function comparedb($criteria)
	{
		if (isset($_GET['languagename']))
{
	$criteria->compare('language.languagename',$_GET['languagename'],true);
}
		if (isset($_GET['messagename']))
{
	$criteria->compare('messages.messagename',$_GET['messagename'],true);
}
		if (isset($_GET['catalogval']))
{
	$criteria->compare('catalogval',$_GET['catalogval'],true);
}
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
$criteria->with=array('language','messages');
$this->comparedb($criteria);
		$criteria->compare('catalogsysid',$this->catalogsysid);
		$criteria->compare('language.languagename',$this->languageid,true);
		$criteria->compare('catalogval',$this->catalogval,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('messages.messagename',$this->messagesid,true);

		return new CActiveDataProvider(get_class($this), array(
						'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	public function GetCatalog($menuname)
  {
    $menu = Catalogsys::model()->findbysql("select catalogval ".
		" from catalogsys a ".
		" inner join useraccess b on b.languageid = a.languageid ".
		" inner join messages c on c.messagesid = a.messagesid ".
		" where lower(c.messagename) = lower('".$menuname."') and lower(b.username) = lower('". Yii::app()->user->id ."')");
    if ($menu != null)
    {
      return  $menu->catalogval;
    }
    else 
    {
      return $menuname;
    }
  }
}