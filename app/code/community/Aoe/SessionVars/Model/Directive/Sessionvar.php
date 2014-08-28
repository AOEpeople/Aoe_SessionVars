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

        $sessionVarValue = '';

        if (isset($params['code'])) {
            $config = Mage::getConfig()->getNode('frontend/aoe_sessionvars/vars/'.$params['code']);
            if ($config) {
                $scope = (string)$config->scope;
                $scope = ($scope != '') ? $scope : 'core';
                $sessionVarValue = Mage::getSingleton($scope.'/session', array('name'=>'frontend'))->getData($params['code']);
            }
            if (empty($sessionVarValue)) {
                $defaultValue = (string)$config->defaultValue;
                $sessionVarValue = $defaultValue;
            }
        }
        return $sessionVarValue;
    }
}
