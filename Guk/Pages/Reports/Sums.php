<?php

namespace Guk\Pages\Reports;


class Sums
{
    use \OLOG\Model\ProtectProperties;

    public $requested = 0;
    public $corrected = 0;
    public $cut = 0;

    public function append($requested = 0, $corrected = 0, $cut = 0){
        $this->requested += $requested;
        $this->corrected += $corrected;
        $this->cut += $cut;
    }

    public function render(){
        ob_start();

        echo '<div class="requested_sum_visibility">' . $this->requested . '</div>';
        echo '<div class="corrected_sum_visibility">' . $this->corrected . '</div>';
        echo '<div class="cut_sum_visibility">' . ($this->requested - $this->corrected) . '</div>';

        return ob_get_clean();
    }
}