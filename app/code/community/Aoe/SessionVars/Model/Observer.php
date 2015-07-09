<?php
/**
 * Store incoming vars
 *
 * @category    Aoe
 * @package     Aoe_SessionVars
 * @author      Manish Jain
 */
class Aoe_SessionVars_Model_Observer extends Mage_Core_Model_Abstract
{

    /**
     * Set session/cookie variables
     *
     * @param Varien_Event_Observer $observer
     * @return Aoe_SessionVars_Model_Observer
     */
    public function setSessionVars(Varien_Event_Observer $observer)
    {
        $sessionVars = Mage::helper('aoe_sessionvars')->getSessionVarConfiguration();

        foreach ($sessionVars as $code => $params) {

            $paramName = isset($params['getParameterName']) ? $params['getParameterName'] : false;
            $cookieName = isset($params['cookieName']) ? $params['cookieName'] : false;
            $regExp = isset($params['validate']) ? $params['validate'] : false;
            $scope = (isset($params['scope']) && ($params['scope'] != '')) ? $params['scope'] : 'core';

            $value = '';

            if ($paramName) {
                $value = Mage::app()->getRequest()->getParam($paramName, '');
            } elseif ($cookieName) {
                $cookieModel = Mage::getModel('core/cookie'); /* @var $cookieModel Mage_Core_Model_Cookie */
                $value = $cookieModel->get($cookieName);
                $cookieModel->delete($cookieName);
            }

            if ($value) {
                if ($regExp && !preg_match($regExp, $value)) {
                    continue;
                }
                Mage::getSingleton($scope.'/session', array('name'=>'frontend'))->setData($code, $value);
                Mage::dispatchEvent('aoe_sessionvars_store', array('code' => $code, 'value' => $value));
                Mage::dispatchEvent('aoe_sessionvars_store_'.$code, array('code' => $code, 'value' => $value));
            }

        }
        return $this;
    }
}
