<?php
    interface Describable {
        public function getInfo();
    }

    trait Logger {
        public function log($message) {
            echo "[LOG SYSTEM]: " . $message . "<br>";    
        }
    }

    class Device {
        public $brand;
        protected $model;
        private $serialNumber;

        public function __construct($brand, $model, $serialNumber)
        {
            $this->brand = $brand;
            $this->model = $model;
            $this->serialNumber = $serialNumber;
        }

        public function getBrand() {
            return $this->brand;
        }

        public function getModel() {
            return $this->model;
        }

        public function getSerialNumber() {
            return $this->serialNumber;
        }

        public function setSerialNumber($serialNumber) {
            $this->serialNumber = $serialNumber;
        }
        
        public function getFullDeviceName() {
            return $this->brand . ' ' . $this->model;
        }
    }
    
    class SmartLamp extends Device implements Describable {
        use Logger;
        protected $room;

        public function __construct($brand, $model, $serialNumber, $room) {
            parent::__construct($brand, $model, $serialNumber);
            $this->room = $room;
        }

        public function checkStatus($is_on) {
        if ($is_on == true) {
            $this->log("Устройство " . $this->getFullDeviceName() . " включено");
        }
        else {
            $this->log("Устройство " . $this->getFullDeviceName() . " выключено");
        }
        }

        public function getInfo() {
            return "Умный прибор: {$this->getFullDeviceName()}, локация: {$this->room}";
        }
    }

    class Automation {
        use Logger;

        public function create() {
            $this->log("Сценарий автоматизации создан");
        }
    }
?> 
