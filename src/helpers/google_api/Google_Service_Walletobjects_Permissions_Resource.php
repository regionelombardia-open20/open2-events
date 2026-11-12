<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-events
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace open20\amos\events\helpers\google_api;

use Google_Service_Resource;


/**
 * The "permissions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $walletobjectsService = new Google_Service_Walletobjects(...);
 *   $permissions = $walletobjectsService->permissions;
 *  </code>
 */
class Google_Service_Walletobjects_Permissions_Resource extends Google_Service_Resource
{

    /**
     * Returns the permissions for the given issuer id. (permissions.get)
     *
     * @param string $resourceId The unique identifier for an issuer. This ID must
     * be unique across all issuers.
     * @param array $optParams Optional parameters.
     * @return Google_Service_Walletobjects_Permissions
     */
    public function get($resourceId, $optParams = array())
    {
        $params = array('resourceId' => $resourceId);
        $params = array_merge($params, $optParams);
        return $this->call('get', array($params), "Google_Service_Walletobjects_Permissions");
    }

    /**
     * Updates the permissions for the given issuer. (permissions.update)
     *
     * @param string $resourceId The unique identifier for an issuer. This ID must
     * be unique across all issuers.
     * @param Google_Permissions $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Walletobjects_Permissions
     */
    public function update($resourceId, Google_Service_Walletobjects_Permissions $postBody, $optParams = array())
    {
        $params = array('resourceId' => $resourceId, 'postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('update', array($params), "Google_Service_Walletobjects_Permissions");
    }
}
