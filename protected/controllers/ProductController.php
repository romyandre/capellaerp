<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
  protected $menuname = 'product';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Product;
		if (Yii::app()->request->isAjaxRequest)
    {
      if ($this->CheckAccess($this->menuname, $this->iswrite)) {
        echo CJSON::encode(array(
            'status'=>'success',
        ));
        Yii::app()->end();
      }
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
            'productid'=>$model->productid,
            'productname'=>$model->productname,
            'productpic'=>$model->productpic,
			'isstock'=>$model->isstock,
            'recordstatus'=>$model->recordstatus,
            ));
        Yii::app()->end();
      }
    }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Product'], $_POST['Product']['productid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Product']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Product']['productname'],'emptyproductname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Product'];
		if ((int)$_POST['Product']['productid'] > 0)
		{
		  $model=$this->loadModel($_POST['Product']['productid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->productname = $_POST['Product']['productname'];
		  $model->recordstatus = $_POST['Product']['recordstatus'];
		  $model->isstock=$_POST['Product']['isstock'];
		}
		else
		{
		  $model = new Product();
		  $model->attributes=$_POST['Product'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		 $this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Product']['productid']);
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
      $model=new Product('search');
      $model->unsetAttributes();  // clear any default values
      if(isset($_GET['Product']))
        $model->attributes=$_GET['Product'];
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
		$sql = "select productname,productpic
				from product a ";
		if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.productid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Product List';
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(120,70));
		$this->pdf->colheader = array('Product Name','Picture');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L');
		foreach($dataReader as $row1)
		{
			if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/material/'.$row1['productpic'].'.jpg'))
			{
				$this->pdf->row(array(iconv("UTF-8", "ISO-8859-1", $row1['productname']),
					$this->pdf->Image($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/material/'.$row1['productpic'].'.jpg',10,30,30)
						));
			}
			else {
				$this->pdf->row(array(iconv("UTF-8", "ISO-8859-1", $row1['productname']),
					''
						));
			}
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Product::model()->findByPk($data->productid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
