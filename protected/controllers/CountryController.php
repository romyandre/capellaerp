<?php

class CountryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'country';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
		$model=new Country;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

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
	  $model=$this->loadModel($_POST['id']);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'countryid'=>$model->countryid,
				'countryname'=>$model->countryname,
				'countrycode'=>$model->countrycode,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Country'], $_POST['Country']['countryid']);
    }

	public function actionWrite()
	{
      parent::actionWrite();
	  if(isset($_POST['Country']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Country']['countrycode'],'emptycountrycode','emptystring'),
                array($_POST['Country']['countryname'],'emptycountryname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Country'];
		if ((int)$_POST['Country']['countryid'] > 0)
		{
		  $model=$this->loadModel($_POST['Country']['countryid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->countryname = $_POST['Country']['countryname'];
		  $model->countrycode = $_POST['Country']['countrycode'];
		  $model->recordstatus = $_POST['Country']['recordstatus'];
		}
		else
		{
		  $model = new Country();
		  $model->attributes=$_POST['Country'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
				try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Country']['countryid']);
              $this->GetSMessage('insertsuccess');
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
    $model=new Country('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Country']))
			$model->attributes=$_GET['Country'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select countryname
				from country a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.countryid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Country List';
		$this->pdf->AddPage('P');

		$this->pdf->colalign = array('C');
		$this->pdf->setwidths(array(90));
		$this->pdf->colheader = array('Country Name');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['countryname']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
			protected function gridData($data,$row)
  {     
    $model = Country::model()->findByPk($data->countryid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Country::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='country-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
