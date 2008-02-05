<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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
$Id$
*/

require_once MAX_PATH . '/tests/testClasses/DbTestCase.php';

/**
 * Tests for OA_DB_Sql class.
 *
 * @package    OpenadsDB
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class Test_OA_DB_Sql extends DbTestCase
{
    function testSqlForInsert()
    {
        $sql = OA_DB_Sql::sqlForInsert('zones', array('zonetype' => 1, 'name' => "120x72"));
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($this->getPrefix().'zones',true);
        $this->assertEqual("INSERT INTO {$table} (zonetype,name) VALUES (1,'120x72')", $sql);
    }

    function testDeleteWhereOne()
    {
        $this->oaTable->createTable('audit');
        $this->oaTable->createTable('acls');

        $dg = new DataGenerator();
        $dg->setData('acls', array('bannerid' => array(1,2,3), 'executionorder' => array(0,0,0,1,1,1,2,2,2)));
        $dg->generate('acls', 5);

        OA_DB_Sql::deleteWhereOne('acls', 'bannerid', 1);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid = 1;
        $doAcls->find();
        $this->assertEqual(0, $doAcls->getRowCount());

        $doAcls->bannerid = 2;
        $doAcls->find();
        $this->assertEqual(2, $doAcls->getRowCount());

        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->oaTable->dropTable($aConf['table']['prefix'].'acls');
    }

    function testSelectWhereOne()
    {
        $this->initTables(array('banners', 'ad_zone_assoc', 'placement_zone_assoc', 'zones'));

        $id = DataGenerator::generateOne('banners');
        $rsBanners = OA_DB_Sql::selectWhereOne('banners', 'bannerid', $id);
        $this->assertTrue($rsBanners->fetch());
        $this->assertFalse($rsBanners->fetch());

        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->oaTable->dropTable($aConf['table']['prefix'].'banners');
        $this->oaTable->dropTable($aConf['table']['prefix'].'ad_zone_assoc');
        $this->oaTable->dropTable($aConf['table']['prefix'].'placement_zone_assoc');
        $this->oaTable->dropTable($aConf['table']['prefix'].'zones');
    }


    function testUpdateWhereOne()
    {
        $this->initTables(array('campaigns', 'trackers'));

        $dg = new DataGenerator();
        $dg->setData('campaigns', array(
            'campaignid' => array(1, 2, 3),
            'campaignname' => array('First', 'Fifth', 'Third'),
            'views' => array(10, 50, 30)
        ));
        $dg->generate('campaigns', 3);
        $cUpdated = OA_DB_Sql::updateWhereOne('campaigns', 'campaignid', 2,
            array('campaignname' => 'Second', 'views' => 20));
        $this->assertEqual(1, $cUpdated);
        $doCampaigns = OA_Dal::staticGetDO('campaigns', 2);
        $this->assertEqual('Second', $doCampaigns->campaignname);
        $this->assertEqual(20, $doCampaigns->views);
        $doCampaigns = OA_Dal::staticGetDO('campaigns', 1);
        $this->assertEqual('First', $doCampaigns->campaignname);
        $this->assertEqual('10', $doCampaigns->views);

        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->oaTable->dropTable($aConf['table']['prefix'].'campaigns');
        $this->oaTable->dropTable($aConf['table']['prefix'].'trackers');
    }
}

?>
