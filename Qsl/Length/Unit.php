<?php
class Qsl_Length_Unit {
    const METER         = 'm';
    const METRE         = 'm';
    const MILLIMETER    = 'mm';
    const MILLIMETRE    = 'mm';
    const CENTIMETER    = 'cm';
    const CENTIMETRE    = 'cm';
    const KILOMETER     = 'km';
    const KILOMETRE     = 'km';
    const YARD          = 'y';
    const FEET          = 'f';
    const INCH          = 'in';
    const POINT         = 'pt';

    // 変換係数
    const COEFFICIENT_mm    = 0.001;
    const COEFFICIENT_cm    = 0.010;
    const COEFFICIENT_m     = 1.000;
    const COEFFICIENT_km    = 1000.0;
    const COEFFICIENT_y     = 0.9144;               // 1y は正確に 0.9144 m
    const COEFFICIENT_f     = 0.3048;               // (1/3)y
    const COEFFICIENT_in    = 0.0254;               // (1/12)f
    const COEFFICIENT_pt    = 0.000352777777777778; // (1/72)in

    private
        $in_meter = 0.0;

    public function __construct($size, $unit = self::METER) {
        $this->set($size, $unit);
    }

    public function get($unit = self::METER) {
        return self::convert($this->in_meter, self::METER, $unit);
    }

    public function set($size, $unit = self::METER) {
        $this->in_meter = self::convert($size, $unit, self::METER);
        return $this;
    }

    public function add(Qsl_Length_Unit $size) {
        $this->in_meter += $size->get(self::METER);
        return $this;
    }

    public function sub(Qsl_Length_Unit $size) {
        $this->in_meter -= $size->get(self::METER);
        return $this;
    }

    public function mul($count) {
        $this->in_meter *= $count;
        return $this;
    }

    public function div($by) {
        $this->in_meter /= $by;
        return $this;
    }

    static public function add_(Qsl_Length_Unit $a, Qsl_Length_Unit $b) {
        $obj = new self($a->in_meter, self::METER);
        return $obj->add($b);
    }

    static public function sub_(Qsl_Length_Unit $a, Qsl_Length_Unit $b) {
        $obj = new self($a->in_meter, self::METER);
        return $obj->sub($b);
    }

    static public function mul_(Qsl_Length_Unit $a, $b) {
        $obj = new self($a->in_meter, self::METER);
        return $obj->mul($b);
    }

    static public function div_(Qsl_Length_Unit $a, $b) {
        $obj = new self($a->in_meter, self::METER);
        return $obj->div($b);
    }

    public function __get($unit) {
        return $this->get($unit);
    }

    public function __set($unit, $size) {
        $this->set($size, $unit);
    }

    static public function convert($size, $unit_from, $unit_to) {
        if($unit_from === $unit_to) {
            return (double)$size;
        }
        if($unit_from !== self::METER) {
            $coefficient_name = 'Qsl_Length_Unit::COEFFICIENT_' . $unit_from;
            if(!defined($coefficient_name)) {
                throw new Qsl_Length_Unit_Exception('Cannot convert from ' . $unit_from);
            }
            //printf('%.2f %s -> ', $size, $unit_from);
            $size = $size * constant($coefficient_name);
            //printf("%.2f m\n", $size);
        }
        if($unit_to !== self::METER) {
            $coefficient_name = 'Qsl_Length_Unit::COEFFICIENT_' . $unit_to;
            if(!defined($coefficient_name)) {
                throw new Qsl_Length_Unit_Exception('Cannot convert to ' . $unit_to);
            }
            $size = $size / constant($coefficient_name);
        }
        return (double)$size;
    }
}
