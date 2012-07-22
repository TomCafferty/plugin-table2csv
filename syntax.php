<?php
/**
 * Table2csv Plugin
 *
 * Provides tag for table to export.
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  Tom Cafferty <tcafferty@glocalfocal.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_table2csv extends DokuWiki_Syntax_Plugin {

  /**
   * return some info
   */
  function getInfo(){
    return array (
      'author' => 'Tom Cafferty',
      'email' => 'tcafferty@glocalfocal.com',
      'date' => '2012-07-08',
      'name' => 'Table2csv plugin (syntax component)',
      'desc' => 'Provide table identification',
      'url' => 'http://www.dokuwiki.org/plugin:table2csv',
    );
  }
    
  function getType(){
      return 'substition';
  }

  function getPType(){
      return 'block';
  }
  
  function getSort(){
      return 160;
  }
  
  /**
   * Connect pattern to lexer
   */
  function connectTo($mode) {
      $this->Lexer->addSpecialPattern('<table2csv>.*?</table2csv>',$mode,'plugin_table2csv');
  }

  /**
   * Handle the match
   */
  function handle($match, $state, $pos, &$handler){
      parse_str($match, $return);   
      return $return;
  }
 
  /**
   *  Render output
   */
  function render($mode, &$renderer, $data) {
      global $INFO;
      global $ID;
      global $conf;
      if ($mode == 'metadata') {
          $renderer->meta ['table2csv'] = $data['startMarker'];
          return true;
      }
      else
          return false;
  }

}
