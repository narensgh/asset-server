<?php


require 'vendor/autoload.php';
use Zend\File\Transfer\Adapter\Http;

class Upload
{

    public function move($postdata)
    {
        if (!$postdata && !isset($postdata['filepath']) && !isset($postdata['destination'])) {
            throw new Exception("invalid input", '500');
        }
        $adapter = new Http();
        $adapter->addFilter('File\Rename', array(
            'target' => $postdata['destination'],
            'use_upload_extension' => true,
            'overwrite' => true
        ));
        try {
            if ($adapter->receive()) {
                $file = $adapter->getFilter('File\Rename')->getFile();
                echo $file[0]['target'];
            } else {
                throw new \Exception('Unable to upload file', '500');
            }
        } catch (\Exception $ex) {
            throw new \Exception( $ex->getMessage(), '500');
        }
    }
}
$upload = new Upload();
$postdata = $_POST;
$upload->move($postdata);
