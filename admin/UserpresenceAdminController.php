<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see https://github.com/kajona/kajonacms/blob/master/LICENCE  *
********************************************************************************************************/

namespace Kajona\Userpresence\Admin;

use Kajona\System\Admin\AdminEvensimpler;
use Kajona\System\Admin\AdminInterface;
use Kajona\System\System\Link;
use Kajona\System\System\ModelInterface;


/**
 * Admin controller of the userpresence-module. Handles all admin requests.
 *
 * @author sidler@mulchprod.de
 *
 * @objectList Kajona\Userpresence\System\UserpresenceUser
 * @objectEdit Kajona\Userpresence\System\UserpresenceUser
 * @objectNew  Kajona\Userpresence\System\UserpresenceUser
 *
 * @autoTestable list,new
 *
 * @module userpresence
 * @moduleId _userpresence_module_id_
 */
class UserpresenceAdminController extends AdminEvensimpler implements AdminInterface
{


    public function getOutputModuleNavi()
    {
        $arrReturn = array();
        $arrReturn[] = array("view", Link::getLinkAdmin($this->getArrModule("modul"), "list", "", $this->getLang("commons_list"), "", "", true, "adminnavi"));
        return $arrReturn;
    }


    protected function getOutputNaviEntry(ModelInterface $objInstance)
    {
        return Link::getLinkAdmin($this->getArrModule("modul"), $this->getActionNameForClass("edit", $objInstance), "&systemid=".$objInstance->getSystemid(), $objInstance->getStrDisplayName());
    }

}

