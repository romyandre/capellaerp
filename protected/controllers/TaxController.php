<?php

class TaxController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'tax';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Tax;

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
				'taxid'=>$model->taxid,
				'taxcode'=>$model->taxcode,
				'taxvalue'=>$model->taxvalue,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Tax'], $_POST['Tax']['taxid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Tax']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Tax']['taxcode'],'emptytaxcode','emptystring'),
                array($_POST['Tax']['taxvalue'],'emptytaxvalue','emptystring'),
                array($_POST['Tax']['description'],'emptydescription','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Tax'];
		if ((int)$_POST['Tax']['taxid'] > 0)
		{
		  $model=$this->loadModel($_POST['Tax']['taxid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->taxcode = $_POST['Tax']['taxcode'];
		  $model->taxvalue = $_POST['Tax']['taxvalue'];
		  $model->description = $_POST['Tax']['description'];
		  $model->recordstatus = $_POST['Tax']['recordstatus'];
		}
		else
		{
		  $model = new Tax();
		  $model->attributes=$_POST['Tax'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Tax']['taxid']);
              $this->GetSMessage('atxinsertsuccess');
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
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select taxcode, taxvalue, description
				from tax a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.taxid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Tax List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(40,50,90));
		$this->pdf->colheader = array('Tax Code','Tax Value','Description');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['taxcode'],$row1['taxvalue'],$row1['description']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Tax::model()->findByPk($data->taxid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
		$model=new Tax('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tax']))
			$model->attributes=$_GET['Tax'];
		if (isset($_GET['pageSize']))
		  {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tax::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tax-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
