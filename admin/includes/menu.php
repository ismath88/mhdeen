<?php

class menu {
    /* $session = new sessions();
      /*$admin_type = $session->get('type'); */

    public $menus = array(
        "Manage Rates" => array("Manage Rates" => 'form_unit.php'),
        "Manage Categories" => array("Manage Links" => 'categories.php',
            "Create Links" => 'add_categories.php'),
        "Manage Links" => array("Manage Links" => 'links.php',
            "Create Links" => 'add_links.php'),
       "Send Rates" => array("Send Rates" => 'subscribers.php'),
        "Custome Message" => array("Custome Message" => 'custome-messages.php'),
        "Logout" => array("logout.php")
    );
    public $active_module;
    public $active_sub_module;
    public $top_menu;
    public $sub_menu;
    public $location;

    public function __construct() {
        $this->get_location();
        $session = new sessions();
        $type = $session->get('type');

        if ($type == "super") {
            $this->get_menu();
            $this->get_sub_menu();
        } else {
            $this->get_menu1();
            $this->get_sub_menu1();
        }



        //$this->get_sub_menu();
    }

    function get_menu() {
        $this->top_menu = '<ul>';
        foreach ($this->menus as $key => $files) {

            $str = "";
            if (in_array($this->location, $files)) {
                $str = 'id="active"';
                $this->active_module = $key;
            }
            $keys = array_keys($files);
            //print_r($files[$keys[0]]); print("<br/>");

            $class = strtolower($key);
            $i++;
            $this->top_menu.='<li class="' . $class . '"><a href="' . $files[$keys[0]] . '"' . $str . '>' . $key . '</a></li>';
            unset($files);
        }
        $this->top_menu.='</ul>';
        $this->top_menu.='<div class="both"></div>';
    }

    function get_menu1() {
        $this->top_menu = '<ul>';
        foreach ($this->menus1 as $key => $files) {

            $str = "";
            if (in_array($this->location, $files)) {
                $str = 'id="active"';
                $this->active_module = $key;
            }
            $keys = array_keys($files);
            //print_r($files[$keys[0]]); print("<br/>");

            $class = strtolower($key);
            $i++;
            $this->top_menu.='<li class="' . $class . '"><a href="' . $files[$keys[0]] . '"' . $str . '>' . $key . '</a></li>';
            unset($files);
        }
        $this->top_menu.='</ul>';
        $this->top_menu.='<div class="both"></div>';
    }

    function get_sub_menu() {
        $this->sub_menu = '<ul>';
        if (is_array($this->menus[$this->active_module]))
            foreach ($this->menus[$this->active_module] as $key => $file) {
                $str = "";
                if ($this->location == $file) {
                    $str = 'id="active"';
                    $this->active_sub_module = $key;
                }


                $class = str_replace(" ", "_", strtolower($key));
                $this->sub_menu.='<li class="' . $class . '"><a href="' . $file . '"' . $str . '>' . $key . '</a></li>';
            }
        $this->sub_menu.='</ul>';
        $this->sub_menu.='<div class="both"></div>';
        if (count($this->menus[$this->active_module]) < 2) {
            $this->sub_menu = '';
        }
    }

    function get_sub_menu1() {
        $this->sub_menu = '<ul>';
        if (is_array($this->menus1[$this->active_module]))
            foreach ($this->menus1[$this->active_module] as $key => $file) {
                $str = "";
                if ($this->location == $file) {
                    $str = 'id="active"';
                    $this->active_sub_module = $key;
                }


                $class = str_replace(" ", "_", strtolower($key));
                $this->sub_menu.='<li class="' . $class . '"><a href="' . $file . '"' . $str . '>' . $key . '</a></li>';
            }
        $this->sub_menu.='</ul>';
        $this->sub_menu.='<div class="both"></div>';
        if (count($this->menus1[$this->active_module]) < 2) {
            $this->sub_menu = '';
        }
    }

    function get_location() {
        $page = split("[/]", $_SERVER['PHP_SELF']);
        $n = count($page);
        $page = $page[$n - 1];
        $this->location = $page;
    }

    function Dateformate($date) {
        list($y, $m, $d) = split('[-]', $date);
        return $d . '-' . $m . '-' . $y;
    }

}

?>