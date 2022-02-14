<?php
class SiteMap
{
    function addToSitemap($url,$priority,$config){
        $dom=new DOMDocument();
        $dom->load($config->sitemap->main);
        $root=$dom->documentElement; 
        
        $root->appendChild($this->makeElement($url,$priority,$dom));
        $dom->saveXML();
        $dom->save($config->sitemap->main);
        return "ok";
    }

    function editSitemap($url,$_priority,$config){
        $dom=new DOMDocument();
        $dom->load($config->sitemap->main);
        $root=$dom->documentElement; 
        $markers=$root->getElementsByTagName('url');
        $found=false;
        foreach ($markers as $marker) {
            $loc=$marker->getElementsByTagName('loc');
            $_url="";
            
            if($loc->length>0){
                $_url=$loc->item(0)->textContent;
                if($_url==$url){
                    $date=$marker->getElementsByTagName('lastmod');
                    $prior=$marker->getElementsByTagName('priority');
                    $marker->removeChild($date->item(0));
                    $marker->removeChild($prior->item(0));
                    $date=new DateTime();
                    $_lstm=$date->format('Y-m-d')."T".$date->format('g:i:s')."+00:00";
                    $lastmod=$dom->createElement("lastmod");
                    $priority=$dom->createElement("priority");
                    $lastmod->textContent=$_lstm;
                    $marker->appendChild($lastmod); 
                    $priority->textContent=$_priority;
                    $marker->appendChild($priority);
                    $found=true;
                }
            }
        }
        
        $dom->saveXML();
        $dom->save($config->sitemap->main);
        if(!$found){
            $this->addToSitemap($url,$_priority,$config);
        }
    }
    
    function removeFromSitemap($url,$config){
        $dom=new DOMDocument();
        $dom->load($config->sitemap->main);
        $root=$dom->documentElement; 
        $nodesToDelete=array();
        $markers=$root->getElementsByTagName('url');
        foreach ($markers as $marker) {
            $loc=$marker->getElementsByTagName('loc');
            $_url="";
            
            if($loc->length>0){
                $_url=$loc->item(0)->textContent;
                if($_url==$url){
                    array_push($nodesToDelete,$marker);
                }
            }else{
                array_push($nodesToDelete,$marker);
            }
        }
        
        foreach ($nodesToDelete as $node) $node->parentNode->removeChild($node);
        $dom->saveXML();
        $dom->save($config->sitemap->main);
    }

    function makeElement($_url,$_priority,$dom){
        $date=new DateTime();
        $_lstm=$date->format('Y-m-d')."T".$date->format('g:i:s')."+00:00";

        $node=$dom->createElement("url");
        $loc=$dom->createElement("loc");
        $priority=$dom->createElement("priority");
        $lastmod=$dom->createElement("lastmod");

        $loc->textContent=$_url;
        $lastmod->textContent=$_lstm;
        $priority->textContent=$_priority;
        $node->appendChild($loc);
        $node->appendChild($lastmod);
        $node->appendChild($priority);
        return $node;
    }

    function call_functions($name, $data,$config)
    {
        switch ($name) {
            case "addToSitemap":
                $this->addToSitemap($data->url,$data->priority,$config);
                break;
            case "editSitemap":
                $this->editSitemap($data->url,$data->priority,$config);
                break;
            case "removeFromSitemap":
                $this->removeFromSitemap($data->url,$config);
                break;
            default:
                return "invalid_action";
        }
    }
}
?>