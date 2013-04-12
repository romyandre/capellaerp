<?php

class CurrencyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'currency';


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $model=new Currency;

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
				'currencyid'=>$model->currencyid,
				'countryid'=>$model->countryid,
				'currencyname'=>$model->currencyname,
				'symbol'=>$model->symbol,
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Currency'], $_POST['Currency']['currencyid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Currency']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Currency']['countryid'],'emptycountryname','emptystring'),
                array($_POST['Currency']['currencyname'],'emptycurrencyname','emptystring'),
                array($_POST['Currency']['symbol'],'emptysymbol','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Currency'];
		if ((int)$_POST['Currency']['currencyid'] > 0)
		{
		  $model=$this->loadModel($_POST['Currency']['currencyid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->countryid = $_POST['Currency']['countryid'];
		  $model->currencyname = $_POST['Currency']['currencyname'];
		  $model->symbol = $_POST['Currency']['symbol'];
		  $model->recordstatus = $_POST['Currency']['recordstatus'];
		}
		else
		{
		  $model = new Currency();
		  $model->attributes=$_POST['Currency'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Currency']['currencyid']);
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
    $model=new Currency('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Currency']))
			$model->attributes=$_GET['Currency'];
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
		$sql = "select countryname,currencyname,symbol
				from currency a
left join country b on b.countryid = a.countryid				";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.currencyid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Currency List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign=array('C','C','C','C');
		$this->pdf->setwidths(array(60,80,30,30));
		$this->pdf->colheader=array('Country Name','Currency Name','Symbol');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign=array('L','L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['countryname'],$row1['currencyname'],$row1['symbol']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Currency::model()->findByPk($data->currencyid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Currency::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='currency-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
