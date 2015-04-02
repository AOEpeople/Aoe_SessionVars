<?php
/**
 * Class Aoe_SessionVars_Helper_Data
 *
 * @author Fabrizio Branca
 * @since 2015-04-02
 */
class Aoe_SessionVars_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Get session var
     *
     * @param $code
     * @return mixed|null|string
     */
    public function getSessionVar($code)
    {
        $sessionVarValue = null;
        $config = Mage::getConfig()->getNode('frontend/aoe_sessionvars/vars/'.$code);
        if ($config) {
            $scope = (string)$config->scope;
            $scope = ($scope != '') ? $scope : 'core';
            $sessionVarValue = Mage::getSingleton($scope.'/session', array('name'=>'frontend'))->getData($code);
        }
        return !empty($sessionVarValue) ? $sessionVarValue : (string)$config->defaultValue;
    }

}