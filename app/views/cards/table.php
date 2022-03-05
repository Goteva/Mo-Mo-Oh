<?php $app = App::getInstance(); ?>

<div class="my-3">
    <div class="container">
        <div class="row g-3">
            <table class="table cards">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Card type</th>
                    <th scope="col">Subtype</th>
                    <th scope="col">Subtype 2</th>
                    <th scope="col">Attribute</th>
                    <th scope="col">Monster Type</th>
                    <th scope="col">Level</th>
                    <th scope="col">ATK</th>
                    <th scope="col">DEF</th>
                    <th scope="col">Scale</th>
                </tr>
                </thead>
                <tbody>
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
                $card_subtypes_title_pendulum = ($card_subtypes_title == 'Pendulum' || $card_subtypes_title2 == 'Pendulum') ? 'Pendulum' : '';

                $cards_desc = array(
                    "monsters_types_title" => $card->monsters_types_title,
                    "cards_types_title" => str_replace("Monster-", "", $card->cards_types_title),
                    "card_subtypes_title" => $card->card_subtypes_title,
                    "card_subtypes_title2" => $card->card_subtypes_title2
                );

                $cards_atk = (($card->cards_atk === "0") ? "0" : (($card->cards_atk === "99999") ? "?" : (($card->cards_atk === "10000") ? "X000" : (empty($card->cards_atk) ? '<span class="null">NULL</span>' : $card->cards_atk))));
                $cards_def = (($card->cards_def === "0") ? "0" : (($card->cards_def === "99999") ? "?" : (($card->cards_def === "10000") ? "X000" : (empty($card->cards_def) ? '<span class="null">NULL</span>' : $card->cards_def))));

                ?>
                    <tr>
                        <th scope="row">
                            <svg data-bs-toggle="popover" title="image" data-bs-placement="right" data-bs-html="true" class="picture" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 180V56c0-13.3 10.7-24 24-24h124c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H64v84c0 6.6-5.4 12-12 12H12c-6.6 0-12-5.4-12-12zM288 44v40c0 6.6 5.4 12 12 12h84v84c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12V56c0-13.3-10.7-24-24-24H300c-6.6 0-12 5.4-12 12zm148 276h-40c-6.6 0-12 5.4-12 12v84h-84c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h124c13.3 0 24-10.7 24-24V332c0-6.6-5.4-12-12-12zM160 468v-40c0-6.6-5.4-12-12-12H64v-84c0-6.6-5.4-12-12-12H12c-6.6 0-12 5.4-12 12v124c0 13.3 10.7 24 24 24h124c6.6 0 12-5.4 12-12z"/></svg>
                            <?= $card->cards_title ?> <?= $card->cards_notes ?>
                        </th>
                        <td><?= $card->cards_types_title ?></td>
                        <td><?= $card_subtypes_title ?></td>
                        <td><?= $card_subtypes_title2 ?></td>

                        <td><?= $card->card_attributes_title ?></td>
                        <td><?= $card->monsters_types_title ?></td>
                        <td><?= $card->cards_level ?></td>
                        <td><?= $cards_atk ?></td>
                        <td><?= $cards_def ?></td>
                        <td><?= $card->cards_scale ?></td>
                    </tr>
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>