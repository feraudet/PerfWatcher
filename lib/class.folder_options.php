<?php # vim: set filetype=php fdm=marker sw=4 ts=4 et : 
/**
 * Copyright (c) 2012 Cyril Feraudet
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  Monitoring
 * @author    Cyril Feraudet <cyril@feraudet.com>
 * @copyright 2012 Cyril Feraudet
 * @license   http://opensource.org/licenses/mit-license.php
 * @link      http://www.perfwatcher.org/
 **/ 

class folder_options {
    private $item = array();

    function __construct($item) {
        $this->item =& $item;
    }

    function is_compatible() {
        switch($this->item['pwtype']) {
            case 'container':
                return true;
                break;
            default:
                return false;
                break;
        }
    }

    function get_info() {
        $obt = "";
        switch($this->item['pwtype']) {
            case 'container': $obt = "container"; break;
            case 'server': $obt = "server"; break;
            case 'selection': $obt = "selection"; break;
            default: $obt = "??? (bug ?)";
        }

        return array(
                'title' => "$obt options",
                'content_url' => 'html/folder_options.html',
                'db_config_key' => 'sort',
                );
    }

    /* Note: this function may be useless. To be checked. */
    function save ($list) {
        global $jstree;
        $datas = $jstree->get_datas($this->item['id']);
        if (!isset($datas['serverslist'])) { $datas['serverslist'] = array(); }
        $datas['serverslist']['manuallist'] = $list;
        $jstree->set_datas($this->item['id'], $datas);
        return true;
    }

    function save_sort ($sort) {
        global $jstree;
        $datas = $jstree->get_datas($this->item['id']);
        $datas['sort'] = $sort;
        $jstree->set_datas($this->item['id'], $datas);
        return true;
    }

    function get_config_list () {
        global $collectd_sources;
        return array_keys($collectd_sources);
    }

    function save_cdsrc ($cdsrc) {
        global $jstree;
        if($cdsrc == "Inherit from parent") {
            $jstree->set_node_collectd_source($this->item['id'], "");
        } else {
            $jstree->set_node_collectd_source($this->item['id'], $cdsrc);
        }
        return true;
    }
}

?>
