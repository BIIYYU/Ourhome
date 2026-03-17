<?php
class Template
{
    protected $_CI;

    var $API = "";

    function __construct()
    {
        $this->_CI = &get_instance();
    }

    function display($template, $data = null)
    {
        $data['_content'] = $this->_CI->load->view($template, $data, true);
        $data['_topbar'] = $this->_CI->load->view('template/topbar', $data, true);
        $data['_sidebar'] = $this->_CI->load->view('template/sidebar', $data, true);
        $data['_footer'] = $this->_CI->load->view('template/foot', $data, true);
        $data['_js'] = $this->_CI->load->view('template/js', $data, true);
        $this->_CI->load->view('/template.php', $data);
    }
}
