<?php

class AjaxCommentsController extends Controller
{
    public function process($params)
    {
        $contentManager = new ContentManager();

            $offset = $_POST['offset'];
            $limit = $_POST['limit'];
            $parentPageUrl = $this->urlToArray($params); //zpracování URL stránky, z které byl odeslán AJAX požadavek
            $comments = $contentManager->getArticlesComments($offset, $limit, $parentPageUrl[1]);
            foreach($comments as $key1 =>$value)
            {
                $comments[$key1]['likes_count'] = $contentManager->rating_count($comments[$key1]['comment_id'],"like");
                $comments[$key1]['dislikes_count'] = $contentManager->rating_count($comments[$key1]['comment_id'],"dislike");
                $comments[$key1]['replies'] = $contentManager->commentsReplies($comments[$key1]['comment_id']);
                foreach($comments[$key1]['replies'] as $key2=>$value)
                {
                    $comments[$key1]['replies'][$key2]['likes_count'] = $contentManager->rating_count( $comments[$key1]['replies'][$key2]['comment_id'],"like");
                    $comments[$key1]['replies'][$key2]['dislikes_count'] = $contentManager->rating_count( $comments[$key1]['replies'][$key2]['comment_id'],"dislike");
                }
                $comments[$key1]['replies-count'] = count($comments[$key1]['replies']);

            }
            $this->data['comments'] = $comments;
            $this->view = 'ajax/comments';


    }
}