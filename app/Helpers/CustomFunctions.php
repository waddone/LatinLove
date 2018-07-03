<?php 

//namespace App\Helpers;

//use Illuminate\Support\Facades\DB;
use App\Models\TranslationStatic;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Variable;


	
    function breadcrumbs() {

        $breadcrubs_link                    = "$_SERVER[REQUEST_URI]";
        $breadcrubs_link                    = str_replace('https://', '' , $breadcrubs_link);
        $breadcrubs_link                    = str_replace('http://', '' , $breadcrubs_link);
        $breadcrubs_link                    = rtrim($breadcrubs_link, '/');
        $breadcrubs_link                    = str_replace('www.', '' , $breadcrubs_link);
        $breadcrubs_bucati                  = explode('/', $breadcrubs_link);
        $nr_bucati                          = count($breadcrubs_bucati);
        //$nr_bucati                          = $nr_bucati - 1;
        $bread_ul_li                        = '<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"><a itemprop="item" href="'.url('/').'" title="dezmembrari si piese auto"><i class="fa fa-home"></i></a>';
        $href                               = '';
        $class_activ            = ' class="active"';
        for ($i=0;$i<=$nr_bucati;$i++) {
            $i;
            $y = $i + 1;
            $breadcrubs_title               = '';

            if(isset($breadcrubs_bucati[$i])) {            
                if($i == $nr_bucati) {
                    $href   .= $breadcrubs_bucati[$i];
                    $href    = rtrim($href, '/');
                    $breadcrubs_title       .= str_replace('-', ' ', $breadcrubs_bucati[$i]);
                } else {
                    $href                   .= $breadcrubs_bucati[$i].'/';
                    $breadcrubs_title       .= str_replace('-', ' ', $breadcrubs_bucati[$i]);
                }
                $bread_ul_li                .= '<li'.$class_activ.' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"> <a itemprop="item" href="'.$href.'" title="'.$breadcrubs_title.'"><span itemprop="name">'.$breadcrubs_bucati[$i].'</a></span><meta itemprop="position" content="'.$y.'" /> </li>';
            }
        }
        $bread_ul_li                        .= '</ol>';
        return $bread_ul_li;
        
    }

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $strip_html if html tags are to be stripped
     * @return string
     */
    function trim_text($input, $length, $ellipses = true, $strip_html = true) {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }
      
        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }
      
        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);
      
        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= ' ...';
        }
      
        return $trimmed_text;
    }

    function truncate($text, $length = 100, $options = array()) {
        $default = array(
            'ending' => '...', 'exact' => true, 'html' => false
        );
        $options = array_merge($default, $options);
        extract($options);

        if ($html) {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            $totalLength = mb_strlen(strip_tags($ending));
            $openTags = array();
            $truncate = '';

            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];

                $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }

                    $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
            }
        }
        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($html) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if (!empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if (!in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        $truncate .= $ending;

        if ($html) {
            foreach ($openTags as $tag) {
                $truncate .= '</'.$tag.'>';
            }
        }

        return $truncate;
    }


    function getSchoolIdFromCurrentLogedUser() {

        $user_logat_r       = Auth::user();
        if($user_logat_r->hasSchool() == true) {
            return $school_id  = $user_logat_r->returnSchoolId();
        } else {
            return false;
        }
        
    }


    function getGlobalVar() {
        //$globalVarSeted = Variable::all();
        $firstMonthAmount     = Variable::where('uid','=','firstMonthAmount')->first();
        $normalMonthAmount    = Variable::where('uid','=','normalMonthAmount')->first();

        $globalVar = array(
            "firstMonthAmount"    => $firstMonthAmount->value,
            "normalMonthAmount"   => $normalMonthAmount->value
        );

        return $globalVar;
    }

?>