<?php

class A2Xml {
  private $version  = '1.0';
  private $encoding  = 'UTF-8';
  private $root    = 'xml';
  private $xml    = null;
  function __construct() {
    $this->xml = new XmlWriter();
  }
  function toXml($data, $eIsArray=FALSE) {
    if(!$eIsArray) {
      $this->xml->openMemory();
      $this->xml->startDocument($this->version, $this->encoding);
      $this->xml->startElement($this->root);
    }
    foreach($data as $key => $value){
  
      if(is_array($value)){
        $this->xml->startElement($key);
        $this->toXml($value, TRUE);
        $this->xml->endElement();
        continue;
      }
      $this->xml->writeElement($key, $value);
    }
    if(!$eIsArray) {
      $this->xml->endElement();
      return $this->xml->outputMemory(true);
    }
  }
  
public function uncdata($xml)
{

 
    $state = 'out';
 
    $a =str_split($xml);
 
    $new_xml = '';
 
    foreach ($a AS$k => $v) {
 
        // Dealwith "state".
        switch ($state ) {
            case'out':
                if( '<' == $v ) {
                   $state = $v;
                }else {
                   $new_xml .= $v;
                }
            break;
 
            case'<':
                if( '!' == $v  ) {
                   $state = $state . $v;
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
             case'<!':
                if( '[' == $v  ) {
                   $state = $state . $v;
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
            case'<![':
                if( 'C' == $v  ) {
                    $state = $state . $v;
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
            case'<![C':
                if( 'D' == $v  ) {
                    $state = $state . $v;
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
            case'<![CD':
                if( 'A' == $v  ) {
                   $state = $state . $v;
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
            case'<![CDA':
                if( 'T' == $v  ) {
                    $state = $state . $v;
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
            case'<![CDAT':
                if( 'A' == $v  ) {
                   $state = $state . $v;
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
            case'<![CDATA':
                if( '[' == $v  ) {
 
 
                    $cdata = '';
                   $state = 'in';
                }else {
                   $new_xml .= $state . $v;
                   $state = 'out';
                }
            break;
 
            case'in':
                if( ']' == $v ) {
                   $state = $v;
                }else {
                   $cdata .= $v;
                }
            break;
 
            case']':
                if(  ']' == $v  ) {
                   $state = $state . $v;
                }else {
                   $cdata .= $state . $v;
                   $state = 'in';
                }
            break;
 
            case']]':
                if(  '>' == $v  ) {
                   $new_xml .= str_replace('>','&gt;',
                               str_replace('>','&lt;',
                               str_replace('"','&quot;',
                               str_replace('&','&amp;',
                                $cdata))));
                   $state = 'out';
                } else {
                   $cdata .= $state . $v;
                   $state = 'in';
                }
            break;
        } // switch
 
    }
        return $new_xml;
 
} 
  
}


?>