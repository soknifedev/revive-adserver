<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 Openads Limited                                   |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id:$
*/

/**
 * @package    OpenadsDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */

// Require the base Info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 * The OA_Dll_PublisherInfo class extends the base OA_Info class and contains
 * information about publisher
 *
 */

class OA_Dll_PublisherInfo extends OA_Info
{

    /**
     * This field provides the ID of the publisher.
     *
     * @var integer $publisherId
     */
    var $publisherId;

    /**
     * This field provides the ID of the agency associated with the publisher.
     *
     * @var integer $agencyId
     */
    var $agencyId;

    /**
     * This field provides the name of the publisher.
     *
     * @var string $publisherName
     */
    var $publisherName;

    /**
     * This field provides the name of the contact for the publisher.
     *
     * @var string $contactName
     */
    var $contactName;

    /**
     * This field provides the email address of the contact for the publisher.
     *
     * @var string $emailAddress
     */
    var $emailAddress;

    /**
     * This field provides the username the contact uses to log into Openads.
     *
     * @var string $username
     */
    var $username;

    /**
     * This field provides the password the contact uses to log into Openads.
     *
     * @var string $password
     */
    var $password;

    /**
     * This method sets all default values when adding a new publisher.
     *
     */
    function setDefaultForAdd() {
        if (is_null($this->agencyId)) {
            $this->agencyId = OA_Permission::getAgencyId();
        }
    }

    /**
     * This method returns an array of fields with their corresponding types.
     *
     * @access public
     *
     * @return array
     */
    function getFieldsTypes()
    {
        return array(
                    'publisherId' => 'integer',
                    'agencyId' => 'integer',
                    'publisherName' => 'string',
                    'contactName' => 'string',
                    'emailAddress' => 'string',
                    'username' => 'string',
                    'password' => 'string'
                );
    }
}

?>