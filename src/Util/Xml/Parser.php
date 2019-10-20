<?php


namespace App\Util\Xml;


use App\Util\Files\Finder;

class Parser
{
    /**
     * @param $file
     * @return false|string|null
     */
    public function getContent($file)
    {
        $file = Finder::FOLDER . '/invoice' . $file . '.xml';
        if (is_file($file)) {
            $xml = simplexml_load_string(file_get_contents($file));
            return json_encode($xml);
        }
        return null;
    }

    /**
     * @param $file
     * @param $node
     * @return false|string
     */
    public function getNode($file, $node)
    {
        $file = Finder::FOLDER . '/invoice' . $file . '.xml';
        if (is_file($file)) {
            $xml = $xml = simplexml_load_string(file_get_contents($file));
            $xml = $xml->$node ?? null;
            return json_encode($xml);
        }
        return null;
    }

    /**
     * @param $file
     * @param $node
     * @return bool
     */
    public function deleteNode($file, $node):bool
    {
        $file = Finder::FOLDER . '/invoice' . $file . '.xml';
        if (is_file($file)) {
            $xml = $xml = simplexml_load_string(file_get_contents($file));
            if (isset($xml->$node)) {
                unset($xml->$node);
                $xml->saveXML($file);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $file
     * @param $node
     * @return bool
     */
    public function addNode($file, $node, $value)
    {
        $file = Finder::FOLDER . '/invoice' . $file . '.xml';
        if (is_file($file)) {
            $xml = $xml = simplexml_load_string(file_get_contents($file));
            if (!isset($xml->$node)) {
                $xml->$node = $value;
                $xml->saveXML($file);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $file
     * @param $node
     * @param $new
     * @return bool
     */
    public function setNode($file, $node, $value)
    {
        $file = Finder::FOLDER . '/invoice' . $file . '.xml';
        if (is_file($file)) {
            $xml = $xml = simplexml_load_string(file_get_contents($file));
            if (isset($xml->$node)) {
                $xml->$node = $value;
                $xml->saveXML($file);
                return true;
            }
        }
        return false;
    }
}