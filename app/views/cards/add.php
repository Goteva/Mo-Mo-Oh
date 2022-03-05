<form method="post" class="row g-3 mt-2">
    <div class="col-md-3">
        <div class="form-group">

            <?php if(isset($card->image_api_url) && !empty($card->image_api_url)){ ?>
                <img src="<?= $card->image_api_url ?>" class="img-fluid rounded" alt="<?= $card->cards_title ?>">
            <?php } ?>

         </div>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label>Name Card</label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="cards_title" value="<?= isset($card->cards_title) ? $card->cards_title : '' ?>">
                        <button class="btn btn-outline-secondary" name="getAPI" value="cardinfo_name" type="submit">
                            <svg style="height: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z"/></svg>
                        </button>
                    </div>
                </div>
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

    <button class="btn btn-primary">Sauvegarder</button>
</form>