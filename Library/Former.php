<?php
/**
 * CodeIgniter form builder from database table column types.
 *
 * @author Tomaz Lovrec <tomaz.lovrec@gmail.com>
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Former
{
    /**
     * CodeIgniter instance
     *
     * @var object
     */
    protected $_ci = null;
    /**
     * Table column data
     *
     * @var array
     */
    protected $_columns = array();

    public function __construct($params)
    {
        // get the CodeIgniter object
        $this->_ci = &get_instance();

        // initiate the database
        $this->_ci->load->database();

        // get table columns
        if (isset($params["columns"])) {
            $this->_columns = $params["columns"];
        } elseif (isset($params["table"])) {
            $this->_getTableData($params["table"]);
        } else {
            throw new Exception("Either columns or table must be passed to the Former library");
        }
    }

    public function getForm()
    {
        $form = "";
        foreach ($this->_columns as $c) {
            $data = array(
                "name"  =>  $c->name,
                "value" =>  ""
            );
            if ($c->primary_key == true) {
                $form .= $this->_ci->load->view("former/hidden", $data, true);
            } else {
                switch ($c->type) {
                    case "varchar":
                        $form .= $this->_ci->load->view("former/varchar", $data, true);
                        break;
                    case "int":
                        $form .= $this->_ci->load->view("former/int", $data, true);
                        break;
                    case "text":
                        $form .= $this->_ci->load->view("former/text", $data, true);
                        break;
                    default:
                        break;
                }
            }
        }
        return $form;
    }

    protected function _getTableData($table)
    {
        $this->_columns = $this->_ci->db->field_data($table);
        var_dump($this->_columns);
    }
}
