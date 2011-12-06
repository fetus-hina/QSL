<?php
class Qsl_Card {
    const BAND_50M      = '50MHz';
    const BAND_145M     = '145MHz';
    const BAND_430M     = '430MHz';

    const QSL_PLEASE = 'please';
    const QSL_THANKS = 'thanks';

    // カード全体のサイズ
    const CARD_WIDTH_MM     = 100.0;
    const CARD_HEIGHT_MM    = 148.0;

    // JARL 転送枠
    const JARL_TOP_MM           = 11.0;
    const JARL_LEFT_1_MM        = 39.5;
    const JARL_LEFT_2_MM        = 48.5;
    const JARL_LEFT_3_MM        = 57.5;
    const JARL_LEFT_4_MM        = 66.5;
    const JARL_LEFT_5_MM        = 75.5;
    const JARL_LEFT_6_MM        = 84.5;
    const JARL_CELL_HEIGHT_MM   =  9.0;
    const JARL_CELL_WIDTH_MM    =  6.5;

    // To Radio
    const TO_RADIO_LEFT_MM      =  9.0;
    const TO_RADIO_WIDTH_MM     = 26.0;
    const TO_RADIO_TOP_MM       = 11.0;
    const TO_RADIO_HEIGHT_MM    =  9.0;

    // 証明書
    const BOX_TOP_MM            = 30.0;
    const BOX_HEADER_HEIGHT_MM  =  5.0;
    const BOX_BODY_HEIGHT_MM    = 12.5;
    const BOX_LEFT_MM           =  9.0;
    const BOX_WIDTH_MM          = 82.0;
    const BOX_DATETIME_LEFT_MM  = self::BOX_LEFT_MM;
    const BOX_RST_LEFT_MM       = 50.0;
    const BOX_BAND_LEFT_MM      = 63.667;
    const BOX_MODE_LEFT_MM      = 77.333;
    const BOX_AREA_WIDTH_MM     = 13.6667;

    // 追加データ領域
    const DATA_TOP_1_MM         =  47.5; // Rig
    const DATA_TOP_2_MM         =  53.5; // Ant
    const DATA_TOP_3_MM         =  59.5; // Rmks
    const DATA_TOP_4_MM         =  65.5; // TNX FB QSO
    const DATA_TOP_5_MM         =  77.5; // QRA/OP
    const DATA_TOP_6_MM         =  89.5; // QTH(Home)
    const DATA_TOP_7_MM         =  95.5; // QTH(Portable)
    const DATA_TOP_8_MM         = 101.5; // not used yet
    const DATA_LEFT             =   9.0;
    const DATA_LEFT_OUTPUT      =  63.667;
    const DATA_WIDTH            =  82.0;
    const DATA_LINE_HEIGHT_S_MM =  6.0;
    const DATA_LINE_HEIGHT_B_MM =  12.0;
    const DATA_BODY_LEFT_OFFSET_MM = 10.0;

    // フォント
    const FONT_PATH                 = '../font.ttf';
    const BASELINE_POSITION         = 0.65;
    const FONT_SIZE_JARL_PT         = 26.0;
    const FONT_SIZE_H_TO_RADIO_PT   = 10.0;
    const FONT_SIZE_TO_RADIO_MAX_PT = 18.0;
    const FONT_SIZE_TO_RADIO_MIN_PT =  8.0;
    const FONT_SIZE_HIS_IDO_PT      = 10.0;
    const FONT_SIZE_CONFIRM_PT      = 13.0;
    const FONT_SIZE_QSL_NUMBER_PT   =  9.0;
    const FONT_SIZE_REPORT_HEADER_PT= 10.0;
    const FONT_SIZE_REPORT_BODY_PT  = 10.0;
    const FONT_SIZE_DATA_SMALL_PT   = 10.0;
    const FONT_SIZE_DATA_BIG_PT     = 20.0;

    private $page = null;

    private
        $callsign   = 'JB1ABC',
        $to_radio   = 'JB1ABC/1',
        $his_ido    = '',
        $number     = '',
        $datetime   = 0,
        $rs         = '59',
        $band       = self::BAND_145M,
        $twoway     = true,
        $mode       = 'FM',
        $rig        = 'Rig Name Here',
        $output     = '10W',
        $ant        = 'Antenna data here(5mH)',
        $remarks    = '今後ともよろしくお願いします',
        $qsl        = self::QSL_PLEASE,
        $qra        = 'JC1QRA',
        $qth        = '東京都千代田区千代田1-1',
        $op         = '日本太郎',
        $my_ido     = '';

    public function __construct() {
        $this->page = 
            new Zend_Pdf_Page(
                Qsl_Length_Unit::convert(self::CARD_WIDTH_MM, 'mm', 'pt'),
                Qsl_Length_Unit::convert(self::CARD_HEIGHT_MM, 'mm', 'pt'));
    }

    public function setCallsign($callsign) {
        $this->callsign = $callsign;
        return $this;
    }

    public function setToRadio($callsign) {
        $this->to_radio = $callsign;
        return $this;
    }

    public function setHisIdo($qth) {
        $this->his_ido = $qth;
        return $this;
    }

    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }

    public function setDatetime($unixtime) {
        $this->datetime = (int)$unixtime;
        return $this;
    }

    public function setRs($rs) {
        $this->rs = $rs;
        return $this;
    }

    public function setBand($band) {
        $this->band = $band;
        return $this;
    }

    public function setIsTwoWay($is_twoway) {
        $this->twoway = !!$is_twoway;
        return $this;
    }

    public function setMode($mode) {
        $this->mode = $mode;
        return $this;
    }

    public function setRig($rig, $output) {
        $this->rig = $rig;
        $this->output = $output;
        return $this;
    }

    public function setAntenna($ant) {
        $this->ant = $ant;
        return $this;
    }

    public function setRemarks($rmks) {
        $this->remarks = $rmks;
        return $this;
    }

    public function setQsl($value) { // QSL_PLEASE, QSL_THANKS
        $this->qsl = $value;
        return $this;
    }

    public function setQra($callsign) {
        $this->qra = $callsign;
        return $this;
    }

    public function setHomeQth($qth) {
        $this->qth = $qth;
        return $this;
    }

    public function setIdoQth($qth) {
        $this->my_ido = $qth;
        return $this;
    }

    public function setOperatorName($name) {
        $this->op = $name;
        return $this;
    }

    public function build() {
        $this->initGS();
        $this->drawLines();
        $this->drawFixedTexts();
        $this->drawTexts();
        return $this->page;
    }

    private function drawLines() {
        $gs = $this->saveGS();
        $this->drawJarlBoxes();
        $this->drawToRadioLine();
        $this->drawReportBox();
        $this->drawDataLines();
    }

    private function drawJarlBoxes() {
        $gs = $this->saveGS();
        $this->setLineColorRed();
        $this->page->setLineWidth(Qsl_Length_Unit::convert(0.35, 'mm', 'pt'));
        for($i = 1; $i <= 6; ++$i) {
            $x1 = constant(sprintf('%s::JARL_LEFT_%d_MM', __CLASS__, $i));
            $this->drawBox(
                $x1,
                self::JARL_TOP_MM,
                $x1 + self::JARL_CELL_WIDTH_MM,
                self::JARL_TOP_MM + self::JARL_CELL_HEIGHT_MM);
        }
    }
    
    private function drawToRadioLine() {
        $this->drawLine(
            self::TO_RADIO_LEFT_MM,
            self::TO_RADIO_TOP_MM + self::TO_RADIO_HEIGHT_MM,
            self::TO_RADIO_LEFT_MM + self::TO_RADIO_WIDTH_MM,
            self::TO_RADIO_TOP_MM + self::TO_RADIO_HEIGHT_MM);
    }

    private function drawReportBox() {
        $this->drawBox(
            self::BOX_LEFT_MM,
            self::BOX_TOP_MM,
            self::BOX_LEFT_MM + self::BOX_WIDTH_MM,
            self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM + self::BOX_BODY_HEIGHT_MM);

        // ヘッダ/ボディ区切り
        $this->drawLine(
            self::BOX_LEFT_MM,
            self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM,
            self::BOX_LEFT_MM + self::BOX_WIDTH_MM,
            self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM);

        // 項目区切り
        $xs = array(self::BOX_RST_LEFT_MM, self::BOX_BAND_LEFT_MM, self::BOX_MODE_LEFT_MM);
        foreach($xs as $x) {
            $this->drawLine(
                $x,
                self::BOX_TOP_MM,
                $x,
                self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM + self::BOX_BODY_HEIGHT_MM);
        }
    }

    private function drawDataLines() {
        $ys = array(self::DATA_TOP_2_MM, self::DATA_TOP_3_MM, self::DATA_TOP_4_MM);
        foreach($ys as $y) {
            $this->drawLine(
                self::DATA_LEFT, $y,
                self::DATA_LEFT + self::DATA_WIDTH, $y);
        }
    }

    private function initGS() {
        $this->setLineColorBlack();
        $this->page->setLineWidth(Qsl_Length_Unit::convert(0.15, 'mm', 'pt'));
    }

    private function drawLine($x1_mm, $y1_mm, $x2_mm, $y2_mm) {
        $this->page->drawLine(
            self::x($x1_mm), self::y($y1_mm),
            self::x($x2_mm), self::y($y2_mm));
        return $this;
    }

    private function drawBox($x1_mm, $y1_mm, $x2_mm, $y2_mm, $filltype = Zend_Pdf_Page::SHAPE_DRAW_STROKE) {
        $this->page->drawRectangle(
            self::x($x1_mm), self::y($y1_mm),
            self::x($x2_mm), self::y($y2_mm),
            $filltype);
        return $this;
    }

    private function drawFixedTexts() {
        $this->drawToRadioHeading();
        $this->drawConfirmOurQSO();
        $this->drawQslNumber();
        $this->drawBoxHeader();
        $this->drawDataHeading();
        $this->drawTnx();
    }

    private function drawToRadioHeading() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_H_TO_RADIO_PT);
        $this->drawTextLeftTop('To Radio', self::TO_RADIO_LEFT_MM, self::TO_RADIO_TOP_MM);
    }

    private function drawConfirmOurQSO() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_CONFIRM_PT);
        $this->drawTextLeftBottom('Confirming Our QSO.', self::BOX_LEFT_MM, self::BOX_TOP_MM);
    }

    private function drawQslNumber() {
        if($this->number == '') {
            return;
        }
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_QSL_NUMBER_PT);
        $this->drawTextRightBottom(
            '#' . $this->number,
            self::BOX_LEFT_MM + self::BOX_WIDTH_MM,
            self::BOX_TOP_MM);
    }

    private function drawBoxHeader() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_REPORT_HEADER_PT);
        $this->drawTextCenterMiddle('Date / Time', self::BOX_DATETIME_LEFT_MM, self::BOX_TOP_MM, self::BOX_AREA_WIDTH_MM * 3, self::BOX_HEADER_HEIGHT_MM);
        $this->drawTextCenterMiddle('RS', self::BOX_RST_LEFT_MM, self::BOX_TOP_MM, self::BOX_AREA_WIDTH_MM, self::BOX_HEADER_HEIGHT_MM);
        $this->drawTextCenterMiddle('Band', self::BOX_BAND_LEFT_MM, self::BOX_TOP_MM, self::BOX_AREA_WIDTH_MM, self::BOX_HEADER_HEIGHT_MM);
        $this->drawTextCenterMiddle('Mode', self::BOX_MODE_LEFT_MM, self::BOX_TOP_MM, self::BOX_AREA_WIDTH_MM, self::BOX_HEADER_HEIGHT_MM);
    }

    private function drawDataHeading() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextLeftMiddle('Rig:',  self::DATA_LEFT, self::DATA_TOP_1_MM, self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextLeftMiddle('Ant:',  self::DATA_LEFT, self::DATA_TOP_2_MM, self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextLeftMiddle('Rmks:', self::DATA_LEFT, self::DATA_TOP_3_MM, self::DATA_LINE_HEIGHT_S_MM);

        $this->drawTextLeftMiddle('Output:',  self::DATA_LEFT_OUTPUT, self::DATA_TOP_1_MM, self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextLeftMiddle(
            'OP:',
            self::DATA_LEFT,
            self::DATA_TOP_5_MM,
            self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextLeftMiddle(
            'Home:',
            self::DATA_LEFT,
            self::DATA_TOP_6_MM,
            self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextLeftMiddle(
            'QTH:',
            self::DATA_LEFT,
            self::DATA_TOP_7_MM,
            self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawTnx() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextRightMiddle('TNX FB QSO.',  self::DATA_LEFT + self::DATA_WIDTH, self::DATA_TOP_4_MM, self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawTexts() {
        $this->drawJarlCallsign();
        $this->drawToRadio();
        $this->drawHisIdo();
        $this->drawReport();
        $this->drawRig();
        $this->drawAntenna();
        $this->drawRemarks();
        $this->drawQSL();
        $this->drawOperator();
        $this->drawQTH();
    }

    private function drawJarlCallsign() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_JARL_PT);
        for($i = 1; $i <= 6; ++$i) {
            $this->drawTextCenterMiddle(
                mb_substr($this->callsign, $i - 1, 1, 'UTF-8'),
                constant(sprintf('%s::JARL_LEFT_%d_MM', __CLASS__, $i)),
                self::JARL_TOP_MM,
                self::JARL_CELL_WIDTH_MM,
                self::JARL_CELL_HEIGHT_MM);
        }
    }

    private function drawToRadio() {
        $gs = $this->saveGS();
        for($font_size = self::FONT_SIZE_TO_RADIO_MAX_PT;
            $font_size >= self::FONT_SIZE_TO_RADIO_MIN_PT;
            --$font_size)
        {
            $width_mm = Qsl_Length_Unit::convert($font_size * mb_strwidth($this->to_radio, 'UTF-8') / 2, 'pt', 'mm');
            if($font_size === self::FONT_SIZE_TO_RADIO_MIN_PT ||
               $width_mm <= self::TO_RADIO_WIDTH_MM)
            {
                $this->setFont($font_size);
                $this->drawTextCenterBottom(
                    $this->to_radio,
                    self::TO_RADIO_LEFT_MM,
                    self::TO_RADIO_TOP_MM + self::TO_RADIO_HEIGHT_MM,
                    self::TO_RADIO_WIDTH_MM);
                return;
            }
        }
    }

    private function drawHisIdo() {
        if($this->his_ido == '') {
            return;
        }
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_HIS_IDO_PT);
        $this->drawTextLeftTop(
            $this->his_ido, 
            self::TO_RADIO_LEFT_MM,
            self::TO_RADIO_TOP_MM + self::TO_RADIO_HEIGHT_MM + 1);
    }

    private function drawReport() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_REPORT_BODY_PT);
        $this->drawTextCenterMiddle(
            sprintf(
                "%s JST\n(%s UTC)",
                gmdate('Y-m-d H:i', $this->datetime + 9 * 3600),
                gmdate('d M Y H:i', $this->datetime)),
            self::BOX_DATETIME_LEFT_MM,
            self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM,
            self::BOX_AREA_WIDTH_MM * 3,
            self::BOX_BODY_HEIGHT_MM);
        $this->drawTextCenterMiddle(
            $this->rs,
            self::BOX_RST_LEFT_MM,
            self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM,
            self::BOX_AREA_WIDTH_MM,
            self::BOX_BODY_HEIGHT_MM);
        $this->drawTextCenterMiddle(
            $this->band,
            self::BOX_BAND_LEFT_MM,
            self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM,
            self::BOX_AREA_WIDTH_MM,
            self::BOX_BODY_HEIGHT_MM);
        $this->drawTextCenterMiddle(
            ($this->twoway ? "2-Way\n" : '') . $this->mode,
            self::BOX_MODE_LEFT_MM,
            self::BOX_TOP_MM + self::BOX_HEADER_HEIGHT_MM,
            self::BOX_AREA_WIDTH_MM,
            self::BOX_BODY_HEIGHT_MM);
    }

    private function drawRig() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextLeftMiddle(
            $this->rig,
            self::DATA_LEFT + self::DATA_BODY_LEFT_OFFSET_MM,
            self::DATA_TOP_1_MM,
            self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextRightMiddle(
            $this->output,
            self::DATA_LEFT + self::DATA_WIDTH,
            self::DATA_TOP_1_MM,
            self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawAntenna() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextLeftMiddle(
            $this->ant,
            self::DATA_LEFT + self::DATA_BODY_LEFT_OFFSET_MM,
            self::DATA_TOP_2_MM,
            self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawRemarks() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextLeftMiddle(
            $this->remarks,
            self::DATA_LEFT + self::DATA_BODY_LEFT_OFFSET_MM,
            self::DATA_TOP_3_MM,
            self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawQSL() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextLeftMiddle(
            $this->qsl === self::QSL_THANKS ? 'QSL Thank You' : 'Please QSL',
            self::DATA_LEFT,
            self::DATA_TOP_4_MM,
            self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawOperator() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextLeftMiddle(
            $this->qra,
            self::DATA_LEFT + self::DATA_BODY_LEFT_OFFSET_MM,
            self::DATA_TOP_5_MM,
            self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextLeftMiddle(
            $this->op,
            self::DATA_LEFT + self::DATA_BODY_LEFT_OFFSET_MM,
            self::DATA_TOP_5_MM + self::DATA_LINE_HEIGHT_S_MM,
            self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawQTH() {
        $gs = $this->saveGS();
        $this->setFont(self::FONT_SIZE_DATA_SMALL_PT);
        $this->drawTextLeftMiddle(
            $this->qth,
            self::DATA_LEFT + self::DATA_BODY_LEFT_OFFSET_MM,
            self::DATA_TOP_6_MM,
            self::DATA_LINE_HEIGHT_S_MM);
        $this->drawTextLeftMiddle(
            $this->my_ido == '' ? '〃' : $this->my_ido,
            self::DATA_LEFT + self::DATA_BODY_LEFT_OFFSET_MM,
            self::DATA_TOP_7_MM,
            self::DATA_LINE_HEIGHT_S_MM);
    }

    private function drawTextLeftTop($text, $x_mm, $y_mm) {
        $font_size_mm = Qsl_Length_Unit::convert($this->page->getFontSize(), 'pt', 'mm');
        $baseline_mm  = $font_size_mm * self::BASELINE_POSITION;
        $lines = preg_split('/\x0d\x0a|\x0d|\x0a/', $text);
        foreach($lines as $line) {
            $this->page->drawText($line, self::x($x_mm), self::y($y_mm + $baseline_mm), 'UTF-8');
            $y_mm += $font_size_mm;
        }
    }

    private function drawTextLeftBottom($text, $x_mm, $bottom_mm) {
        $font_size_mm = Qsl_Length_Unit::convert($this->page->getFontSize(), 'pt', 'mm');
        $baseline_mm  = $font_size_mm * self::BASELINE_POSITION;
        $lines = preg_split('/\x0d\x0a|\x0d|\x0a/', $text);
        $top_mm = $bottom_mm - $font_size_mm * count($lines);
        return $this->drawTextLeftTop($text, $x_mm, $top_mm);
    }

    private function drawTextCenterBottom($text, $x_mm, $bottom_mm, $rect_width_mm) {
        $font_size_mm = Qsl_Length_Unit::convert($this->page->getFontSize(), 'pt', 'mm');
        $baseline_mm  = $font_size_mm * self::BASELINE_POSITION;
        $lines = preg_split('/\x0d\x0a|\x0d|\x0a/', $text);
        $top_mm = $bottom_mm - $font_size_mm * count($lines);
        return $this->drawTextCenterMiddle($text, $x_mm, $top_mm, $rect_width_mm, $bottom_mm - $top_mm);
    }

    private function drawTextRightBottom($text, $x2_mm, $bottom_mm) {
        $font_size_mm = Qsl_Length_Unit::convert($this->page->getFontSize(), 'pt', 'mm');
        $baseline_mm  = $font_size_mm * self::BASELINE_POSITION;
        $lines = preg_split('/\x0d\x0a|\x0d|\x0a/', $text);
        $top_mm = $bottom_mm - $font_size_mm * count($lines);
        foreach($lines as $line) {
            $text_area_width_mm = mb_strlen($line, 'UTF-8') * $font_size_mm / 2; // 半角幅で計算する必要があるので /2
            $x_mm = $x2_mm - $text_area_width_mm;
            $this->drawTextLeftTop($line, $x_mm, $top_mm);
            $top_mm += $font_size_mm;
        }
    }

    private function drawTextCenterMiddle($text, $x1_mm, $y1_mm, $rect_width_mm, $rect_height_mm) {
        $font_size_mm = Qsl_Length_Unit::convert($this->page->getFontSize(), 'pt', 'mm');
        $baseline_mm  = $font_size_mm * self::BASELINE_POSITION;
        $lines = preg_split('/\x0d\x0a|\x0d|\x0a/', $text);
        $text_area_height_mm = $font_size_mm * count($lines);
        $y_mm = $y1_mm + ($rect_height_mm / 2 - $text_area_height_mm / 2) + ($font_size_mm - $baseline_mm) / 2;
        foreach($lines as $line) {
            $text_area_width_mm = mb_strlen($line, 'UTF-8') * $font_size_mm / 2; // 半角幅で計算する必要があるので /2
            $x_mm = $x1_mm + ($rect_width_mm / 2 - $text_area_width_mm / 2);
            $this->page->drawText($line, self::x($x_mm), self::y($y_mm + $baseline_mm), 'UTF-8');
            $y_mm += $font_size_mm;
        }
    }

    private function drawTextLeftMiddle($text, $x_mm, $y1_mm, $height_mm) {
        $font_size_mm = Qsl_Length_Unit::convert($this->page->getFontSize(), 'pt', 'mm');
        $baseline_mm  = $font_size_mm * self::BASELINE_POSITION;
        $lines = preg_split('/\x0d\x0a|\x0d|\x0a/', $text);
        $text_area_height_mm = $font_size_mm * count($lines);
        $y_mm = $y1_mm + ($height_mm / 2 - $text_area_height_mm / 2) + ($font_size_mm - $baseline_mm) / 2;
        foreach($lines as $line) {
            $this->page->drawText($line, self::x($x_mm), self::y($y_mm + $baseline_mm), 'UTF-8');
            $y_mm += $font_size_mm;
        }
    }

    private function drawTextRightMiddle($text, $x2_mm, $y1_mm, $height_mm) {
        $font_size_mm = Qsl_Length_Unit::convert($this->page->getFontSize(), 'pt', 'mm');
        $baseline_mm  = $font_size_mm * self::BASELINE_POSITION;
        $lines = preg_split('/\x0d\x0a|\x0d|\x0a/', $text);
        $text_area_height_mm = $font_size_mm * count($lines);
        $y_mm = $y1_mm + ($height_mm / 2 - $text_area_height_mm / 2) + ($font_size_mm - $baseline_mm) / 2;
        foreach($lines as $line) {
            $text_area_width_mm = mb_strlen($line, 'UTF-8') * $font_size_mm / 2; // 半角幅で計算する必要があるので /2
            $x_mm = $x2_mm - $text_area_width_mm;
            $this->page->drawText($line, self::x($x_mm), self::y($y_mm + $baseline_mm), 'UTF-8');
            $y_mm += $font_size_mm;
        }
    }

    private function setLineColorBlack() {
        $this->page->setLineColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        return $this;
    }

    private function setLineColorRed() {
        $this->page->setLineColor(new Zend_Pdf_Color_Rgb(0.988, 0.196, 0.167));
        return $this;
    }

    private function setFont($fontsize_pt) {
        $font = Zend_Pdf_Font::fontWithPath(__DIR__ . '/' . self::FONT_PATH);
        $this->page->setFont($font, $fontsize_pt);
        return $this;
    }

    static private function x($x_mm) {
        return Qsl_Length_Unit::convert($x_mm, 'mm', 'pt');
    }

    static private function y($y_mm) {
        return Qsl_Length_Unit::convert(self::CARD_HEIGHT_MM - $y_mm, 'mm', 'pt');
    }

    // wrap $page->saveGS() and $page->restoreGS()
    private function saveGS() {
        return new Qsl_GraphicStateHolder($this->page);
    }
}
