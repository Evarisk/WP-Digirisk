<?php
require 'SegmentIterator.php';
class digiSegmentException extends Exception
{}
/**
 * Class for handling templating digi_segments with odt files
 * You need PHP 5.2 at least
 * You need Zip Extension or digiPclZip library
 * Encoding : ISO-8859-1
 * Author: neveldo $
 * Modified by: Vikas Mahajan http://vikasmahajan.wordpress.com
 * Date - $Date: 2010-12-09 11:11:57
 * SVN Revision - $Rev: 44 $
 * Id : $Id: digiSegment.php 44 2009-06-17 10:12:59Z neveldo $
 *
 * @copyright  GPL License 2008 - Julien Pauli - Cyril PIERRE de GEYER - Anaska (http://www.anaska.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL License
 * @version 1.3
 */
class digiSegment implements IteratorAggregate, Countable
{
    protected $xml;
    protected $xmlParsed = '';
    protected $name;
    protected $children = array();
    protected $vars = array();
    public $manif_vars = array();
	protected $images = array();
	protected $DigiOdf;
	protected $file;
    /**
     * Constructor
     *
     * @param string $name name of the digi_segment to construct
     * @param string $xml XML tree of the digi_segment
     */
    public function __construct($name, $xml, $DigiOdf)
    {
        $this->name = (string) $name;
        $this->xml = (string) $xml;
		$this->DigiOdf = $DigiOdf;
        $zipHandler = $this->DigiOdf->getConfig('ZIP_PROXY');
        $this->file = new $zipHandler($this->DigiOdf->getConfig('PATH_TO_TMP'));
        $this->_analyseChildren($this->xml);
    }
    /**
     * Returns the name of the digi_segment
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Does the digi_segment have children ?
     *
     * @return bool
     */
    public function hasChildren()
    {
        return $this->getIterator()->hasChildren();
    }
    /**
     * Countable interface
     *
     * @return int
     */
    public function count()
    {
        return count($this->children);
    }
    /**
     * IteratorAggregate interface
     *
     * @return Iterator
     */
    public function getIterator()
    {
        return new RecursiveIteratorIterator(new digiSegmentIterator($this->children), 1);
    }
    /**
     * Replace variables of the template in the XML code
     * All the children are also called
     *
     * @return string
     */
    public function merge()
    {
        $this->xmlParsed .= str_replace(array_keys($this->vars), array_values($this->vars), $this->xml);
        if ($this->hasChildren()) {
            foreach ($this->children as $child) {
                $this->xmlParsed = str_replace($child->xml, ($child->xmlParsed=="")?$child->merge():$child->xmlParsed, $this->xmlParsed);
                $child->xmlParsed = '';
                //Store all image names used in child digi_segments in current digi_segment array
				foreach ($child->manif_vars as $file)
                $this->manif_vars[] = $file;
                $child->manif_vars=array();
            }
        }
        $reg = "/\[!--\sBEGIN\s$this->name\s--\](.*)\[!--\sEND\s$this->name\s--\]/sm";
        $this->xmlParsed = preg_replace($reg, '$1', $this->xmlParsed);
        $this->file->open($this->DigiOdf->getTmpfile());
        foreach ($this->images as $imageKey => $imageValue) {
			if ($this->file->getFromName('Pictures/' . $imageValue) === false) {
				$this->file->addFile($imageKey, 'Pictures/' . $imageValue);
			}
        }

        $this->file->close();
        return $this->xmlParsed;
    }
    /**
     * Analyse the XML code in order to find children
     *
     * @param string $xml
     * @return digiSegment
     */
    protected function _analyseChildren($xml)
    {
        // $reg2 = "#\[!--\sBEGIN\s([\S]*)\s--\](?:<\/text:p>)?(.*)(?:<text:p\s.*>)?\[!--\sEND\s(\\1)\s--\]#sm";
        $reg2 = "#\[!--\sBEGIN\s([\S]*)\s--\](.*)\[!--\sEND\s(\\1)\s--\]#sm";
        preg_match_all($reg2, $xml, $matches);
        for ($i = 0, $size = count($matches[0]); $i < $size; $i++) {
            if ($matches[1][$i] != $this->name) {
                $this->children[$matches[1][$i]] = new self($matches[1][$i], $matches[0][$i], $this->DigiOdf);
            } else {
                $this->_analyseChildren($matches[2][$i]);
            }
        }
        return $this;
    }
    /**
     * Assign a template variable to replace
     *
     * @param string $key
     * @param string $value
     * @throws digiSegmentException
     * @return digiSegment
     */
    public function setVars($key, $value, $encode = true, $charset = 'ISO-8859')
    {
        if (strpos($this->xml, $this->DigiOdf->getConfig('DELIMITER_LEFT') . $key . $this->DigiOdf->getConfig('DELIMITER_RIGHT')) === false) {
            // throw new digiSegmentException("var $key not found in {$this->getName()}");
						return;
        }
		$value = $encode ? htmlspecialchars($value) : $value;
		$value = ($charset == 'ISO-8859') ? utf8_encode($value) : $value;
        $this->vars[$this->DigiOdf->getConfig('DELIMITER_LEFT') . $key . $this->DigiOdf->getConfig('DELIMITER_RIGHT')] = str_replace("\n", "<text:line-break/>", $value);
        return $this;
    }
    /**
     * Assign a template variable as a picture
     *
     * @param string $key name of the variable within the template
     * @param string $value path to the picture
     * @throws DigiOdfException
     * @return digiSegment
     */
    public function setImage($key, $value, $finalWidth = 0)
    {
        $filename = strtok(strrchr($value, '/'), '/.');
        $file = substr(strrchr($value, '/'), 1);
        $size = @getimagesize($value);
        if ($size === false) {
            throw new DigiOdfException("Invalid image");
        }
        list ($width, $height) = $size;
				if($finalWidth <= 0)
				{
					$width *= DigiOdf::PIXEL_TO_CM;
					$height *= DigiOdf::PIXEL_TO_CM;
				}
				else
				{
					$ratio = ($finalWidth / $width);
					$width *= $ratio;
					$height *= $ratio;
				}
        $xml = <<<IMG
<draw:frame draw:style-name="fr1" draw:name="$filename" text:anchor-type="aschar" svg:width="{$width}cm" svg:height="{$height}cm" draw:z-index="3"><draw:image xlink:href="Pictures/$file" xlink:type="simple" xlink:show="embed" xlink:actuate="onLoad"/></draw:frame>
IMG;
        $this->images[$value] = $file;
        $this->manif_vars[] = $file;	//save image name as array element
        $this->setVars($key, $xml, false);
        return $this;
    }
    /**
     * Shortcut to retrieve a child
     *
     * @param string $prop
     * @return digiSegment
     * @throws digiSegmentException
     */
    public function __get($prop)
    {
        if (array_key_exists($prop, $this->children)) {
            return $this->children[$prop];
        } else {
            throw new digiSegmentException('child ' . $prop . ' does not exist');
        }
    }
    /**
     * Proxy for setVars
     *
     * @param string $meth
     * @param array $args
     * @return digiSegment
     */
    public function __call($meth, $args)
    {
        try {
            return $this->setVars($meth, $args[0]);
        } catch (digiSegmentException $e) {
            throw new digiSegmentException("method $meth nor var $meth exist");
        }
    }
    /**
     * Returns the parsed XML
     *
     * @return string
     */
    public function getXmlParsed()
    {
        return $this->xmlParsed;
    }
}

?>
