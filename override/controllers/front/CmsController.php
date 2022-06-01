<?php

class CmsController extends CmsControllerCore
{
    /*
    * module: appagebuilder
    * date: 2019-03-25 14:19:46
    * version: 2.2.3
    */
    public function initContent()
    {
        if ($this->assignCase == 1) {
            $cmsVar = $this->objectPresenter->present($this->cms);
            $filteredCmsContent = Hook::exec(
                'filterCmsContent',
                array('object' => $cmsVar),
                $id_module = null,
                $array_return = false,
                $check_exceptions = true,
                $use_push = false,
                $id_shop = null,
                $chain = true
            );
            if (!empty($filteredCmsContent['object'])) {
                $cmsVar = $filteredCmsContent['object'];
            }
            if ((bool)Module::isEnabled('appagebuilder')) {
                $appagebuilder = Module::getInstanceByName('appagebuilder');
                $cmsVar['content'] = $appagebuilder->buildShortCode($cmsVar['content']);
            }
            $this->context->smarty->assign(array(
                'cms' => $cmsVar,
            ));
            if ($this->cms->indexation == 0) {
                $this->context->smarty->assign('nobots', true);
            }
            $this->setTemplate(
                'cms/page',
                array('entity' => 'cms', 'id' => $this->cms->id)
            );
        } elseif ($this->assignCase == 2) {
            $cmsCategoryVar = $this->getTemplateVarCategoryCms();
            $filteredCmsCategoryContent = Hook::exec(
                'filterCmsCategoryContent',
                array('object' => $cmsCategoryVar),
                $id_module = null,
                $array_return = false,
                $check_exceptions = true,
                $use_push = false,
                $id_shop = null,
                $chain = true
            );
            if (!empty($filteredCmsCategoryContent['object'])) {
                $cmsCategoryVar = $filteredCmsCategoryContent['object'];
            }
            $this->context->smarty->assign($cmsCategoryVar);
            $this->setTemplate('cms/category');
        }
        FrontController::initContent();
        
        unset($id_module);
        unset($array_return);
        unset($check_exceptions);
        unset($use_push);
        unset($id_shop);
        unset($chain);
    }
    /*
    * module: leoslideshow
    * date: 2019-03-25 14:19:50
    * version: 1.0.4
    */
    public function display()
    {
        if ((bool) Module::isEnabled('leoslideshow')) {
            $leoslideshow = Module::getInstanceByName('leoslideshow');
            $leoslideshow->processCMS();
        }
        return parent::display();
    }
}
