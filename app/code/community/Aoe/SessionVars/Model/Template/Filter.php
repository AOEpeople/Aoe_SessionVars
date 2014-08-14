<?php
class Aoe_SessionVars_Model_Template_Filter extends Mage_Widget_Model_Template_Filter
{

    /**
     * Session Variable directive
     *
     * @param array $construction
     * @return string
     */
    public function sessionvarDirective($construction)
    {
        $sessionVarValue = '';
        $params = $this->_getIncludeParameters($construction[2]);

        if (isset($params['code'])) {
            $config = Mage::getConfig()->getNode('frontend/aoe_sessionvars/vars/'.$params['code']);
            if ($config) {
                $scope = (string)$config->scope;
                $scope = ($scope != '') ? $scope : 'core';
                $sessionVarValue = Mage::getSingleton($scope.'/session', array('name'=>'frontend'))->getData($params['code']);
                if (empty($sessionVarValue)) {
                    $defaultValue = (string)$config->defaultValue;
                    $sessionVarValue = $defaultValue;
                }
            }
        }
        return $sessionVarValue;
    }
}
