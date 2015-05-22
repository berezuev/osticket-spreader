<?php
 
/**
 * Description of plugin
 * @author Alexey Berezuev <alexey@berezuev.ru>
 * @license http://opensource.org/licenses/MIT
 * @version 0.1
 */
 
set_include_path(get_include_path().PATH_SEPARATOR.dirname(__file__).'/include');

return array(
    'id' => 'berezuev:osticket-spreader',
    'version' => '0.1',
    'name' => 'osticket-spreader',
    'author' => 'Alexey Berezuev',
    'description' => 'Spread tickets evenly between several managers.',
    'url' => 'https://github.com/berezuev/osticket-spreader',
    'plugin' => 'spreader.php:SpreaderPlugin'
);