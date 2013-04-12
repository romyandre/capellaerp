<?php

class RomawiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'romawi';
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Romawi;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

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
				'romawiid'=>$model->romawiid,
				'monthcal'=>$model->monthcal,
				'monthrm'=>$model->monthrm,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

     public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Romawi'], $_POST['Romawi']['romawiid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Romawi']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Romawi']['monthcal'],'emptycalendarmonth','emptystring'),
                array($_POST['Romawi']['monthrm'],'emptyromemonth','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Romawi'];
		if ((int)$_POST['Romawi']['romawiid'] > 0)
		{
		  $model=$this->loadModel($_POST['Romawi']['romawiid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->monthcal = $_POST['Romawi']['monthcal'];
		  $model->monthrm = $_POST['Romawi']['monthrm'];
		  $model->recordstatus = $_POST['Romawi']['recordstatus'];
		}
		else
		{
		  $model = new Romawi();
		  $model->attributes=$_POST['Romawi'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Romawi']['romawiid']);
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
    $model=new Romawi('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Romawi']))
			$model->attributes=$_GET['Romawi'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	protected function gridData($data,$row)
  {     
    $model = Romawi::model()->findByPk($data->romawiid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

public function actionDownload()
  {
	parent::actionDownload();
   $sql = "select *
				from romawi a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.companyid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Romawi';
		$this->pdf->AddPage('P');

		$this->pdf->colalign=array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(50,60,20,20,20,20));
		$this->pdf->colheader =array('Month Calendar', 'Month Rome');
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['monthcal'],$row1['monthrm']));
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
		$model=Romawi::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='romawi-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
