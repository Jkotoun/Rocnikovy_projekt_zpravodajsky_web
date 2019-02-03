<?php


class AjaxDeleteCommentController extends Controller
{
public function process($params)
{
    $contentManager = new ContentManager();
    $errors = array();
    $comment_id = $_POST['comment_id'];
    $logged_user_id = UserManager::getLoggedUser()['user_id'];
    $comment_author =$contentManager->commentAuthor($comment_id)['author_id'];

    try {
        if ($comment_author != $logged_user_id && !UserRoles::logged_user_can('manage-users'))
        {
            throw new Exception("K odstranění komentáře nemáte povolení");
        }
        if($comment_id!=null)
        {
            $contentManager->removeReplies($comment_id);
        }
        $contentManager->deleteComment($comment_id);


    }
    catch(Exception $error)
    {
        $errors['user'] = $error->getMessage();
    }
    echo(Json_encode($errors));
}
}