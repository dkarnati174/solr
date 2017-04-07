<?phpclass explr extends CI_Controller{// Transform XML into other XML format using XSLTpublic function converteads(){    $files = glob("application/eads/*xml");    if (is_array($files)) {           foreach ($files as $filename) {//            $eadfile = file_get_contents($filename);            //load ead file from eads folder               $ead_doc = new DOMDocument();               $ead_doc->load($filename);               $file = basename($filename);               //  $xml=simplexml_load_file($filename);               $newString =str_replace("xmlns=\"http://ead3.archivists.org/schema/\"","",$ead_doc->saveXML());               $carray=array("c01","c02","c03","c04","c05","c06","c07","c08","c09","c10","c11","c12");               $newString1 = str_replace($carray,"C",$newString);               file_put_contents("application/ceads/$file", $newString1);               $new_ead_doc = new DOMDocument();               $new_ead_doc -> load("application/ceads/$file");               // $filepath = $filename;               //load xsl file               $xsl_doc = new DOMDocument();               $xsl_doc->load("application/xslt/new_ead_solr.xsl");               $proc = new XSLTProcessor();               $proc->importStylesheet($xsl_doc);               //create new domfile               $newdom = $proc->transformToDoc($new_ead_doc);               //save new dom file into solr_xmls directory               $newdom->save("application/solr_xmls/".$file)or die("Error");            // and proceed with your code        }        $filecount = sizeof($files);      echo "total number of ead documents converted: " .$filecount;    }}/*public function sample(){    $directory = '/Applications/MAMP/htdocs/exploro/application/eads';    if (! is_dir($directory)) {        exit('Invalid diretory path');    }    $files = array();    foreach (new DirectoryIterator($directory) as $file) {        if ('.' === $file) continue;        if ('..' === $file) continue;        $ead_doc = new DOMDocument();        $ead_doc->load($file);        //load xsl file        $xsl_doc = new DOMDocument();        $xsl_doc->load("application/xslt/ead_solr.xsl");        $proc = new XSLTProcessor();        $proc->importStylesheet($xsl_doc);        //create new domfile        $newdom = $proc->transformToDoc($ead_doc);        //save new dom file into solr_xmls directory        $newdom->save("application/solr_xmls/".$file)or die("Error");        //$files[] = $file;    }}*/     /*    $xml_doc = new DOMDocument();    $xml_doc->load("application/ead/");// XSL    $xsl_doc = new DOMDocument();    $xsl_doc->load("file.xsl");// Proc    $proc = new XSLTProcessor();    $proc->importStylesheet($xsl_doc);    $newdom = $proc->transformToDoc($xml_doc);    print $newdom->saveXML();*/   /* public function newf(){        foreach (new DirectoryIterator(__DIR__) as $file) {       //     if ($file->isFile()) {                print $file . "\n";         //   }        }    }*/   /* public function readxml() {        $files = glob("application/eads/*xml");        if (is_array($files)) {            foreach ($files as $filename) {                $ead_doc = new DOMDocument();                $ead_doc->load($filename);              //  $ead_doc->loadXML($filename);             //   echo $ead_doc ->saveXML();                 $newString =str_replace("xmlns=\"http://ead3.archivists.org/schema/\"","",$ead_doc->saveXML());               // echo $newString;                file_put_contents($filename, $newString);                print_r($filename);            }}    }*/    /*public function readfile()    {        $files = glob("application/eads/*xml");        if (is_array($files)) {            foreach ($files as $filename) {              //  print $filename;                $ead_doc = new DOMDocument();                $ead_doc->load($filename);                $string1 = $ead_doc->saveXML() ;echo $string1;            }        }    }*/    public function convertead2s()    {        $files = glob("application/ead2/*xml");        if (is_array($files)) {            foreach ($files as $filename) {                //$eadfile = file_get_contents($filename);                //load ead file from eads folder                $ead_doc = new DOMDocument();                $ead_doc->load($filename);                $file = basename($filename);                //  $xml=simplexml_load_file($filename);                $newString = $ead_doc->saveXML();                file_put_contents("application/cead2s/$file", $newString);                $new_ead_doc = new DOMDocument();                $new_ead_doc->load("application/cead2s/$file");                // $filepath = $filename;                //load xsl file                $xsl_doc = new DOMDocument();                $xsl_doc->load("application/xslt/ead2_solr.xsl");                $proc = new XSLTProcessor();                $proc->importStylesheet($xsl_doc);                //create new domfile                $newdom = $proc->transformToDoc($new_ead_doc);                //save new dom file into solr_xmls directory                $newdom->save("application/solr_ead2/" . $file) or die("Error");            }            $filecount = sizeof($files);            echo "total number of ead documents converted: " .$filecount;        }    }public function finalEads(){    $files = glob("application/solr_xmls/*xml");    if (is_array($files)) {        foreach ($files as $filename) {            $ead_doc = new DOMDocument();            $ead_doc->load($filename);            $file = basename($filename);            $xsl_doc = new DOMDocument();            $xsl_doc->load("application/xslt/new_ead_solr.xsl");            $proc = new XSLTProcessor();            $proc->importStylesheet($xsl_doc);            $newdom = $proc->transformToDoc($ead_doc);            //save new dom file into solr_xmls directory            $newdom->save("application/final_eads/".$file)or die("Error");        }    }}public function parseXMLdoc(){   // $new_ead_doc = new DOMDocument();   // $new_ead_doc -> load("application/ceads/2.1.1.xml");    $xmlparser = xml_parser_create();// open a file and read data    $fp = fopen("application/solr_xmls/2.1.1.xml", 'r');    $xmldata = fread($fp, 500000);    xml_parse_into_struct($xmlparser,$xmldata,$values);    xml_parser_free($xmlparser);    print_r(json_encode($values));    //print_r($values);}}?>