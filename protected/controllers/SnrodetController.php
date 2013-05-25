<?php

class SnrodetController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'snrodet';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Snrodet;

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
				'snrodid'=>$model->snrodid,
				'snroid'=>$model->snroid,
				'curdd'=>$model->curdd,
				'curmm'=>$model->curmm,
				'curyy'=>$model->curyy,
				'curvalue'=>$model->curvalue,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Snrodet'], $_POST['Snrodet']['snrodid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Snrodet']))
	  {
		//$dataku->attributes=$_POST['Snrodet'];
		if ((int)$_POST['Snrodet']['snrodid'] > 0)
		{
		  $model=$this->loadModel($_POST['Snrodet']['snrodid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->snroid = $_POST['Snrodet']['snroid'];
		  $model->curdd = $_POST['Snrodet']['curdd'];
		  $model->curmm = $_POST['Snrodet']['curmm'];
		  $model->curyy = $_POST['Snrodet']['curyy'];
		  $model->curvalue = $_POST['Snrodet']['curvalue'];
		}
		else
		{
		  $model = new Snrodet();
		  $model->attributes=$_POST['Snrodet'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Snrodet']['snrodid']);
              $this->GetSMessage('scoinsertsuccess');
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
	  parent::actionDelete();
		  $model=$this->loadModel($_POST['id']);
		  $model->delete();
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
    $model=new Snrodet('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Snrodet']))
			$model->attributes=$_GET['Snrodet'];
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
    $model = Snrodet::model()->findByPk($data->snrodid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select description,curdd,curmm,curyy,curvalue,curcc,curpt,curpp
				from snrodet a
left join snro b on b.snroid = a.snroid				";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.snrodid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='SNRO Detail List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(60,15,15,15,20,20,20,20));
		$this->pdf->colheader =array('Description','Day','Month','Year','Current CC','Current PT','Current PP','Current Value');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','R','R','R','R','R','R','R');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['description'],$row1['curdd'],$row1['curmm'],$row1['curyy']
		  ,$row1['curcc'],$row1['curpt'],$row1['curpp'],$row1['curvalue']));
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
		$model=Snrodet::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='snrodet-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
