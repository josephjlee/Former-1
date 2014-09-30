<?php
/**
 * CodeIgniter form builder from database table column types.
 *
 * Needs a way better description
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
                "name"      =>  $c->name,
                "length"    =>  $c->max_length ? $c->max_length : "disabled",
                "value"     =>  ""
            );
            if ($c->primary_key == true) {
                $form .= $this->_ci->load->view("former/hidden", $data, true);
            } else {
                switch ($c->type) {
                    case "char":
                    case "varchar":
                        $form .= $this->_ci->load->view("former/varchar", $data, true);
                        break;
                    case "tinyint":
                    case "smallint":
                    case "mediumint":
                    case "bigint":
                    case "int":
                        $form .= $this->_ci->load->view("former/int", $data, true);
                        break;
                    case "double":
                    case "float":
                    case "decimal":
                        $form .= $this->_ci->load->view("former/double", $data, true);
                        break;
                    case "tinytext":
                    case "mediumtext":
                    case "longtext":
                    case "text":
                        $form .= $this->_ci->load->view("former/text", $data, true);
                        break;
                    case "date":
                        $form .= $this->_ci->load->view("former/date", $data, true);
                        break;
                    case "time":
                        $form .= $this->_ci->load->view("former/time", $data, true);
                        break;
                    case "datetime":
                        $form .= $this->_ci->load->view("former/datetime", $data, true);
                        break;
                    case "timestamp":
                        $form .= $this->_ci->load->view("former/timestamp", $data, true);
                        break;
                    case "enum":
                        $form .= $this->_ci->load->view("former/dropdown", $data, true);
                        break;
                    case "set":
                        $form .= $this->_ci->load->view("former/dropdown", $data, true);
                        break;
                    case "bit":
                        $form .= $this->_ci->load->view("former/radio", $data, true);
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
        //var_dump($this->_columns);
    }
}
