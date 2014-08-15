<?php
/**
 * Auto apply coupon Model
 *
 * @category    Aoe
 * @package     Aoe_SessionVars
 * @author      Manish Jain
 */
class Aoe_SessionVars_Model_Observer extends Mage_Core_Model_Abstract
{
    const SESSION_VARS_PATH = 'frontend/aoe_sessionvars/vars';

    /**
     * Set session/cookie variables
     *
     * @param Varien_Event_Observer $observer
     * @return Aoe_SessionVars_Model_Observer
     */
    public function setSessionVars(Varien_Event_Observer $observer)
    {
        $sessionVars = Mage::getConfig()->getNode(self::SESSION_VARS_PATH)->asArray();

        if (count($sessionVars)) {
            foreach ($sessionVars as $var=>$params) {

                $paramName = isset($params['getParameterName']) ? $params['getParameterName'] : false;
                $cookieName = isset($params['cookieName']) ? $params['cookieName'] : false;
                $regExp = isset($params['validate']) ? $params['validate'] : false;
                $scope = (isset($params['scope']) && ($params['scope'] != '')) ? $params['scope'] : 'core';
                $defaultValue = isset($params['defaultValue']) ? $params['defaultValue'] : false;

                $data = '';

                if ($paramName) {
                    $data = Mage::app()->getRequest()->getParam($paramName, $defaultValue);
                } elseif ($cookieName) {
                    $data = Mage::app()->getRequest()->getCookie($cookieName, $defaultValue);
                    Mage::getModel('core/cookie')->delete($cookieName);
                }

                if ($data) {
                    if ($regExp && !preg_match($regExp, $data)) {
                        continue;
                    }
                    Mage::getSingleton($scope.'/session', array('name'=>'frontend'))->setData($var, $data);
                }

            }
        }
        return $this;
    }
}