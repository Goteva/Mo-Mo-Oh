<?php

namespace App\Controller;

use App;
use Core\HTML\BootstrapForm;

class CardsController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('cards');
    }

    public function index()
    {
        $cards = $this->cards->getAll();
        $this->cards->migrations();
        $this->render('cards.index', compact('cards'));
    }

    // listing
    public function list()
    {
        // like Horizontal mix grid & table
        $cards = $this->cards->getAllCards();
        $this->render('cards.list', compact('cards'));
    }

    public function grid()
    {
        $vDB = $this->cards->getDbVersion();

        if(isset($vDB) && !empty($vDB)) {
            if ($vDB >= 2) {
                if (isset($_GET['upd_card_img'])) {
                    $c = $this->cards->getCard($_GET['upd_card_img']);
                    //update last update date for one card
                    $cn = $c->cards_notes;
                    $result = $this->cards->update([
                        'name' => 'id_cards',
                        'value' => $_GET['upd_card_img']
                    ], [
                        'cards_notes' => $c->cards_notes.'.'
                    ]);

                    $result = $this->cards->update([
                        'name' => 'id_cards',
                        'value' => $_GET['upd_card_img']
                    ], [
                        'cards_notes' => $cn
                    ]);
                }
            }
        }

        if(isset($_POST['id_cards_types'])){
            $_SESSION['filter_cards_types'] = $_POST['id_cards_types'];
        }else{
            if(!isset($_SESSION['filter_cards_types']) || isset($_POST['filters'])){
                $_SESSION['filter_cards_types'] = array();
            }
        }

        if(isset($_POST['id_card_subtypes'])){
            $_SESSION['filter_card_subtypes'] = $_POST['id_card_subtypes'];
        }else{
            if(!isset($_SESSION['filter_card_subtypes']) || isset($_POST['filters'])){
                $_SESSION['filter_card_subtypes'] = array();
            }
        }

        if(isset($_POST['id_card_attributes'])){
            $_SESSION['filter_card_attributes'] = $_POST['id_card_attributes'];
        }else{
            if(!isset($_SESSION['filter_card_attributes']) || isset($_POST['filters'])){
                $_SESSION['filter_card_attributes'] = array();
            }
        }

        $cards_types = $this->cards->getAllCardsTypes();
        $monsters_types = $this->cards->getAllMonstersTypes();
        $card_subtypes = $this->cards->getAllCardsSubTypes();
        $card_attributes = $this->cards->getAllCardsAttributes();

        // like grid cards
        $cards = $this->cards->getAllCards($_SESSION['filter_cards_types'], $_SESSION['filter_card_subtypes'], $_SESSION['filter_card_attributes']);

        $this->render('cards.grid', compact('cards', 'cards_types', 'monsters_types', 'card_subtypes', 'card_attributes', 'vDB'));
    }

    public function table()
    {
        // like excel
        $cards = $this->cards->getAllCardsTables();
        $this->render('cards.table', compact('cards'));
    }

    public function detail()
    {
        $card = $this->cards->getCard(1);
        $this->render('cards.detail', compact('card'));
    }

    public function add()
    {

        $card = $this->cards->getCard(0);
        if (!empty($_POST)) {

            if(isset($_POST['getAPI'])){
                // chercher les information sur API
                $card = $this->cards->getInfoCardFromApi($_POST['cards_title']);
            }else{
               $LastInsertId = $this->cards->create([
                    'cards_title' => $_POST['cards_title'],
                    'cards_notes' => $_POST['cards_notes'],
                    'cards_level' => $_POST['cards_level'],
                    'cards_atk' => $_POST['cards_atk'],
                    'cards_def' => $_POST['cards_def'],
                    'cards_scale' => $_POST['cards_scale'],
                    'cards_tcg_release' => $_POST['cards_tcg_release'],
                    'cards_ocg_release' => $_POST['cards_ocg_release'],
                    'cards_rush_ocg_release' => $_POST['cards_rush_ocg_release'],
                    'cards_speed_release' => $_POST['cards_speed_release'],
                    'idx_cards_types' => $_POST['idx_cards_types'],
                    'idx_monsters_types' => $_POST['idx_monsters_types'],
                    'idx_card_subtypes' => $_POST['idx_card_subtypes'],
                    'idx_card_subtypes2' => $_POST['idx_card_subtypes2'],
                    'idx_card_attributes' => $_POST['idx_card_attributes']
                ], false, true);
            }
        }
        $form = new BootstrapForm($card);

        $cards_types = $this->cards->getAllCardsTypes();
        $monsters_types = $this->cards->getAllMonstersTypes();
        $card_subtypes = $this->cards->getAllCardsSubTypes();
        $card_attributes = $this->cards->getAllCardsAttributes();

        $this->render('cards.add', compact('form', 'card', 'cards_types', 'monsters_types', 'card_subtypes', 'card_attributes'));
    }

    public function edit()
    {
        $alert = [];
        if (!empty($_POST)) {

            $result = $this->cards->update([
                'name' => 'id_cards',
                'value' => $_GET['id']
            ], [
                'cards_title' => $_POST['cards_title'],
                'cards_notes' => $_POST['cards_notes'],
                'cards_level' => $_POST['cards_level'],
                'cards_atk' => $_POST['cards_atk'],
                'cards_def' => $_POST['cards_def'],
                'cards_scale' => $_POST['cards_scale'],
                'cards_tcg_release' => $_POST['cards_tcg_release'],
                'cards_ocg_release' => $_POST['cards_ocg_release'],
                'cards_rush_ocg_release' => $_POST['cards_rush_ocg_release'],
                'cards_speed_release' => $_POST['cards_speed_release'],
                'idx_cards_types' => $_POST['idx_cards_types'],
                'idx_monsters_types' => $_POST['idx_monsters_types'],
                'idx_card_subtypes' => $_POST['idx_card_subtypes'],
                'idx_card_subtypes2' => $_POST['idx_card_subtypes2'],
                'idx_card_attributes' => $_POST['idx_card_attributes']
            ]);

            if ($result) {
                return $this->grid();
            }
        }

        $card = $this->cards->getCard($_GET['id']);
        $card->{'image_api_url'} = $this->cards->getImageCardFromApi($card->cards_title, $card->id_cards)['image_url'];

        $form = new BootstrapForm($card);

        $cards_types = $this->cards->getAllCardsTypes();
        $monsters_types = $this->cards->getAllMonstersTypes();
        $card_subtypes = $this->cards->getAllCardsSubTypes();
        $card_attributes = $this->cards->getAllCardsAttributes();

        $this->render('cards.edit', compact('card', 'form', 'cards_types', 'monsters_types', 'card_subtypes', 'card_attributes'));
    }

    public function delete()
    {
        if (!empty($_POST)) {
            $result = $this->cards->delete([
                'name' => 'id_escs',
                'value' => $_POST['id']
            ]);
            return $this->list();
        }
    }
}
