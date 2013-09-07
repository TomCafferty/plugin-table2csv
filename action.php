<?php
/**
 * Table2Csv Action Plugin
 *
 *  Provides export of table to csv
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Tom Cafferty <tcafferty@glocalfocal.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

class action_plugin_table2csv extends DokuWiki_Action_Plugin {

    function getInfo() {
        return array(
            'author' => 'Tom Cafferty',
            'email'  => 'tcafferty@glocalfocal.com',
            'date'   => '2012-07-22',
            'name'   => 'table2csv',
            'desc'   => 'export table on page to csv file',
            'url'    => 'http://www.dokuwiki.org/plugin:table2csv'
        );
    }

    /**
     * Register its handlers with the DokuWiki's event controller
     */
    function register(&$controller) {
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'convert2csv',array());
    }

    /**
     * convert script for csv file output.
     *
     * @author Tom Cafferty <tcafferty@glocalfocal.com>
     */
    function convert2csv(&$event, $param) {
        global $ACT;
        global $ID;
        global $conf;

        // our event?
        if ($ACT != 'export_csv' ) return false;

        // check user's rights
        if ( auth_quickaclcheck($ID) < AUTH_READ ) {
            msg(sprintf('Forbidden access to page ' . $ID));
            return false;
        }

        // it's ours, no one else's
        require_once ('getTableData.php');
        $event->preventDefault();

        //get start marker
        $sm = p_get_metadata($ID,'table2csv');
        
        // get page data
        $fileext = $this->getConf('filepath');      
        $html = scrapeTable2Csv($ID,$fileext,$sm);
       
        if ($html === false) {
            return false;
        } else {
        // remain on current page
        header("HTTP/1.1 204 No Content"); 
        exit();        
        }       
    }
}