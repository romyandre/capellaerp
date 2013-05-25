<?php

class IndustryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'industry';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Industry;

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
		 $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'industryid'=>$model->industryid,
				'industryname'=>$model->industryname,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Industry'], $_POST['Industry']['industryid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Industry']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Industry']['industryname'],'emptyindustryname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Industry'];
		if ((int)$_POST['Industry']['industryid'] > 0)
		{
		  $model=$this->loadModel($_POST['Industry']['industryid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->industryname = $_POST['Industry']['industryname'];
		  $model->recordstatus = $_POST['Industry']['recordstatus'];
		}
		else
		{
		  $model = new Industry();
		  $model->attributes=$_POST['Industry'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Industry']['industryid']);
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
	
	protected function gridData($data,$row)
  {     
    $model = Industry::model()->findByPk($data->industryid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
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
    $model=new Industry('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Industry']))
			$model->attributes=$_GET['Industry'];
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
   $sql = "select *
				from industry a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.industryid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Industry';
		$this->pdf->AddPage('P');

		$this->pdf->colalign=array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(40,60,20,20,20,20));
		$this->pdf->colheader =array('Industry Name');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['industryname']));
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
		$model=Industry::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='industry-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
