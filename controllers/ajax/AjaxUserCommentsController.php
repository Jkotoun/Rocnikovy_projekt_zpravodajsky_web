<?php

class AjaxUserCommentsController extends controller
{
    public function process($params)
    {
        $contentManager = new ContentManager();
        $userManager = new UserManager();
        $offset = $_POST['offset'];
        $limit  = $_POST['limit'];
        $parentPageUrl = $this->urlToArray($params); //zpracování URL stránky, z které byl odeslán AJAX požadavek
        $user = $userManager->getUserByUrl($parentPageUrl[1]);
        $comments = $contentManager->getUsersComments($user['user_id'],$limit,$offset);
        $this->data['comments'] = $comments;
        $this->data['user'] = $user;
        $this->view = 'ajax/userComments';
    }
}