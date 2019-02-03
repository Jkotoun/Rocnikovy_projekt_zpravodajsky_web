<?php foreach($replies as $index => $reply):?>
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
            <div class="comment-text"><?= strip_tags($_replies[$index]['content'],"<a>")?></div>
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
        <?php if(UserManager::getLoggedUser()['user_id']==$reply['user_id']  || UserRoles::logged_user_can('manage-users')): ?>
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