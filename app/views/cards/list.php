<?php $app = App::getInstance(); ?>

<div class="my-3">
    <div class="container">
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
                $card_subtypes_title_pendulum = ($card_subtypes_title == 'Pendulum' || $card_subtypes_title2 == 'Pendulum') ? 'Pendulum' : '';

                $cards_desc = array(
                    "monsters_types_title" => $card->monsters_types_title,
                    "cards_types_title" => str_replace("Monster-", "", $card->cards_types_title),
                    "card_subtypes_title" => $card->card_subtypes_title,
                    "card_subtypes_title2" => $card->card_subtypes_title2
                );

                $cards_atk = (($card->cards_atk === "0") ? "0" : (($card->cards_atk === "-1") ? "?" : (($card->cards_atk === "-10000") ? "X000" : (empty($card->cards_atk) ? '<span class="null">NULL</span>' : $card->cards_atk))));
                $cards_def = (($card->cards_def === "0") ? "0" : (($card->cards_def === "-1") ? "?" : (($card->cards_def === "-10000") ? "X000" : (empty($card->cards_def) ? '<span class="null">NULL</span>' : $card->cards_def))));

                ?>
                <div class="col-3">
                        <div class="card cards <?= $card->cards_types_title ?> <?= $card_subtypes_title_pendulum;?>" style="width: 18rem;">
                        <h5 class="card-title text-wrap"><a href="<?= $card->id_cards; ?>"><?= $card->cards_title ?></a></h5>
                        <div class="cards-level">
                            <?php
                            if(empty($card->cards_level)){
                                echo '<span class="null">NULL</span>';
                            }else{
                                echo '<span style="font-size: 10px; margin-right: 5px;">'.$card->cards_level.'x</span>';
                                for($i = 0; $i <= $card->cards_level; $i++){
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