<div class="esc py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <img class="img-fluid" src="./photos/<?= $esc->escs_pics[0]->escs_pics_path ?>">
            </div>
            <div class="col-8">
                <div class="masonry row">
                    <?php foreach ($esc->escs_pics as $pic) { ?>
                        <?php if ($pic->id_escs_pics != $esc->escs_pics[0]->id_escs_pics) { ?>
                            <div class="col col-md-4 col-sm-2">
                                <img class="img-fluid" src="./photos/<?= $pic->escs_pics_path ?>">
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>