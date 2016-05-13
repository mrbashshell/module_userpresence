<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see https://github.com/kajona/kajonacms/blob/master/LICENCE  *
********************************************************************************************************/

namespace Kajona\Userpresence\Installer;

use Kajona\Pages\System\PagesElement;
use Kajona\System\System\InstallerBase;
use Kajona\System\System\InstallerRemovableInterface;
use Kajona\System\System\OrmSchemamanager;
use Kajona\System\System\SystemAspect;
use Kajona\System\System\SystemModule;
use Kajona\Userpresence\System\UserpresenceUser;


/**
 * Class providing an installer for the userpresence module
 *
 * @package module_userpresence
 * @moduleId _userpresence_module_id_
 */
class InstallerUserpresence extends InstallerBase implements InstallerRemovableInterface
{

    public function install()
    {
        $strReturn = "";
        $objSchemamanager = new OrmSchemamanager();

        $strReturn .= "Installing tables...\n";
        $objSchemamanager->createTable('Kajona\Userpresence\System\UserpresenceUser');


        //register the module
        $this->registerModule("userpresence", _userpresence_module_id_, "UserpresencePortalController.php", "UserpresenceAdminController.php", $this->objMetadata->getStrVersion(), true);


        
        //Register the element
        $strReturn .= "Registering userpresence-element...\n";

        //check, if not already existing
        $objElement = PagesElement::getElement("userpresence");
        if ($objElement == null) {
            $objElement = new PagesElement();
            $objElement->setStrName("userpresence");
            $objElement->setStrClassAdmin("ElementUserpresenceAdmin.php");
            $objElement->setStrClassPortal("ElementUserpresencePortal.php");
            $objElement->setIntCachetime(3600);
            $objElement->setIntRepeat(1);
            $objElement->setStrVersion($this->objMetadata->getStrVersion());
            $objElement->updateObjectToDb();
            $strReturn .= "Element registered...\n";
        }
        else {
            $strReturn .= "Element already installed!...\n";
        }
        


        $strReturn .= "Setting aspect assignments...\n";
        if (SystemAspect::getAspectByName("content") != null) {
            $objModule = SystemModule::getModuleByName($this->objMetadata->getStrTitle());
            $objModule->setStrAspect(SystemAspect::getAspectByName("content")->getSystemid());
            $objModule->updateObjectToDb();
        }


        return $strReturn;

    }

    /**
     * Validates whether the current module/element is removable or not.
     * This is the place to trigger special validations and consistency checks going
     * beyond the common metadata-dependencies.
     *
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }

    /**
     * Removes the elements / modules handled by the current installer.
     * Use the reference param to add a human readable logging.
     *
     * @param string &$strReturn
     *
     * @return bool
     */
    public function remove(&$strReturn)
    {

        
        //delete the page-element
        $objElement = PagesElement::getElement("userpresence");
        if ($objElement != null) {
            $strReturn .= "Deleting page-element 'userpresence'...\n";
            $objElement->deleteObject();
        }
        else {
            $strReturn .= "Error finding page-element 'userpresence', aborting.\n";
            return false;
        }
        

        //delete all records
        /** @var UserpresenceUser $objOneRecord */
        foreach (UserpresenceUser::getObjectList() as $objOneRecord) {
            $strReturn .= "Deleting object '".$objOneRecord->getStrDisplayName()."' ...\n";
            if (!$objOneRecord->deleteObjectFromDatabase()) {
                $strReturn .= "Error deleting User, aborting.\n";
                return false;
            }
        }

        //delete the module-node
        $strReturn .= "Deleting the module-registration...\n";
        $objModule = SystemModule::getModuleByName($this->objMetadata->getStrTitle(), true);
        if (!$objModule->deleteObject()) {
            $strReturn .= "Error deleting module, aborting.\n";
            return false;
        }

        //delete the tables
        foreach (array("userpresence_User") as $strOneTable) {
            $strReturn .= "Dropping table ".$strOneTable."...\n";
            if (!$this->objDB->_pQuery("DROP TABLE ".$this->objDB->encloseTableName(_dbprefix_.$strOneTable)."", array())) {
                $strReturn .= "Error deleting table, aborting.\n";
                return false;
            }

        }

        return true;
    }


    public function update()
    {
        $strReturn = "";
        //check installed version and to which version we can update
        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);

        $strReturn .= "Version found:\n\t Module: ".$arrModule["module_name"].", Version: ".$arrModule["module_version"]."\n\n";


        return $strReturn."\n\n";
    }


}
