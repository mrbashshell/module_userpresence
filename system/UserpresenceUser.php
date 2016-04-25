<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see https://github.com/kajona/kajonacms/blob/master/LICENCE  *
********************************************************************************************************/

namespace Kajona\Userpresence\System;

use Kajona\System\System\AdminListableInterface;
use Kajona\System\System\Model;
use Kajona\System\System\ModelInterface;

/**
 * Model for a userpresence record object itself
 *
 * @author sidler@mulchprod.de
 * @targetTable userpresence_user.user_id
 *
 * @module userpresence
 * @moduleId _userpresence_module_id_
 */
class UserpresenceUser extends Model implements ModelInterface, AdminListableInterface
{


    /**
     * @var string
     * @tableColumn userpresence_user.user_name
     * @tableColumnDatatype char254
     * @fieldType text
     * @fieldMandatory
     * @addSearchIndex
     * @templateExport
     * @listOrder ASC
     */
     private $strName = "";

    /**
     * @var string
     * @tableColumn userpresence_user.user_shortname
     * @tableColumnDatatype char254
     * @fieldType text
     * @fieldMandatory
     * @addSearchIndex
     * @templateExport
     */
    private $strShortName = "";

    /**
     * @var string
     * @tableColumn userpresence_user.user_comment
     * @tableColumnDatatype char254
     * @fieldType text
     * @addSearchIndex
     * @templateExport
     */
    private $strComment = "";

    /**
     * @var string
     * @tableColumn userpresence_user.user_nocalls
     * @tableColumnDatatype int
     * @fieldType toggleonoff
     */
    private $intNocalls = "";

    /**
     * @var string
     * @tableColumn userpresence_user.user_ispresent
     * @tableColumnDatatype int
     * @fieldType toggleonoff
     */
     private $intIspresent = "";



    /**
     * Returns the icon the be used in lists.
     * Please be aware, that only the filename should be returned, the wrapping by getImageAdmin() is
     * done afterwards.
     *
     * @return string the name of the icon, not yet wrapped by getImageAdmin(). Alternatively, you may return an array containing
     *         [the image name, the alt-title]
     */
    public function getStrIcon()
    {
        return "icon_dot";
    }

    /**
     * In nearly all cases, the additional info is rendered left to the action-icons.
     *
     * @return string
     */
    public function getStrAdditionalInfo()
    {
        return "";
    }

    /**
     * If not empty, the returned string is rendered below the common title.
     *
     * @return string
     */
    public function getStrLongDescription()
    {
        return "";
    }

    /**
     * Returns the name to be used when rendering the current object, e.g. in admin-lists.
     *
     * @return string
     */
    public function getStrDisplayName()
    {
        return uniStrTrim($this->strName, 150);
    }


    public function getStrName()
    {
        return $this->strName;
    }

    public function setStrName($strName)
    {
        $this->strName = $strName;
    }

    public function getStrShortName()
    {
        return $this->strShortName;
    }

    public function setStrShortName($strShortName)
    {
        $this->strShortName = $strShortName;
    }

    public function getStrComment()
    {
        return $this->strComment;
    }

    public function setStrComment($strComment)
    {
        $this->strComment = $strComment;
    }

    public function getIntNocalls()
    {
        return $this->intNocalls;
    }

    public function setIntNocalls($intNocalls)
    {
        $this->intNocalls = $intNocalls;
    }

    public function getIntIspresent()
    {
        return $this->intIspresent;
    }

    public function setIntIspresent($intIspresent)
    {
        $this->intIspresent = $intIspresent;
    }


}
