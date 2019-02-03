
<?php $first_article = array_shift($articles); ?>
<section class="articles">
<article class="article-preview-big">
    <div class="info"><?=$first_article['category_name']?></div>
    <div class="row">
        <div class="col-sm-5">
            <div class="article-preview-big-img">
            <a href="/clanek/<?= $first_article['url']?>">
                <img class="img-fluid" src="public/uploads/images/<?= $first_article['img_url']?>" alt="obrazek">
            </a>
            </div>
        </div>
        <div class="col-sm-7 preview-text">
            <a href="/clanek/<?= $first_article['url']?>">
                <h2>
                    <?= $first_article['title']?>
                </h2>
            </a>
            <div class="article-info">
            <a href="<?='uzivatel/' . $first_article['profile_url']?>">
                <img class="img-preview" src="public/uploads/profile-pictures/<?=$first_article['profile_picture']?>">
                <span class="article-author"> <?= $first_article['first_name'] . " " . $first_article['last_name']?></span>
            </a>
                <span class="last-update-time">  <?= $first_article['post_time']?></span>
            </div>

            <div class="text-sample">
                <p><?= $first_article['description']?> </p>
            </div>
        </div>
    </div>
</article>

<?php foreach ($articles as $article) : ?>
<article class="article-preview-medium">
                <div class="info"><?=$article['category_name']?></div>
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
