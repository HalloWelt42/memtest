<?php
/**
 * Created by PhpStorm.
 * User: alpha
 * Date: 13.10.19
 * Time: 12:27
 */

new dom_simple_test('dom');

class dom_simple_test {

    const XML_PARSER = 'simple';
    private $xml_file_list;
    private $xml_content_list;
    private $mem_start;
    private $mem_end;

    public function __construct($xml_parser)
    {
        $this->xml_file_list = [];
        $this->xml_content_list = [];
        $this->mem_start = memory_get_peak_usage();
        $this->load_files();
        switch($xml_parser) {
            case self::XML_PARSER : $this->load_simple_xml();
            break;
            default : $this->load_dom_document();
        }
        $this->mem_end = memory_get_peak_usage();
        $this->print_memory_test();
        $this->dummy_print();
    }


    private function load_files() {
        for ($i = 1; $i <= 6; $i++) {
            $this->xml_file_list[] = file_get_contents ('test_100_'.$i.'.xml');
        }
    }


    //private function load_simple_xml() {
    //    print_r('load_simple_xml' . PHP_EOL);
    //    foreach ($this->xml_file_list as $xml_file) {
    //        $this->xml_content_list[] = simplexml_load_string ( $xml_file );
    //    }
    //}

    private function load_dom_document() {
        print_r('load_dom_document' . PHP_EOL);
        foreach ($this->xml_file_list as $xml_file) {
            $temp = new DOMDocument( '1.0','utf8' );
            $temp -> loadXML ($xml_file);
            $this->xml_content_list[] = clone($temp);
        }
    }

    private function print_memory_test() {
        print_r(count($this->xml_file_list) . PHP_EOL);
        print_r(count($this->xml_content_list) . PHP_EOL);
        print_r ( $this->mem_end - $this->mem_start . PHP_EOL);
    }

    private function dummy_print() {
        print_r($this->xml_content_list,true);
    }
}