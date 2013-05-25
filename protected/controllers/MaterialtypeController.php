<?php

class MaterialtypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'materialtype';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Materialtype;

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
				'materialtypeid'=>$model->materialtypeid,
				'materialtypecode'=>$model->materialtypecode,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
        }
	}

     public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Materialtype'], $_POST['Materialtype']['materialtypeid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Materialtype']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Materialtype']['materialtypecode'],'emptymaterialtypecode','emptystring'),
                array($_POST['Materialtype']['description'],'emptydescription','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Materialtype'];
		if ((int)$_POST['Materialtype']['materialtypeid'] > 0)
		{
		  $model=$this->loadModel($_POST['Materialtype']['materialtypeid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->materialtypecode = $_POST['Materialtype']['materialtypecode'];
		  $model->description = $_POST['Materialtype']['description'];
		  $model->recordstatus = $_POST['Materialtype']['recordstatus'];
		}
		else
		{
		  $model = new Materialtype();
		  $model->attributes=$_POST['Materialtype'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		 $this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Materialtype']['materialtypeid']);
              $this->GetSMessage('pmmtinsertsuccess');
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
		$model=new Materialtype('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialtype']))
			$model->attributes=$_GET['Materialtype'];
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
		$sql = "select materialtypecode,description
				from materialtype a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.materialtypeid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Material Type List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(60,120));
		$this->pdf->colheader = array('Material Type Code','Description');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['materialtypecode'],$row1['description']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Materialtype::model()->findByPk($data->materialtypeid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 *
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Materialtype::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='materialtype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
