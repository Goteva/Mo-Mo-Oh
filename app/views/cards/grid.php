<?php $app = App::getInstance(); ?>

<div class="my-3">
    <div class="container">


            <form method="post" action="index.php?p=cards.grid" class="g-3 mb-4 row">
                <input type="hidden" name="filters" value="form_validator">
                <div class="col-md-2">
                    <select title="Card Type..." name="id_cards_types[]" class="picker" multiple="multiple">
                        <?php foreach ($cards_types as $types){
                            $selected = '';
                            if(isset($_SESSION['filter_cards_types']) && !empty($_SESSION['filter_cards_types'])) {
                                if(is_array(($_SESSION['filter_cards_types']))) {
                                    if (in_array($types->id_cards_types, $_SESSION['filter_cards_types'])) {
                                        $selected = 'selected';
                                    }
                                }else{
                                    if ($types->id_cards_types == $_SESSION['filter_cards_types']) {
                                        $selected = 'selected';
                                    }
                                }
                            }

                            ?>
                            <option <?= $selected ?> value="<?= $types->id_cards_types ?>"><?= $types->cards_types_title ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select title="Card SubTypes..." name="id_card_subtypes[]" class="picker" multiple="multiple">
                        <?php foreach ($card_subtypes as $subtypes){
                            $selected = '';
                            if(isset($_SESSION['filter_card_subtypes']) && !empty($_SESSION['filter_card_subtypes'])) {
                                if(is_array(($_SESSION['filter_card_subtypes']))) {
                                    if (in_array($subtypes->id_card_subtypes, $_SESSION['filter_card_subtypes'])) {
                                        $selected = 'selected';
                                    }
                                }else{
                                    if ($subtypes->id_card_subtypes == $_SESSION['filter_card_subtypes']) {
                                        $selected = 'selected';
                                    }
                                }
                            }

                            ?>
                            <option <?= $selected ?> value="<?= $subtypes->id_card_subtypes ?>"><?= $subtypes->card_subtypes_title ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select title="Card Attributes..." name="id_card_attributes[]" class="picker" multiple="multiple">
                        <?php foreach ($card_attributes as $attributes){
                            $selected = '';
                            if(isset($_SESSION['filter_card_attributes']) && !empty($_SESSION['filter_card_attributes'])) {
                                if(is_array(($_SESSION['filter_card_attributes']))) {
                                    if (in_array($attributes->id_card_attributes, $_SESSION['filter_card_attributes'])) {
                                        $selected = 'selected';
                                    }
                                }else{
                                    if ($attributes->id_card_subtypes == $_SESSION['filter_card_attributes']) {
                                        $selected = 'selected';
                                    }
                                }
                            }

                            ?>
                            <option <?= $selected ?> value="<?= $attributes->id_card_attributes ?>"><?= $attributes->card_attributes_title ?></option>
                        <?php } ?>
                    </select>
                </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>


            </form>


        <div class="row g-3">
            <?php foreach ($cards as $card) :
                /* tcg ocg color texte */
                $color = "black";
                if($card->cards_tcg_release < $card->cards_ocg_release){
                    $color = "green";
                }else{
                    if($card->year_diff_tcg_ocg >= 2){ $color = "#b30000"; }
                }

                /* check data */
                $card_subtypes_title = $card->card_subtypes_title ?: '';
                $card_subtypes_title2 = $card->card_subtypes_title2 ?: '';
                $card_api_url = $card->api_url ?: "";
                $DivineBeast = (($card->cards_title == "Obelisk the Tormentor") ? "Obelisk" : (($card->cards_title == "The Winged Dragon of Ra") ? "Ra" : (($card->cards_title == "Slifer the Sky Dragon") ? "Slifer" : "")));
                $card_subtypes_title_pendulum = ($card_subtypes_title == 'Pendulum' || $card_subtypes_title2 == 'Pendulum') ? 'Pendulum' : '';

                $cards_desc = array(
                    "monsters_types_title" => $card->monsters_types_title,
                    "cards_types_title" => str_replace("Monster-", "", str_replace("Monster-Normal", "", $card->cards_types_title)),
                    "card_subtypes_title" => $card->card_subtypes_title,
                    "card_subtypes_title2" => $card->card_subtypes_title2
                );

                $cards_atk = (($card->cards_atk === "0") ? "0" : (($card->cards_atk === "99999") ? "?" : (($card->cards_atk === "10000") ? "X000" : (empty($card->cards_atk) ? '<span class="null">NULL</span>' : $card->cards_atk))));
                $cards_def = (($card->cards_def === "0") ? "0" : (($card->cards_def === "99999") ? "?" : (($card->cards_def === "10000") ? "X000" : (empty($card->cards_def) ? '<span class="null">NULL</span>' : $card->cards_def))));

                ?>
                <div class="col-3">
                        <div class="card cards <?= $card->cards_types_title ." ". $card_subtypes_title_pendulum ." ". $DivineBeast;?>" style="width: 18rem;">
                        <h5 class="card-title text-wrap">
                            <a href="?p=cards.edit&id=<?= $card->id_cards; ?>"><?= $card->cards_title ?> <?= $card->cards_notes ?></a>
                            <img class="cards-img-attribute" src="./assets/attributes/<?= $card->card_attributes_title; ?>.png" title="<?= $card->card_attributes_title; ?>"/>
                        </h5>
                        <div class="cards-level">
                            <?php
                            if(empty($card->cards_level)){
                                echo '<span class="null">NULL</span>';
                            }else{
                                echo '<span style="font-size: 10px; margin-right: 5px;">'.$card->cards_level.'x</span>';
                                for($i = 0; $i < $card->cards_level; $i++){
                                    ?>
                                    <img src="./assets/niveau.png" class="cards-img-level" alt="...">
                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <a class="card-img-top-a" href="<?= $card_api_url; ?>"><img src="<?= $card->image_url ?>" class="card-img-top" alt="..."></a>

                        <div class="card-body">
                            <?php if($card_subtypes_title_pendulum == 'Pendulum'){ ?>

                            <p class="card-pendulum">
                                <img src="./assets/Pendulum_scales_left.png" alt="">
                                <span class="scales"><?= $card->cards_scale; ?></span>
                                <img src="./assets/Pendulum_scales_right.png" alt="">
                            </p>
                                <?php } ?>

                            <p class="card-text">
                                <span><strong>[ <?= join(" / ", array_filter($cards_desc)); ?> ]</strong></span>
                                <br />
                                <?= '<span style="color:'.$color.'">'.$card->date_diff_tcg_ocg.'</span>' ?>
                            <span class="hr"></span>
                            <span class="atk_def">ATK / <?= $cards_atk; ?>  DEF / <?= $cards_def ?> </span>
                            </p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>