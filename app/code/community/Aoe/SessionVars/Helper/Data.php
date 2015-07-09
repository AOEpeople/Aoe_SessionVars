<?php
/**
 * Class Aoe_SessionVars_Helper_Data
 *
 * @author Fabrizio Branca
 * @since 2015-04-02
 */
class Aoe_SessionVars_Helper_Data extends Mage_Core_Helper_Abstract
{

    const SESSION_VARS_PATH = 'frontend/aoe_sessionvars/vars';

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

    /**
     * This will return a md5 hash with all available session vars and their values
     * intended to be used as addition to a block cache key in case the block is consuming any session vars inside
     *
     * @return string
     */
    public function getCacheKey()
    {
        $cacheKey = array();
        foreach ($this->getSessionVarConfiguration() as $code => $params) {
            $cacheKey[] = $code;
            $cacheKey[] = $this->getSessionVar($code);
        }
        return md5(implode('|', $cacheKey));
    }

    /**
     * Get session var configuration
     *
     * @return array
     */
    public function getSessionVarConfiguration()
    {
        $sessionVars = Mage::getConfig()->getNode(self::SESSION_VARS_PATH)->asArray();
        return is_array($sessionVars) ? $sessionVars : array();
    }

}