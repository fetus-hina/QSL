<?php
// RAII class
// Zend_Pdf_Canvas_Interface::saveGS() and restoreGS() wrapper
class Qsl_GraphicStateHolder {
    private $target = null; // Zend_Pdf_Canvas_Interface

    public function __construct(Zend_Pdf_Canvas_Interface $canvas) {
        $this->target = $canvas;
        $this->target->saveGS();
    }

    public function __destruct() {
        $this->target->restoreGS();
    }

    private function __clone() {
    }
}
