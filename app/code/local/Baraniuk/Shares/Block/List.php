<?php

class Baraniuk_Shares_Block_List extends Mage_Catalog_Block_Product_List {

    /** @var $_model Baraniuk_Shares_Model_Block  */
    protected $_model = null;

    public function _construct ()
    {
        $this->_model = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES);
        parent::_construct();
    }

    public function getCollection() {
        /** @var $collection Baraniuk_Shares_Model_Block  */
        $collection = $this->_model->getCollection()
            ->addFieldToFilter($this->_model::COLUMN_STATUS, $this->_model::STATUS_OPEN)
            ->addFieldToFilter($this->_model::COLUMN_ACTIVE, $this->_model::ENABLE)
            ->setOrder($this->_model::COLUMN_START_DATE, 'DESC');

        $this->setToolbarSettings($collection);

        return $collection;
    }

    private function setToolbarSettings (&$collection) {
        // Set current order item cause need to change if from 'position' value
        $this->getToolbarBlock()->setData('_current_grid_order', 'id');

        // Setting of output
        $this->getToolbarBlock()->setModes(['list']);
        $this->getToolbarBlock()->disableViewSwitcher();
        $this->getToolbarBlock()->disableExpanded();

        // Set shares collection
        $this->getToolbarBlock()->setCollection($collection);

        return $this;
    }

    public function getItem() {
        $id = $this->getRequest()->getParam('id');

        /**@var $collection Baraniuk_Shares_Model_Resource_Block_Collection */
        $collection = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->load($id, $this->_model::COLUMN_ID);

        return $collection;
    }

}

?>


