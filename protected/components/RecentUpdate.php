<?php
Yii::import('zii.widgets.CPortlet');
class RecentUpdate extends CPortlet
{
	public $menuname = '';
	protected function renderContent()
    {
        $this->render('RecentUpdate');
    }
}
?>