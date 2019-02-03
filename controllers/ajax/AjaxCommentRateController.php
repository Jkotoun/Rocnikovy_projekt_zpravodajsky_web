<?php

class AjaxCommentRateController extends Controller
{
    public function process($params)
    {
        $rating = $_POST['rating'];
        $comment_id = $_POST['comment_id'];
        try {
            $user = UserManager::getLoggedUser();
            if (!$user) {

                throw new Exception("logged_out");
            }
            $contentManager = new ContentManager();
            if ($contentManager->rating_exists($user['user_id'], $comment_id, $rating)) {
                $contentManager->RemoveCommentRating($comment_id, $user['user_id']);
            } else {

                $contentManager->RateComment($comment_id, $user['user_id'], $rating);
            }
            $data = array();
            $data['likes'] = $contentManager->rating_count($comment_id, 'like');
            $data['dislikes'] = $contentManager->rating_count($comment_id, 'dislike');
        }
        catch(Exception $error)
        {
            $data['error'] = $error->getMessage();
        }
        echo(json_encode($data));

    }

}