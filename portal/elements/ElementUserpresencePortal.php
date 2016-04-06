<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see https://github.com/kajona/kajonacms/blob/master/LICENCE  *
********************************************************************************************************/

namespace Kajona\Userpresence\Portal\Elements;

use Kajona\Pages\Portal\ElementPortal;
use Kajona\Pages\Portal\PortalElementInterface;
use Kajona\System\System\SystemModule;


/**
 * Portal-part of the userpresence-element
 *
 * @package module_userpresence
 * @author sidler@mulchprod.de
 * @targetTable element_universal.content_id
 */
class ElementUserpresencePortal extends ElementPortal implements PortalElementInterface
{


    /**
     * Loads the userpresence-controller and passes control
     *
     * @return string
     */
    public function loadData()
    {
        $strReturn = "";
        //Load the data
        $objModuleController = SystemModule::getModuleByName("userpresence");
        if ($objModuleController != null) {
            $objPortalController = $objModuleController->getPortalInstanceOfConcreteModule($this->arrElementData);
            $strReturn = $objPortalController->action();
        }
        return $strReturn;
    }

}
