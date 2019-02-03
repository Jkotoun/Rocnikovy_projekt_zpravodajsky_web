<div class="user-container">
    <div class="user">
        <img src="public/uploads/profile-pictures/<?= $user['profile_picture']?>" alt="profilový obrázek">
        <div class="user-name"><?= $user['first_name'] . " " . $user['last_name'] ?></div>
        <div class="user-age"><?=$user['gender']?>, <?=$user['birth_date']?> let</div>
        <div class="user-description"><?= $user['about']?></div>
    </div>
    <h2>Příspěvky v diskuzích</h2>
    <div class="user-comments">
        <?php if(!$comments): ?>
        <p>Zatím jste nenapsal žádné komentáře</p>
        <?php else: ?>
            <?php foreach($comments as $index =>$article) : ?>
                <div class="user-post">
                    <h3><a href="clanek/<?=$article['url']?>"><?=$article['title']?></a></h3>
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
                            <div class="comment-text"><?= $comments[$index]['comments'][$index2]['content'] ?></div>
                            <div class="comment-link"> <a href="<?php echo('clanek/' . $article['url'] . '#'. (ContentManager::commentIsReply($comment['comment_id']) ? "reply" . $comment['comment_id'] : $comment['comment_id']))?>">Zobrazit v diskuzi</a></div>
                        </div>

                    </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        <?php endif?>



</div>
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>