<?php

class Aoe_SessionVars_Model_Directive_Sessionvar implements Aoe_ExtendedFilter_Model_Directive_Interface
{
    /**
     * @param Aoe_ExtendedFilter_Model_Interface $filter
     * @param array $params
     *
     * @return mixed
     */
    public function process(Aoe_ExtendedFilter_Model_Interface $filter, array $params)
    {
        // Re-parse the third parameter with the tokenizer and discard original parameters
        $params = $filter->getIncludeParameters($params[2]);
        return isset($params['code']) ? Mage::helper('aoe_sessionvars')->getSessionVar($params['code']) : '';
    }
}
