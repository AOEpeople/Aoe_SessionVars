<?php
class Aoe_SessionVars_Model_Template_Filter extends Mage_Widget_Model_Template_Filter
{
    const SESSION_SCOPE = 'frontend/aoe_sessionvars/vars/%s/scope';

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
            $scope = (string)Mage::getConfig()->getNode(self::SESSION_SCOPE, $params['code']);
            $scope = ($scope != '') ? $scope : 'core';
            $sessionVarValue = Mage::getSingleton($scope.'/session', array('name'=>'frontend'))->getData($params['code']);
        }
        return $sessionVarValue;
    }
}
