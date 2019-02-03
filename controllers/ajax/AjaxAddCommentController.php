<?php


class AjaxAddCommentController extends Controller
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
                $comment = array(

                    'author_id'=>$user['user_id'],
                    'article_id'=>$articleId['Id'],
                    'content'=>strip_tags(html_entity_decode($_POST['text']))
                );
                $contentManager->addComment($comment);
            }
            

        }
        $comment = $contentManager->getArticlesComments(0,1,$parentPageUrl[1]);
        $comment[0]['replies-count'] =0;

        $comment[0]['likes_count'] = 0;
        $comment[0]['dislikes_count'] = 0;
        $this->data['comments'] = $comment;
        $this->view = 'ajax/comments';
    }
}