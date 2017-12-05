<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template {

    function __construct()
    {
        log_message('debug', "Template Class Initialized");
    }

    // --------------------------------------------------------------------

    function load($template = '', $view = array(), $vars = array(), $return = FALSE)
    {
        $this->CI =& get_instance();
        $tpl = array();

        // Check for partials to load
        if (count($view) > 0)
        {
            // Load views into var array
            foreach($view as $key => $file)
            {
                $tpl[$key] = $this->CI->load->view($file, $vars, TRUE);
            }
            // Merge into vars array
            $vars = array_merge($vars, $tpl);
        }

        // Load master template
        return $this->CI->load->view($template, $vars, $return);
    }
}

?>
