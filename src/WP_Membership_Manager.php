<?php

namespace Wp_Membership_Manager;

use Wp_Membership_Manager\Controller\Dashboard_Controller;
use Wp_Membership_Manager\Controller\Role_Controller;
use Wp_Membership_Manager\Interface\Controller_Interface;
use Wp_Membership_Manager\Exception\Not_Found_Exception;

final class WP_Membership_Manager
{
    private array $controllers = [];

    public function init(): void
    {
        $this->controllers = apply_filters("wp_mm_controllers", $this->getControllers());
    }

    public function run(): void
    {
        foreach($this->controllers as $controller) {

            if (! class_exists($controller)) {
                throw new Not_Found_Exception(sprintf(__("%s not found", "wp-membership-manager"), $controller));
            };

            $controllerI = new $controller;
            if (! is_a($controllerI, Controller_Interface::class)) {
                throw new Not_Found_Exception(sprintf(__("%s not implement Controller_Interface", "wp-membership-manager"), $controller));
            };

            $controllerI->register();
        }
    }

    private function getControllers(): array
    {
        return [
            Dashboard_Controller::class,
            Role_Controller::class,
        ];
    }
}