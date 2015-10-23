<?php
namespace Controller;

/**
 * Controls the login / main page. This is the default view controller.
 *
 * @author Thomas Eynon
 */
class HomeViewController extends BaseViewController {
    
    public function __construct() {
        parent::__construct();
        $this->ViewData['page_title'] = "Eynon - Simplifying Software";
    }
    
    public function Default_GET() {
        $this->ViewData['page_title'] = "Eynon - Simplifying Software";
        $this->templateFile = "default-home.php";
        return $this->View("Home");
    }
    
    public function Services_GET() {
        $this->ViewData['page_title'] = "Services - Eynon";
        return $this->View("Services");
    }
    
    public function About_GET() {
        $this->ViewData['page_title'] = "About - Eynon";
        return $this->View("About");
    }
    
    public function Contact_GET() {
        $this->ViewData['page_title'] = "Contact - Eynon";
        return $this->View("Contact");
    }
}
