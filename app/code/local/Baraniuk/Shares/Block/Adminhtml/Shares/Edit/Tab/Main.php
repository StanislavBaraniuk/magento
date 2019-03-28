<?php

class Baraniuk_Shares_Block_Adminhtml_Shares_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        $model = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->load($this->getRequest()->getParam('id'));

        $form = new Varien_Data_Form();


        $fieldset = $form->addFieldset(
            'main_tab',
            array('legend'=>Mage::helper(BARANIUK_SHARES::HELPER_HTML)->__('General Information'), 'class' => 'fieldset-wide'));

        $columns = Mage::getModel(BARANIUK_SHARES::MODEL_SHARES)->getGridColumns();

        $fieldset->addField('status', 'hidden', array(
            'options'       => array(1),
            'label'     => Mage::helper( BARANIUK_SHARES::HELPER_HTML)->__( 'status'),
            'title'     => Mage::helper( BARANIUK_SHARES::HELPER_HTML)->__( 'status' ),
            'after_element_html' => '<tr><td><label style="margin-left: 5px" for="title">STATUS</label></td>
                <td><span style="margin-left: 10px">disabled</span></td></tr>',
        ));

        foreach ($columns as $column) {
            if ($column['readable']) {
                try {
                    switch ($column) {
                        case $column['type'] == 'datetime':
                            $fieldset->addField($column[ 'key' ], $column[ 'input' ], array(
                                'options'       => $column[ 'options' ],
                                'name'          => $column[ 'key' ],
                                'label'         => Mage::helper( BARANIUK_SHARES::HELPER_HTML)->__( $column[ 'name' ] ),
                                'title'         => Mage::helper( BARANIUK_SHARES::HELPER_HTML)->__( $column[ 'name' ] ),
                                'required'      => $column[ 'required' ],
                                'image'         => $this->getSkinUrl($column[ 'image' ]),
                                'time'          => true,
                                'format'        => 'yyyy-MM-dd HH:mm',
                                'input_format'  => 'yyyy-MM-dd HH:mm'
                            ));
                            break;
                        default :
                            $fieldset->addField($column[ 'key' ], $column[ 'input' ], array(
                                'options'   => $column[ 'options' ],
                                'name'      => $column[ 'key' ],
                                'label'     => Mage::helper( BARANIUK_SHARES::HELPER_HTML)->__( $column[ 'name' ] ),
                                'title'     => Mage::helper( BARANIUK_SHARES::HELPER_HTML)->__( $column[ 'name' ] ),
                                'required'  => $column[ 'required' ],
                                'format'    => $column[ 'format' ],
                                'image'     => $this->getSkinUrl($column[ 'image' ])
                            ));
                            break;
                    }

                } catch (Exception $e) {
                    echo "<script>alert('".$column["key"]." - error');</script>";
                }
            }
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return $this->__('Main tab');
    }

    public function getTabTitle()
    {
        return $this->__('Title Main');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}