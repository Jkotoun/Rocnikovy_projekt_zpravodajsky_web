<?php if ($is_category):?>
    <?php foreach ($articles as $article) : ?>
            <article class="article-preview-medium">
                <div class="row">
                    <div class="col-sm-4">
                        <a href="/clanek/<?= $article['url']?>">
                            <img class="img-fluid" src="public/uploads/images/<?= $article['img_url']?>" alt="náhledový-obrázek">

                        </a>
                    </div>
                    <div class="col-sm-8">
                        <a href="/clanek/<?= $article['url']?>">
                            <h3>
                                <?= $article['title']?>
                            </h3>
                        </a>
                        <div class="article-info">
                            <img class="img-preview" src="public/uploads/profile-pictures/<?=$article['profile_picture']?>">
                            <span class="article-author"> <?= $article['first_name'] . " " . $article['last_name']?></span>
                            <span class="last-update-time">  <?= $article['post_time']?></span>
                        </div>
                        <div class="text-sample">
                            <p><?= $article['description']?> </p>
                        </div>
                    </div>
                </div>
            </article>
    <?php endforeach;?>
<?php else:?>
<?php foreach ($articles as $article) : ?>
<article class="article-preview-medium">
                <div class="info"><?=$article['category_name']?></div>
                <div class="row">
                    <div class="col-sm-4">
                        <a href="/clanek/<?= $article['url']?>">
                            <img class="img-fluid" src="public/uploads/images/<?= $article['img_url']?>" alt="náhledový-obrázek">

                        </a>
                    </div>
                    <div class="col-sm-8">
                        <a href="/clanek/<?= $article['url']?>">
                            <h3>
                                <?= $article['title']?>
</h3>
                        </a>
                        <div class="article-info">
                            <img class="img-preview" src="public/uploads/profile-pictures/<?=$article['profile_picture']?>">
                            <span class="article-author"> <?= $article['first_name'] . " " . $article['last_name']?></span>
                            <span class="last-update-time">  <?= $article['post_time']?></span>
                        </div>
                        <div class="text-sample">
                            <p><?= $article['description']?> </p>
                        </div>
                    </div>
                </div>
            </article>
<?php endforeach;?>
<?php endif;?>