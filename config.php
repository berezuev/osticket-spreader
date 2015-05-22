<?php
 
/**
 * Description of plugin
 * @author Alexey Berezuev <alexey@berezuev.ru>
 * @license http://opensource.org/licenses/MIT
 * @version 0.1
 */
 
require_once(INCLUDE_DIR.'/class.plugin.php');
require_once(INCLUDE_DIR.'/class.forms.php');

class SpreaderConfig extends PluginConfig{
    function getStaffList() {
        $staff = array();
        $sql = "SELECT `staff_id` AS `id`, CONCAT_WS(' ', `firstname`, `lastname`) AS `fullname` FROM ".TABLE_PREFIX."staff";
        $result = db_query($sql);
        while($row = db_fetch_array($result)) {
            $staff[$row['id']] = $row['fullname'];
        }
        return $staff;
    }

    function getCategoriesList() {
        $category = array();
        $sql = "SELECT `topic_id` AS `id`, `topic` FROM ".TABLE_PREFIX."help_topic";
        $result = db_query($sql);
        while($row = db_fetch_array($result)) {
            $category[$row['id']] = $row['topic'];
        }
        return $category;
    }

    function getOptions() {
        $options = array();
        $options['staff_title'] = new SectionBreakField(
                array(
                    'label' => 'Staff',
                )
            );
        foreach ($this->getStaffList() as $id => $staff) { 
            $options['spreader_staff_id_'.$id] = new BooleanField(
                array(
                    'id' => "spreader_staff_id_".$id,
                    'label' => $staff,
                )
            );
        }
        $options['category_title'] = new SectionBreakField(
                array(
                    'label' => 'Categories',
                )
            );
        foreach ($this->getCategoriesList() as $id => $category) {

            $options['spreader_category_id_'.$id] = new BooleanField(
                array(
                    'id' => "spreader_category_id_".$id,
                    'label' => $category,
                    )
                );
        }
        return $options;
    }
 
    function pre_save(&$config, &$errors) {
        global $msg;
        if (!$errors)
            $msg = 'Configuration updated successfully';
        return true;
    }
}