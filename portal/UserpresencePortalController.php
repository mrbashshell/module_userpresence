<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see https://github.com/kajona/kajonacms/blob/master/LICENCE  *
********************************************************************************************************/

namespace Kajona\Userpresence\Portal;

use Kajona\Pages\Portal\PagesPortaleditor;
use Kajona\Pages\System\PagesPortaleditorActionEnum;
use Kajona\Pages\System\PagesPortaleditorSystemidAction;
use Kajona\System\Portal\PortalController;
use Kajona\System\Portal\PortalInterface;
use Kajona\System\System\Date;
use Kajona\System\System\HttpResponsetypes;
use Kajona\System\System\Link;
use Kajona\System\System\Objectfactory;
use Kajona\System\System\ResponseObject;
use Kajona\System\System\TemplateMapper;
use Kajona\Userpresence\System\UserpresenceUser;


/**
 * Portal-class of the userpresence module.
 *
 * @package module_userpresence
 * @author sidler@mulchprod.de
 * @module userpresence
 * @moduleId _userpresence_module_id_
 */
class UserpresencePortalController extends PortalController implements PortalInterface
{


    /**
     * Returns a list of records.
     *
     * @permissions view
     * @return string
     */
    protected function actionList()
    {
        return $this->objTemplate->fillTemplateFile(array(), "/module_".$this->getArrModule("modul")."/".$this->arrElementData["char1"], "userpresence_list");
    }

    /**
     * @permissions view
     * @xml
     */
    protected function actionSetStatus()
    {
        $objUser = Objectfactory::getInstance()->getObject($this->getSystemid());

        if($objUser instanceof UserpresenceUser) {
            $objUser->setIntIspresent($this->getParam("present") == "1" ? "1" : "0");

            if($objUser->getIntIspresent() == 0) {
                $objUser->setIntNocalls(0);
            }
            else {
                $objUser->setIntNocalls(1);
            }

            $objUser->updateObjectToDb();
        }

        $arrReturn = array(
            "name" => $objUser->getStrName(),
            "shortname" => $objUser->getStrShortName(),
            "present" => $objUser->getIntIspresent(),
            "presentread" => $this->getLang("userpresence_status_".$objUser->getIntIspresent()),
            "nocalls" => $objUser->getIntNocalls(),
            "nocallsread" => $this->getLang("userpresence_nocalls_".$objUser->getIntNocalls()),
            "lastchange" => dateToString(new Date($objUser->getIntLmTime())),
            "systemid" => $objUser->getSystemid()
        );

        ResponseObject::getInstance()->setStrResponseType(HttpResponsetypes::STR_TYPE_JSON);
        return json_encode($arrReturn);

    }

    /**
     * @permissions view
     * @xml
     */
    protected function actionSetCallstatus()
    {
        $objUser = Objectfactory::getInstance()->getObject($this->getSystemid());

        if($objUser instanceof UserpresenceUser) {

            if($objUser->getIntIspresent() == 1) {
                $objUser->setIntNocalls($this->getParam("nocalls") == "1" ? "1" : "0");
                $objUser->updateObjectToDb();
            }
        }

        $arrReturn = array(
            "name" => $objUser->getStrName(),
            "shortname" => $objUser->getStrShortName(),
            "present" => $objUser->getIntIspresent(),
            "presentread" => $this->getLang("userpresence_status_".$objUser->getIntIspresent()),
            "nocalls" => $objUser->getIntNocalls(),
            "nocallsread" => $this->getLang("userpresence_nocalls_".$objUser->getIntNocalls()),
            "lastchange" => dateToString(new Date($objUser->getIntLmTime())),
            "systemid" => $objUser->getSystemid()
        );

        ResponseObject::getInstance()->setStrResponseType(HttpResponsetypes::STR_TYPE_JSON);
        return json_encode($arrReturn);

    }



    /**
     * @permissions view
     * @xml
     */
    protected function actionGetAllUsers()
    {
        $arrUsers = UserpresenceUser::getObjectList();

        $arrReturn = array();
        /** @var UserpresenceUser $objOneUser */
        foreach($arrUsers as $objOneUser) {
            $arrReturn[] = array(
                "name" => $objOneUser->getStrName(),
                "shortname" => $objOneUser->getStrShortName(),
                "present" => $objOneUser->getIntIspresent(),
                "presentread" => $this->getLang("userpresence_status_".$objOneUser->getIntIspresent()),
                "nocalls" => $objOneUser->getIntNocalls(),
                "nocallsread" => $this->getLang("userpresence_nocalls_".$objOneUser->getIntNocalls()),
                "lastchange" => dateToString(new Date($objOneUser->getIntLmTime())),
                "systemid" => $objOneUser->getSystemid()
            );
        }
        
        ResponseObject::getInstance()->setStrResponseType(HttpResponsetypes::STR_TYPE_JSON);
        return json_encode($arrReturn);
    }

}
