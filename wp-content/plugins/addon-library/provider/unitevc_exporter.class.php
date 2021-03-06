<?php
/**
 * @package Addon Library
 * @author UniteCMS.net / Valiano
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */

defined('ADDON_LIBRARY_INC') or die('Restricted access');

class UniteCreatorLayoutsExporterVC extends UniteCreatorLayoutsExporter{
	
	private $txtLayout;
	private $layoutTitle;
	
	
	/**
	 * replace image url in layout
	 */
	private function replaceUrlImage($layout, $pos){
		$posEnd = strpos($layout,'"',$pos);
		
		$len = $posEnd-$pos;
		
		$strImage = substr($layout,$pos,$len);
		
		$filename = str_replace(self::KEY_LOCAL,"",$strImage);
		$filename = trim($filename);
		
		if(!isset($this->arrImportImages[$filename]))
			UniteFunctionsUC::throwError("Local image: $filename not found");
		
		$arrImage = $this->arrImportImages[$filename];
		
		$urlImage = $arrImage["url"];
		if(isset($arrImage["imageid"]))
			$urlImage = $arrImage["imageid"];
		
		$layout = substr_replace($layout, $urlImage, $pos, $len);
		
		return($layout);
	}
	
	
	/**
	 * parse config images
	 */
	private function updateLayoutImages_parseConfig($layout){
		
		$lastPos = 0;
		
		do{
			$isFound = false;
			$pos = strpos($layout, self::KEY_LOCAL);
			if($pos !== false){
					
				if($pos == $lastPos){
					UniteFunctionsUC::throwError("Something wrong in layout image replace");
				}
				
				$layout = $this->replaceUrlImage($layout, $pos);
				$isFound = true;
				$lastPos = $pos;
			}
		
		}while($isFound == true);

		return($layout);
	}
	
	
	/**
	 * parse items
	 */
	private function updateLayoutImages_parseItems(){
		
		$layout = $this->txtLayout;
		
		$lastPos = 0;
		
		$keyItems = 'uc_items_data="';
		$lenKeyItems = strlen($keyItems);
		
		$debugItems = false;
		
		do{
			$isFound = false;
			$pos = strpos($layout, 'uc_items_data="', $lastPos+1);
			if($pos !== false){
			
				if($pos == $lastPos)
					UniteFunctionsUC::throwError("Something wrong in layout items image replace");
		
				$posStart = $pos+$lenKeyItems;
				$posEnd = strpos($layout,'"',$posStart);
				
				$len = $posEnd-$posStart;
				
				$strItemsEncoded = substr($layout,$posStart,$len);
				if(!empty($strItemsEncoded)){
					
					/*
					if($debugItems == true){
						$arrItems = UniteFunctionsUC::decodeContent($strItemsEncoded);
						dmp($arrItems);					
					}
					*/
					
					$strItems = rawurldecode(base64_decode($strItemsEncoded));
					
					$strItems = $this->updateLayoutImages_parseConfig($strItems);
					
					$strItems = UniteFunctionsUC::encodeContent($strItems);
					
					$layout = substr_replace($layout, $strItems, $posStart, $len);
					
				}
				
				$isFound = true;
				$lastPos = $pos;
			}
		
		}while($isFound == true);
		
		
		$this->txtLayout = $layout;
	}
	
	
	/**
	 * update layout after images copy
	 */
	protected function importLayoutImages_updateLayout(){
		
		if(empty($this->txtLayout))
			UniteFunctionsUC::throwError("The layout can't be empty");
		
		$this->txtLayout = $this->updateLayoutImages_parseConfig($this->txtLayout);
		
		$this->updateLayoutImages_parseItems();
	}
	
	
	/**
	 * import layout txt from zip
	 */
	protected function importLayoutTxtFromZip($layoutID = null){
		
		$filepathLayout = $this->pathImportLayout."layout_vc.txt";
		$fileExists = file_exists($filepathLayout);
		if($fileExists == false)
			UniteFunctionsUC::throwError("VC Layout file don't exist");
		
		$this->txtLayout = file_get_contents($filepathLayout);
		
		//import layout title
		$filepathLayoutData = $this->pathImportLayout."layout_data.json";
		UniteFunctionsUC::validateFilepath($filepathLayoutData, "vc layout data");
		
		$data = file_get_contents($filepathLayoutData);
		$arrData = @json_decode($data);
		UniteFunctionsUC::validateNotEmpty($arrData,"layout data");
		$arrData = UniteFunctionsUC::convertStdClassToArray($arrData);
		
		$this->layoutTitle = UniteFunctionsUC::getVal($arrData, "title");
		UniteFunctionsUC::validateNotEmpty($this->layoutTitle,"layout title");
		
	}
	
	/**
	 * get imported layout title
	 */
	public function getLayoutTitle(){
		
		//validate inited
		UniteFunctionsUC::validateNotEmpty($this->layoutTitle,"layout title");
		
		return($this->layoutTitle);
	}
	
	/**
	 * import
	 */
	public function importVCLayout($arrTempFile, $isOverwriteAddons = false){
		
		$this->addonsType = "vc";
		$this->import($arrTempFile, null, $isOverwriteAddons);
		
		return($this->txtLayout);
	}
	
}