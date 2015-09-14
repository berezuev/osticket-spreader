<?php
 
/**
 * Description of plugin
 * @author Alexey Berezuev <alexey@berezuev.ru>
 * @license http://opensource.org/licenses/MIT
 * @version 0.1
 */
 
require_once(INCLUDE_DIR . 'class.plugin.php');
require_once(INCLUDE_DIR . 'class.signal.php');
require_once(INCLUDE_DIR . 'class.app.php');
 
require_once('config.php');

class SpreaderPlugin extends Plugin {
 
    var $config_class = 'SpreaderConfig';
    static private $config;
    function bootstrap() {
        self::$config = self::getConfig();
        if (!self::$config->get('spreader_current_staff')) {
            self::$config->set('spreader_current_staff', 0);
        }   
        $object = Signal::connect('model.created', array('SpreaderPlugin', 'spreadTicket'));
    }
    
    function getCurrentStaffId() {
        $staff = self::$config->getStaffList();
        $plugin_staff = array();
        $current_staff = self::$config->get('spreader_current_staff');
        foreach ($staff as $id => $fullname) {
            if(self::$config->get("spreader_staff_id_".$id)){
                array_push($plugin_staff, $id);
            }
        }
        $current = $plugin_staff[$current_staff];
        if($current_staff >= count($plugin_staff)-1){
            self::$config->set('spreader_current_staff', 0);
        } else {
            self::$config->set('spreader_current_staff', self::$config->get('spreader_current_staff')+1);
        }
        return $current;
    }

    function isCategorySelected($cid) {
        return self::$config->get("spreader_category_id_".$cid);
    }

    function spreadTicket($object, $data){
        if (get_class($object) == "Ticket") {
            $cid = $object->getTopicId();
            self::$config = self::getConfig();
            if (self::isCategorySelected($cid)){
                $staff_id = self::getCurrentStaffId();
                $object->setStaffId($staff_id);
                return true;
            }
        }
        return false;
    }
 
}
