<?php

class MaterialstatusController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'materialstatus';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Materialstatus;

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
				'materialstatusid'=>$model->materialstatusid,
				'materialstatusname'=>$model->materialstatusname,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
        }
	}

     public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Materialstatus'], $_POST['Materialstatus']['materialstatusid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Materialstatus']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Materialstatus']['materialstatusname'],'emptymaterialstatusname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Materialstatus'];
		if ((int)$_POST['Materialstatus']['materialstatusid'] > 0)
		{
		  $model=$this->loadModel($_POST['Materialstatus']['materialstatusid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->materialstatusname = $_POST['Materialstatus']['materialstatusname'];
		  $model->recordstatus = $_POST['Materialstatus']['recordstatus'];
		}
		else
		{
		  $model = new Materialstatus();
		  $model->attributes=$_POST['Materialstatus'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Materialstatus']['materialstatusid']);
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
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
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
    $model = Materialstatus::model()->findByPk($data->materialstatusid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
		$model=new Materialstatus('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialstatus']))
			$model->attributes=$_GET['Materialstatus'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model
	  ));
	}
	
	public function actionDownload()
  {
	parent::actionDownload();
    $sql = "select a.materialstatusname
      from materialstatus a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.materialstatusid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
    $this->pdf->title='Material Status List';
    $this->pdf->AddPage('P');

    $this->pdf->colalign = array('C','C');
    $this->pdf->setwidths(array(90));
	$this->pdf->colheader = array('Material Status Name');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['materialstatusname']));
    }
    // me-render ke browser
    $this->pdf->Output();
  }

	/**
	 *
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Materialstatus::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='materialstatus-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
