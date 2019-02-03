<?php
/**
 * Created by PhpStorm.
 * User: Josef Kotoun
 * Date: 12.12.2018
 * Time: 10:51
 */

class AjaxAddReplyController extends controller
{
    public function process($params)
    {
        $userManager = new UserManager();
        $contentManager = new ContentManager();
        $parentPageUrl = $this->urlToArray($params);
        if($_POST)
        {
            $articleId =$contentManager->ArticleIdByUrl($parentPageUrl[1]);
            $user = $userManager->getLoggedUser();

            if($user!=null)
            {
                $reply = array(

                    'author_id'=>$user['user_id'],
                    'article_id'=>$articleId['Id'],
                    'content'=>$_POST['text'],
                    'parent_comment'=>$_POST['id'],

                );
                if($_POST['reply_to']==0)
                {
                    $reply['reply_to'] = $_POST['id'];
                }
                else
                {
                    $reply['reply_to'] = $_POST['reply_to'];
                }
                $contentManager->addComment($reply);
            }
        }
        $reply = $contentManager->load_new_reply($_POST['id']);
        $reply[0]['likes_count'] = 0;
        $reply[0]['dislikes_count'] = 0;
        $this->data['replies'] = $reply;
        $this->view = 'ajax/replies';
    }
}