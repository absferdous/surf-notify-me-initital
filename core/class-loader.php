<?php
class SSN_Loader {
    private $services = [];

    public function add_service($service) {
        $this->services[] = $service;
    }

    public function run() {
        foreach ($this->services as $service) {
            if (method_exists($service, 'register_hooks')) {
                $service->register_hooks();
            }
        }
    }
}