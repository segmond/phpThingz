<?php

class FormatHelper
{
    private $topper;
    private $bottom;

    public function addTop() {
        $this->topper = <<< _EOS_
<html><head><title>Map Factory</title><head>
<body>
_EOS_;
        return $this->topper;
    }

    public function closeUp() {
        $this->bottom = "</body></html>";
        return $this->bottom;
    }
}
?>
