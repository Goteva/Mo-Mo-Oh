<?php

namespace App\Table;

use \Core\Table\Table;

class CardsTable extends Table
{

    protected $table = 'cards';

    public function getCard($id_cards)
    {
        return $this->q('SELECT * FROM cards WHERE id_cards = ?', [$id_cards], false);
    }

    public function getAllCards($filter_cards_types = array(), $filter_card_subtypes = array(), $filter_card_attributes = array())
    {
        $vDB = $this->getDbVersion();

        $where_ = array();

        if(!empty($filter_cards_types)){
            $filter_cards_types_ = (is_array($filter_cards_types)) ? implode(",", $filter_cards_types) : $filter_cards_types;
            array_push($where_, ' id_cards_types IN ('.$filter_cards_types_.')');
        }

        if(!empty($filter_card_subtypes)){
            $filter_card_subtypes_ = (is_array($filter_card_subtypes)) ? implode(",", $filter_card_subtypes) : $filter_card_subtypes;
            array_push($where_, ' (idx_card_subtypes IN ('.$filter_card_subtypes_.') OR idx_card_subtypes2 IN ('.$filter_card_subtypes_.'))');
        }

        if(!empty($filter_card_attributes)){
            $filter_card_attributes_ = (is_array($filter_card_attributes)) ? implode(",", $filter_card_attributes) : $filter_card_attributes;
            array_push($where_, ' idx_card_attributes IN ('.$filter_card_attributes_.')');
        }

        $where = '';

        if(!empty($where_)) {
            if (count($where_) > 1) {
                $where = 'WHERE ' . implode(" AND ", $where_);
            } else {
                $where = 'WHERE ' . $where_[0];
            }
        }

        $select = array(
            "cards.id_cards",
            "cards.cards_title",
            "cards.cards_notes",
            "cards.cards_image",
            "cards.cards_level",
            "cards.cards_scale",
            "cards.cards_atk",
            "cards.cards_def",
            "cards.cards_tcg_release",
            "cards.cards_ocg_release",
            "cards.cards_rush_ocg_release",
            "cards.cards_speed_release",
            "cards_types.cards_types_title",
            "cards_types.cards_types_background",
            "card_attributes.card_attributes_title",
            "card_subtypes.card_subtypes_title",
            "card_subtypes2.card_subtypes_title AS card_subtypes_title2",
            "monsters_types.monsters_types_title"
        );

        if(isset($vDB) && !empty($vDB)) {
            if ($vDB >= 2) {
                array_push($select, "cards.cards_creation_date", "cards.cards_last_modified_date");
            }
        }

        $sql = '
            SELECT 
            
            '.implode(", \n", $select).'
            
            FROM cards
                
            LEFT JOIN cards_types on id_cards_types = idx_cards_types
            LEFT JOIN card_attributes on id_card_attributes = idx_card_attributes
            LEFT JOIN card_subtypes on id_card_subtypes = idx_card_subtypes
            LEFT JOIN card_subtypes AS card_subtypes2 on card_subtypes2.id_card_subtypes = idx_card_subtypes2
            LEFT JOIN monsters_types on id_monsters_types = idx_monsters_types

            '.$where.'

            ORDER BY 
                     cards_types.cards_types_order ASC, 
                     cards.cards_level DESC, 
                     cards.cards_atk DESC, 
                     cards.cards_def DESC, 
                     cards.cards_title ASC
            ';


        $path_cards = './cards/';

        $cards = $this->q($sql, false);

        foreach ($cards as $ci => $card) {
            $owner_cards = $this->getOwnedCardsFromID($card->id_cards);

            if(!empty($owner_cards)){
                $extension = array();
                $total_quantity = 0;

                foreach ($owner_cards as $owened){
                    $total_quantity += $owened->owned_cards_quantity;

                    array_push($extension, array(
                        'label' => $owened->owned_cards_quantity.'x '.$owened->owned_cards_extension.'-'.$owened->cards_rarity_abbr,
                        'name' => $owened->owned_cards_extension,
                        'quantity' => $owened->owned_cards_quantity,
                        'rarity' => $owened->cards_rarity_abbr
                    ));
                }

                $owner = array(
                    'total_quantity' => $total_quantity,
                    'extension' => $extension
                );

                $cards[$ci]->{'owned'} = $owner;
            }




            $cards[$ci]->{'api_url'} = 'https://db.ygoprodeck.com/api/v7/cardinfo.php?name=' . urlencode($card->cards_title);
            $cards[$ci]->{'image_api_url'} = '';

            if(!empty($card->cards_image)) {
                $cards[$ci]->{'image_url'} =  $path_cards . $card->cards_image;
            }else{

                $file_crop = $path_cards . $card->id_cards.'-crop.png';
                $file_png = $path_cards . $card->id_cards.'.png';
                $file_jpg = $path_cards . $card->id_cards.'.jpg';

                if (!file_exists($file_crop)) {
                    if (!file_exists($file_png) && !file_exists($file_jpg)) {
                        // get img_url from api
                        $image_url = $this->getImageCardFromApi($card->cards_title, $card->id_cards)['image_url'];
                        $cards[$ci]->{'image_api_url'} = $image_url;
                        if ($image_url != 'error.png') {
                            // get img from url and save in cards directory
                            copy($image_url, $path_cards . $card->id_cards . '.jpg');
                            // convert jpg to png
                            imagepng(imagecreatefromstring(file_get_contents($path_cards . $card->id_cards . '.jpg')), $path_cards . $card->id_cards . '.png');

                            // crop png
                            $im = imagecreatefrompng($path_cards . $card->id_cards . '.png');
                            if ($card->card_subtypes_title == 'Pendulum' || $card->card_subtypes_title2 == 'Pendulum') {
                                $im2 = imagecrop($im, ['x' => 22, 'y' => 106, 'width' => 376, 'height' => 279]);
                            } else {
                                $im2 = imagecrop($im, ['x' => 45, 'y' => 106, 'width' => 333, 'height' => 333]);
                            }

                            if ($im2 !== FALSE) {
                                imagepng($im2, $file_crop, 9, PNG_ALL_FILTERS);
                                imagedestroy($im2);
                                unlink($path_cards . $card->id_cards . '.png');
                            }
                            imagedestroy($im);
                            unlink($path_cards . $card->id_cards . '.jpg');
                        } else {
                            $file_crop = $path_cards . 'error.png';
                        }
                    }else{
                        if(!file_exists($file_png)) {
                            // convert jpg to png
                            imagepng(imagecreatefromstring(file_get_contents($path_cards . $card->id_cards . '.jpg')), $path_cards . $card->id_cards . '.png');
                        }

                        // crop png
                        $im = imagecreatefrompng($path_cards . $card->id_cards . '.png');
                        if ($card->card_subtypes_title == 'Pendulum' || $card->card_subtypes_title2 == 'Pendulum') {
                            $im2 = imagecrop($im, ['x' => 22, 'y' => 106, 'width' => 376, 'height' => 279]);
                        } else {
                            $im2 = imagecrop($im, ['x' => 45, 'y' => 106, 'width' => 333, 'height' => 333]);
                        }

                        if ($im2 !== FALSE) {
                            imagepng($im2, $file_crop, 9, PNG_ALL_FILTERS);
                            imagedestroy($im2);
                            unlink($path_cards . $card->id_cards . '.png');
                        }
                        imagedestroy($im);
                        unlink($path_cards . $card->id_cards . '.jpg');
                    }
                }

                $cards[$ci]->{'image_url'} = $file_crop;
            }


            // calculate date_diff between TCG & OCG
            $tcg_ocg = date_diff(date_create($card->cards_tcg_release), date_create($card->cards_ocg_release));
            $cards[$ci]->{'year_diff_tcg_ocg'} = $tcg_ocg->format("%y");
            $cards[$ci]->{'date_diff_tcg_ocg'} = $tcg_ocg->format("%y Years %m Months %d Days");
        }


        return $cards;
    }

    public function getAllCardsTables()
    {
        $sql = '
            SELECT 
            cards.id_cards,
            cards.cards_title,
            cards.cards_notes,
            cards.cards_image,
            cards.cards_level,
            cards.cards_scale,
            cards.cards_atk,
            cards.cards_def,
            cards.cards_tcg_release,
            cards.cards_ocg_release, 
            cards.cards_rush_ocg_release, 
            cards.cards_speed_release,
            cards_types.cards_types_title,
            cards_types.cards_types_background,
            card_attributes.card_attributes_title,
            card_subtypes.card_subtypes_title,
            card_subtypes2.card_subtypes_title AS card_subtypes_title2,
            monsters_types.monsters_types_title
            
            FROM cards
                
            LEFT JOIN cards_types on id_cards_types = idx_cards_types
            LEFT JOIN card_attributes on id_card_attributes = idx_card_attributes
            LEFT JOIN card_subtypes on id_card_subtypes = idx_card_subtypes
            LEFT JOIN card_subtypes AS card_subtypes2 on card_subtypes2.id_card_subtypes = idx_card_subtypes2
            LEFT JOIN monsters_types on id_monsters_types = idx_monsters_types

            ORDER BY 
                     cards_types.cards_types_order ASC, 
                     cards.cards_level DESC, 
                     cards.cards_atk DESC, 
                     cards.cards_def DESC, 
                     cards.cards_title ASC
        ';
        $path_cards = './cards/';

        $cards = $this->q($sql, false);

        foreach ($cards as $ci => $card) {
            // calculate date_diff between TCG & OCG
            $tcg_ocg = date_diff(date_create($card->cards_tcg_release), date_create($card->cards_ocg_release));
            $cards[$ci]->{'year_diff_tcg_ocg'} = $tcg_ocg->format("%y");
            $cards[$ci]->{'date_diff_tcg_ocg'} = $tcg_ocg->format("%y Years %m Months %d Days");
        }

        return $cards;
    }

    public function getAllCardsTypes(){
        $sql = 'SELECT * FROM cards_types';
        return $this->q($sql, false);
    }

    public function getAllMonstersTypes(){
        $sql = 'SELECT * FROM monsters_types';
        return $this->q($sql, false);
    }

    public function getAllCardsSubTypes(){
        $sql = 'SELECT * FROM card_subtypes';
        return $this->q($sql, false);
    }

    public function getAllCardsAttributes(){
        $sql = 'SELECT * FROM card_attributes';
        return $this->q($sql, false);
    }

    public function getImageCardFromApi($card_title, $card_id){
        $datas = array();
        $url = 'https://db.ygoprodeck.com/api/v7/cardinfo.php?name=' . urlencode($card_title);

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)',
        );
        curl_setopt_array($ch, $options);
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode != 200) {
            //echo "ERROR code : {$httpCode}, ID : {$card_id}, URL is {$url}, curl_error : " . curl_error($ch);
            $datas["image_url"] = 'error.png';
        } else {
            $datas["image_url"] = json_decode($data, true)['data']['0']['card_images']['0']['image_url'];
        }

        curl_close($ch);

        return $datas;
    }

    public function getInfoCardFromApi($card_title){
        $datas = array();
        $url = 'https://db.ygoprodeck.com/api/v7/cardinfo.php?name=' . urlencode($card_title) . '&misc=yes';

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)',
        );
        curl_setopt_array($ch, $options);
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode != 200) {

        } else {
            $a = json_decode($data, true)['data'][0];
        }

        $types = $this->getIdTypes_SubTypes($a['type'], $a['race'], $a['desc']);

        $datas = array(
            "cards_title" => !isset($card_title) ? null : $card_title,
            "image_api_url" => !isset($a['card_images'][0]['image_url']) ? null : $a['card_images'][0]['image_url'],
            "cards_notes" => null,
            "cards_level" => !isset($a['level']) ? null : $a['level'],
            "cards_atk" => !isset($a['atk']) ? null : $a['atk'],
            "cards_def" => !isset($a['def']) ? null : $a['def'],
            "cards_scale" => !isset($a['scale']) ? null : $a['scale'],
            "cards_tcg_release" => null,
            "cards_ocg_release" => null,
            "cards_rush_ocg_release" => null,
            "cards_speed_release" => null,
            "idx_cards_types" => $types['idx_cards_types'],
            "idx_monsters_types" => !isset($this->getIdMonstersTypeFromName($a['race'])[0]->id_monsters_types) ? null : $this->getIdMonstersTypeFromName($a['race'])[0]->id_monsters_types,
            "idx_card_subtypes" => $types['idx_card_subtypes'],
            "idx_card_subtypes2" => $types['idx_card_subtypes2'],
            "idx_card_attributes" =>  isset($a['attribute']) ? (!isset($this->getIdAttributesFromName($a['attribute'])[0]->id_card_attributes) ? null : $this->getIdAttributesFromName($a['attribute'])[0]->id_card_attributes) : null
        );

        curl_close($ch);

        $datas_obj = (object) $datas;

        return $datas_obj;
    }

    public function getIdMonstersTypeFromName($monstersTypeTitle){

        $like = $monstersTypeTitle;

        if($monstersTypeTitle == 'Creator-God'){ $like = 'Creator God'; }

        $sql = "SELECT * FROM monsters_types WHERE monsters_types_title LIKE '".$like."'";
        return $this->q($sql, false);
    }

    public function getIdTypes_SubTypes($type, $race, $desc){
        $t = array(
            'idx_cards_types' => null,
            'idx_card_subtypes' => null,
            'idx_card_subtypes2' => null,
        );
        $types = explode(" ", $type);
        $cards_subtypes = $cards_subtypes2 = null;

        if($types[count($types)-1] == 'Monster'){
            switch ($types[0]){
                case 'Pendulum':
                    if(count($types) == 4){
                        $cards_types = $types[count($types)-1] . '-' . $types[2];
                        $cards_subtypes = $types[0];
                        $cards_subtypes2 = $types[1];
                    }elseif(count($types) == 3){
                        $cards_types = $types[count($types)-1] . '-' . $types[1];
                        $cards_subtypes = $types[0];
                    }
                    break;
                default:
                    if(count($types) == 4){
                        $cards_types = $types[count($types)-1] . '-' . $types[0];
                        $cards_subtypes = $types[1];
                        $cards_subtypes2 = $types[2];
                    }elseif(count($types) == 3) {
                        $cards_types = $types[count($types)-1] . '-' . $types[0];
                        $cards_subtypes = $types[1];
                    }else{
                        $cards_types = $types[count($types)-1] . '-' . $types[0];
                        if(strpos($desc, 'Pendulum') !== false) {
                            $cards_subtypes = 'Pendulum';
                            if (strpos($desc, 'effect') !== false) {
                                $cards_subtypes2 = 'Effect';
                            }
                        }else {
                            if (strpos($desc, 'effect') !== false && $cards_types != 'Monster-Effect') {
                                $cards_subtypes = 'Effect';
                            }
                        }
                    }

                    break;
            }
        }elseif($types[count($types)-1] == 'Card'){
            $cards_types = $types[0] . '-' . $race;
        }

        $t['idx_cards_types'] = is_null($cards_types) ? null : $this->getIdCardsTypeFromName($cards_types)[0]->id_cards_types;
        $t['idx_card_subtypes'] = is_null($cards_subtypes) ? null : $this->getIdCardsSubTypeFromName($cards_subtypes)[0]->id_card_subtypes;
        $t['idx_card_subtypes2'] = is_null($cards_subtypes2) ? null : $this->getIdCardsSubTypeFromName($cards_subtypes2)[0]->id_card_subtypes;

        return $t;
    }

    public function getIdCardsTypeFromName($cardsTypeTitle){

        $like = $cardsTypeTitle;

        $sql = "SELECT * FROM `cards_types` WHERE `cards_types_title` LIKE '".$like."'";
        return $this->q($sql, false);
    }

    public function getIdCardsSubTypeFromName($cardsSubTypeTitle){

        $like = $cardsSubTypeTitle;

        $sql = "SELECT * FROM `card_subtypes` WHERE `card_subtypes_title` LIKE '".$like."'";
        return $this->q($sql, false);
    }

    public function getIdAttributesFromName($attributesTitle){

        $like = $attributesTitle;

        $sql = "SELECT * FROM card_attributes WHERE card_attributes_title LIKE '".$like."'";
        return $this->q($sql, false);
    }

    public function getOwnedCardsFromID($id_card){
        $sql = "SELECT * FROM owned_cards LEFT JOIN cards_rarity ON id_cards_rarity = idx_cards_rarity WHERE idx_cards = ".$id_card;
        return $this->q($sql, false);
    }

    public function migrations(){
        $this->migrations_table();
    }
}
