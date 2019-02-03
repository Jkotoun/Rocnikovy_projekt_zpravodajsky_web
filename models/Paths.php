<?php
class Paths
{
public static $controllers = array(
    'chyba' => 'ErrorController',
    'clanek'=>'ArticleContentController',
    'comments'=>'AjaxCommentsController',
    'kategorie'=>'ArticlesPreviewController',
    'articles'=>'AjaxArticlesController',
    'prihlaseni'=>'LoginController',
    'registrace'=>'RegisterController',
    'logout'=>'LogoutController',
    'login'=>'AjaxLoginController',
    'register'=>'AjaxRegisterController',
    'add_comment'=>'AjaxAddCommentController',
    'uzivatel'=>'UserProfileController',
    'userComments'=>'AjaxUserCommentsController',
    'nastaveni'=>'UserEditController',
    'roleChange'=>'AjaxRoleController',
    'commentDelete'=>'AjaxDeleteCommentController',
    'comment_rate'=>'AjaxCommentRateController',
    'add_reply'=>'AjaxAddReplyController',
    'access-denied'=>'AccessDeniedController'
);
    public static $admin_controllers = array(
        'novy-clanek' => 'ArticleEditorController',
        'editor'=>'ArticleEditorController',
        'clanky'=>'ArticlesManagementController',
        'uzivatele'=>'UsersManagementController'
    );

public static function getControllerClass($controller_url)
{
    return self::$controllers[$controller_url];
}
    public static function getControllerAdminClass($controller_url)
    {
        return self::$admin_controllers[$controller_url];
    }
}