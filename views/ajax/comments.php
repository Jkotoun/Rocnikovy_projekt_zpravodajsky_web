<?php if(UserManager::getLoggedUser()==null):?>
    <?php foreach ($comments as $index => $comment) : ?>
        <div class="comment" id="<?=$comment['comment_id']?>">
            <a href="uzivatel/<?=$comment['profile_url']?>">
                <img src="public/uploads/profile-pictures/<?= $comment['profile_picture']?>" alt="profilový obrázek">
            </a>

            <div class="comment-content">
                <div class="comment-header-group">
                    <a href="uzivatel/<?=$comment['profile_url']?>">
                        <span class="comment-name"><?= $comment['first_name'] . " " . $comment['last_name']?></span>
                    </a>
                    <span class="comment-time"> <?=$comment['post_time']?></span>

                </div>

                <div class="comment-text"><?= $comment['content']?></div>

                <div class="ratings">
                    <div class="thumb-up">
                        <span class="icon-thumbs-up"></span><span class="number-likes"> <?=$comment['likes_count']?></span>
                    </div>
                    <div class="thumb-down">
                        <span class="icon-thumbs-down "></span><span class="number-dislikes"> <?=$comment['dislikes_count']?></span>
                    </div>
                    <a href="prihlaseni"><div class="reply-button">Odpovědět</div></a>
                </div>
            </div>
            <?php if($logged_user['user_id']==$comment['user_id']): ?>
                <div class="comment-menu-icon">
                    <span class="icon-dots-horizontal-triple"></span>
                    <div class="comment-menu">
                        <ul>
                            <li class="delete-comment">Odstranit</li>
                        </ul>
                    </div>
                </div>

            <?php endif; ?>
            <?php
            if($comment['replies-count']>0):
                ?>
                <div class="showReplies">
                    Zobrazit odpovědi
                </div>
                <div class="hideReplies">
                    Skrýt odpovědi
                </div>
            <?php endif;?>
            <div class="comment-replies">
                <div class="replies">
                    <?php foreach($comment['replies'] as $reply):?>


                        <div class="reply" id="<?=$reply['comment_id']?>">
                            <a href="uzivatel/<?=$reply['profile_url']?>">
                                <img src="public/uploads/profile-pictures/<?= $reply['profile_picture']?>" alt="profilový obrázek">
                            </a>
                            <div class="comment-content">
                                <div class="comment-header-group">
                                    <a href="uzivatel/<?=$reply['profile_url']?>">
                                        <span class="comment-name"><?= $reply['first_name'] . " " . $reply['last_name']?></span>
                                    </a>
                                    <span class="comment-time"> <?=$reply['post_time']?></span>

                                </div>

                                <div class="comment-text"><?= $reply['content']?></div>
                                <div class="ratings">
                                    <div class="thumb-up">
                                        <span class="icon-thumbs-up"></span><span class="number-likes"> <?=$reply['likes_count']?></span>
                                    </div>
                                    <div class="thumb-down">
                                        <span class="icon-thumbs-down "></span><span class="number-dislikes"> <?=$reply['dislikes_count']?></span>
                                    </div>
                                    <a href="prihlaseni"><div class="reply-button">Odpovědět</div></a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>


        </div>
    <?php endforeach ?>
<?php else:
    $logged_user  = UserManager::getLoggedUser();
    ?>

    <?php foreach ($comments  as $index =>$comment ) : ?>
    <div class="comment" id="<?=$comment['comment_id']?>">
        <a href="uzivatel/<?=$comment['profile_url']?>">
            <img src="public/uploads/profile-pictures/<?= $comment['profile_picture']?>" alt="profilový obrázek">
        </a>

        <div class="comment-content">
            <div class="comment-header-group">
                <a href="uzivatel/<?=$comment['profile_url']?>">
                    <span class="comment-name"><?= $comment['first_name'] . " " . $comment['last_name']?></span>
                </a>
                <span class="comment-time"> <?=$comment['post_time']?></span>

            </div>

            <div class="comment-text"><?= $comment['content']?></div>

            <div class="ratings">
                <div class="thumb-up <?php if(ContentManager::rating_exists($logged_user['user_id'],$comment['comment_id'],"like")):?>liked<?php endif;?>">
                    <span class="icon-thumbs-up"></span><span class="number-likes"> <?=$comment['likes_count']?></span>
                </div>
                <div class="thumb-down <?php if(ContentManager::rating_exists($logged_user['user_id'],$comment['comment_id'],"dislike")):?>disliked<?php endif;?>">
                    <span class="icon-thumbs-down "></span><span class="number-dislikes"> <?=$comment['dislikes_count']?></span>
                </div>
                <div class="reply-button parent-reply">Odpovědět</div>
            </div>
        </div>
        <?php if($logged_user['user_id']==$comment['user_id']): ?>
            <div class="comment-menu-icon">
                <span class="icon-dots-horizontal-triple"></span>
                <div class="comment-menu">
                    <ul>
                        <li class="delete-comment">Odstranit</li>
                    </ul>
                </div>
            </div>

        <?php endif; ?>
        <?php
        if($comment['replies-count']>0):
            ?>
            <div class="showReplies">
                Zobrazit odpovědi
            </div>
            <div class="hideReplies">
                Skrýt odpovědi
            </div>
        <?php endif;?>
        <div class="comment-replies">
            <div class="replies">
                <?php foreach($comments[$index]['replies'] as $index2 =>$reply):?>


                    <div class="reply" id="<?=$reply['comment_id']?>">
                        <a href="uzivatel/<?=$reply['profile_url']?>">
                            <img src="public/uploads/profile-pictures/<?= $reply['profile_picture']?>" alt="profilový obrázek">
                        </a>
                        <div class="comment-content">
                            <div class="comment-header-group">
                                <a href="uzivatel/<?=$reply['profile_url']?>">
                                    <span class="comment-name"><?= $reply['first_name'] . " " . $reply['last_name']?></span>
                                </a>
                                <span class="comment-time"> <?=$reply['post_time']?></span>

                            </div>
                            <div class="comment-text"><?= strip_tags($_comments[$index]['replies'][$index2]['content'],"<a>")?></div>
                            <div class="ratings">
                                <div class="thumb-up <?php if(ContentManager::rating_exists($logged_user['user_id'],$reply['comment_id'],"like")):?>liked<?php endif;?>">
                                    <span class="icon-thumbs-up"></span><span class="number-likes"> <?=$reply['likes_count']?></span>
                                </div>
                                <div class="thumb-down <?php if(ContentManager::rating_exists($logged_user['user_id'],$reply['comment_id'],"dislike")):?>disliked<?php endif;?>">
                                    <span class="icon-thumbs-down "></span><span class="number-dislikes"> <?=$reply['dislikes_count']?></span>
                                </div>
                                <div class="reply-button reply-to-reply" data-comment_link='<a class="comment-reply-anchor" contenteditable="false"  href="#<?=$reply['comment_id']?>">@<?= $reply['first_name'] . " " . $reply['last_name']?> </a><br>'>Odpovědět</div>
                            </div>
                        </div>
                        <?php if($logged_user['user_id']==$reply['user_id']  || UserRoles::logged_user_can('manage-users')): ?>
                            <div class="comment-menu-icon">
                                <span class="icon-dots-horizontal-triple"></span>
                                <div class="comment-menu">
                                    <ul>
                                        <li class="delete-comment">Odstranit</li>
                                    </ul>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="rendered-replies">


            </div>




            <div class="reply-input">
                <div class="reply-form-container">
                    <div class="reply-picture">
                        <img src="public/uploads/profile-pictures/<?=$logged_user['profile_picture']?>" alt="profilový obrázek">
                    </div>
                    <form class="reply-form" method="post" reply-form_id="<?=$comment['comment_id']?>">
                        <div class="comment-textarea-container">
                            <div contenteditable="true" id="new-reply-text" placeholder="Zadejte text komentáře">


                            </div>
                            <div class="form-error-text"></div>
                        </div>
                        <button class="btn btn-blue add-comment-button" type="submit"><span class="add-comment-button-text">Potvrdit</span></button>
                        <button class="btn btn-blue hide-reply-button" type="button"><span class="hide-reply-button-text">Zrušit</span></button>
                    </form>
                </div>

            </div>
        </div>


    </div>

    <?php endforeach ?>
<?php endif;?>