<?php foreach($comments as $index => $article) : ?>
    <div class="user-post">
        <h3><?=$article['title']?></h3>

        <?php foreach($article['comments'] as $index2 => $comment) :?>

            <div class="comment" id="<?=$comment['comment_id']?>">
                <a href="uzivatel/<?=$comment['profile_url']?>">
                    <img src="public/uploads/profile-pictures/<?= $comment['profile_picture']?>" alt="profilový obrázek">
                </a>

                <div class="comment-content">
                    <div class="comment-header-group">
                        <a href="uzivatel/<?=$comment['profile_url']?>">
                            <span class="comment-name"><?= $comment['first_name'] . " " . $comment['last_name']?></span>
                        </a>
                        <?php if(isset($comment['reply_to_author'])):?> <span class="icon-forward"></span><a href="uzivatel/<?=$comment['reply_to_link']?>">
                            <span class="comment-name"><?= $comment['reply_to_author']?></span>

                        </a> <?php endif?>
                        <span class="comment-time"> <?=$comment['post_time']?></span>

                    </div>

                    <div class="comment-text"><?=strip_tags($_comments[$index]['comments'][$index2]['content'],"<a>")?></div>
                    <div class="comment-link"> <a href="<?php echo('clanek/' . $article['url'] . '#'. (ContentManager::commentIsReply($comment['comment_id']) ? "reply" . $comment['comment_id'] : $comment['comment_id']))?>">Zobrazit v diskuzi</a></div>
                </div>

            </div>
        <?php endforeach;?>
    </div>
<?php endforeach;?>