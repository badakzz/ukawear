<?php
/**
 * 2007-2015 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * ApPageBuilder is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2015 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */
class ProductController extends ProductControllerCore
{
    /*
    * module: appagebuilder
    * date: 2019-03-25 14:19:46
    * version: 2.2.3
    */
    public function getTemplateVarProduct()
    {
        $product = parent::getTemplateVarProduct();
        if ((bool)Module::isEnabled('appagebuilder')) {
            $appagebuilder = Module::getInstanceByName('appagebuilder');
            $product['description'] = $appagebuilder->buildShortCode($product['description']);
            $product['description_short'] = $appagebuilder->buildShortCode($product['description_short']);
        }
        return $product;
    }
}
