<?php

class CityController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'city';

	public $province;

	public function lookupdata()
	{
	  $this->province=new Province('searchwstatus');
	  $this->province->unsetAttributes();  // clear any default values
	  if(isset($_GET['Province']))
		$this->province->attributes=$_GET['Province'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
		$this->lookupdata();
		$model=new City;
		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				));
            Yii::app()->end();
        }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
      parent::actionUpdate();
	  $this->lookupdata();
	  $model=$this->loadModel($_POST['id']);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'cityid'=>$model->cityid,
				'provinceid'=>$model->provinceid,
				'provincename'=>($model->province!==null)?$model->province->provincename:"",
				'cityname'=>$model->cityname,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

       public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['City'], $_POST['City']['cityid']);
    }


	public function actionWrite()
	{
      parent::actionWrite();
	  if(isset($_POST['City']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['City']['provinceid'],'emptyprovincename','emptystring'),
                array($_POST['City']['cityname'],'emptycityname','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['City'];
          if ((int)$_POST['City']['cityid'] > 0)
          {
            $model=$this->loadModel($_POST['City']['cityid']);
			$this->olddata = $model->attributes;
			$this->useraction='update';
            $model->cityname = $_POST['City']['cityname'];
            $model->provinceid = $_POST['City']['provinceid'];
            $model->recordstatus = $_POST['City']['recordstatus'];
          }
          else
          {
            $model = new City();
            $model->attributes=$_POST['City'];
			$this->olddata = $model->attributes;
			$this->useraction='new';
          }
		  $this->newdata = $model->attributes;
          try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['City']['cityid']);
              $this->GetSMessage('cciinsertsuccess');
            }
            else
            {
              $this->GetMessage($model->getErrors());
            }
          }
          catch (Exception $e)
          {
            $this->GetMessage($e->getMessage());
          }
        }
	  }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		parent::actionDelete();
		$model=$this->loadModel($_POST['id']);
		  $model->recordstatus=0;
		  $model->save();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	protected function gridData($data,$row)
  {     
    $model = City::model()->findByPk($data->cityid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
	  $this->lookupdata();
	  $model=new City('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['City']))
			$model->attributes=$_GET['City'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'province'=>$this->province
		));
	}
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select provincename,cityname
				from city a 
				left join province b on b.provinceid = a.provinceid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.cityid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='City List';
		$this->pdf->AddPage('P');

		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(80,70));
		$this->pdf->colheader = array('Province','City');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['provincename'],$row1['cityname']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=City::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='city-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
