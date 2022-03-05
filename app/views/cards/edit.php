<form method="post" class="row g-3 mt-2">
    <div class="col-md-3">
        <div class="form-group">

            <img src="<?= (empty($card->cards_image) ? $card->image_api_url : "./cards/".$card->cards_image) ?>" class="img-fluid rounded" alt="<?= $card->cards_title ?>">

         </div>
        <?= $form->input('cards_image', 'card', ['type' => 'file', 'id' => 'fileUpload']); ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-8">
            <?= $form->input('cards_title', 'Name Card'); ?>
            </div>
            <div class="col-md-4">
            <?= $form->input('cards_notes', 'Notes'); ?>
            </div>
            <div class="col-md-3">
            <?= $form->input('cards_level', 'Level'); ?>
            </div>
            <div class="col-md-3">
            <?= $form->input('cards_atk', 'ATK', ['format_value' => 'atk']); ?>
            </div>
            <div class="col-md-3">
            <?= $form->input('cards_def', 'DEF', ['format_value' => 'atk']); ?>
            </div>
            <div class="col-md-3">
            <?= $form->input('cards_scale', 'Scale'); ?>
            </div>

            <div class="col-md-3">
            <?= $form->input('cards_tcg_release', 'TCG', ['type' => 'date']); ?>
            </div>
            <div class="col-md-3">
            <?= $form->input('cards_ocg_release', 'OCG', ['type' => 'date']); ?>
            </div>
            <div class="col-md-3">
            <?= $form->input('cards_rush_ocg_release', 'Rush OCG', ['type' => 'date']); ?>
            </div>
            <div class="col-md-3">
            <?= $form->input('cards_speed_release', 'Speed', ['type' => 'date']); ?>
            </div>

            <div class="col-md-3">
                <?php
                $idx_cards_types = array();
                foreach($cards_types as $ss => $s){
                    $idx_cards_types[$s->id_cards_types] = $s->cards_types_title;
                }
                ?>
                <?= $form->select('idx_cards_types', 'Card Type', $idx_cards_types); ?>
            </div>
            <div class="col-md-3">
                <?php
                $idx_monsters_types = array();
                foreach($monsters_types as $ss => $s){
                    $idx_monsters_types[$s->id_monsters_types] = $s->monsters_types_title;
                }
                ?>
                <?= $form->select('idx_monsters_types', 'Monsters Types', $idx_monsters_types, true); ?>
            </div>
            <div class="col-md-2">
                <?php
                $idx_card_subtypes = array();
                foreach($card_subtypes as $ss => $s){
                    $idx_card_subtypes[$s->id_card_subtypes] = $s->card_subtypes_title;
                }
                ?>
                <?= $form->select('idx_card_subtypes', 'Card Subtypes', $idx_card_subtypes, true); ?>
            </div>
            <div class="col-md-2">
                <?php
                $idx_card_subtypes2 = array();
                foreach($card_subtypes as $ss => $s){
                    $idx_card_subtypes2[$s->id_card_subtypes] = $s->card_subtypes_title;
                }
                ?>
                <?= $form->select('idx_card_subtypes2', 'Card Subtypes 2', $idx_card_subtypes2, true); ?>
            </div>
            <div class="col-md-2">
                <?php
                $idx_card_attributes = array();
                foreach($card_attributes as $ss => $s){
                    $idx_card_attributes[$s->id_card_attributes] = $s->card_attributes_title;
                }
                ?>
                <?= $form->select('idx_card_attributes', 'Card Attributes', $idx_card_attributes, true); ?>
            </div>



        </div>
    </div>

    `cards_tcg_release`, `cards_ocg_release`, `cards_rush_ocg_release`, `cards_speed_release`, `idx_cards_types`, `idx_card_subtypes`, `idx_card_subtypes2`, `idx_card_attributes`, `idx_monsters_types`
    <button class="btn btn-primary">Sauvegarder</button>
</form>