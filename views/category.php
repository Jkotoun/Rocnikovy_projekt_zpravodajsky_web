<div class="info category-selection-info"><?=$category?></div>
<section class="articles">
    <?php if(empty($articles)):?><p class="no-articles">Kategorie neobsahuje žádné články</p><?php endif;?>
<?php foreach ($articles as $article) : ?>
    <article class="article-preview-medium">
        <div class="row">
            <div class="col-sm-4">
                <a href="/clanek/<?= $article['url']?>">
                    <div class="article-preview-medium-img">
                    <img class="img-fluid" src="public/uploads/images/<?= $article['img_url']?>" alt="náhledový-obrázek">
                    </div>
                </a>
            </div>
            <div class="col-sm-8">
                <a href="/clanek/<?= $article['url']?>">
                    <h3>
                        <?= $article['title']?>
                    </h3>
                </a>
                <div class="article-info">
                    <a href="<?='uzivatel/' . $article['profile_url']?>">
                    <img class="img-preview" src="public/uploads/profile-pictures/<?=$article['profile_picture']?>">
                    <span class="article-author"> <?= $article['first_name'] . " " . $article['last_name']?></span>
                    </a>
                    <span class="last-update-time">  <?= $article['post_time']?></span>
                </div>
                <div class="text-sample">
                    <p><?= $article['description']?> </p>
                </div>
            </div>
        </div>
    </article>
<?php endforeach;?>
</section>
<div class="spinner">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>