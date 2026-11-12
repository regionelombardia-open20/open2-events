<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\widgets
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

namespace open20\amos\events\widgets;

use open20\amos\core\forms\ShowUserTagsWidget;

/**
 * Class EventsShowUserTagsWidget
 * @package open20\amos\events\widgets
 */
class EventsShowUserTagsWidget extends ShowUserTagsWidget
{
    /**
     * @var array $tagSessionIds Array of tag values selected by user in publication step
     */
    private $tagSessionIds = [];

    /**
     * @inheritdoc
     */
    protected function getArrayTagsId()
    {
        $ret = [];
        if (!empty($this->tagSessionIds)) {
            foreach ($this->tagSessionIds as $rootId => $treeTagIdsStr) {
                if (!strlen($treeTagIdsStr)) {
                    continue;
                }
                
                $treeTagIds = explode(',', $treeTagIdsStr);
                foreach ($treeTagIds as $tagId) {
                    $ret[] = $tagId;
                }
            }
        }
        
        return $ret;
    }

    /**
     * @inheritdoc
     */
    protected function getAllTagsRoots()
    {
        $this->userTagList = $this->getArrayTagsId();
        $ret = [];
        if (!empty($this->tagSessionIds)) {
            foreach ($this->tagSessionIds as $rootId => $treeTagIdsStr) {
                if (!strlen($treeTagIdsStr)) {
                    continue;
                }
                
                $root = $this->getTagById($rootId);
                $ret[$rootId]['el'] = $root->nome;
                $ret[$rootId]['level'] = $root->lvl;
            }
        }
        
        return $ret;
    }

    /**
     * @return array
     */
    public function getTagSessionIds()
    {
        return $this->tagSessionIds;
    }

    /**
     * @param array $tagSessionIds
     */
    public function setTagSessionIds($tagSessionIds)
    {
        $this->tagSessionIds = $tagSessionIds;
    }
}
