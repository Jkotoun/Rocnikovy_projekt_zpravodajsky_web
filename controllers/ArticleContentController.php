<?php


class ArticleContentController extends Controller
{
 public function process($params)
 {
     $contentManager = new ContentManager();
     $userManager = new UserManager();
     $url = $params[0];
     if(empty($url))
     {
         $this->redirect('');
     }
     $article = $contentManager->getArticle($url);
     if(!$article)
     {
         $this->redirect('chyba');
     }
     $article['post_time'] = $contentManager->singleDateFormat($article['post_time']);

     $this->head = array(
         'title' => $article['title'],
         'keywords' => $article['keywords'],
         'description' => $article['description'],
         'scripts' => array( 'classes' => 'AjaxLoader.js', 'navbar-toggling' => 'navbar-scripts.js', 'comment-loading'=>'comments.js', 'forms'=>'Forms.js')

     );
     $this->data['title'] = $article['title'];
     $this->data['content'] = $article['content'];
     $this->data['preview_image'] = $article['img_url'];
     $this->data['first_paragraph'] = $article['description'];
     $this->data['updated'] = $article['post_time'];
     $this->data['url']=$article['url'];
     $this->data['logged_user'] = $userManager->getLoggedUser();
     $comments = $contentManager->getArticlesComments(0,10,$article['url']);
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

     $this->data['comments']= $comments;

     $this->data['author_name'] = $article['first_name'] . " ".$article['last_name'];
     $this->data['author_profile_picture'] = $article['profile_picture'];
     $this->data['author_link'] = $article['profile_url'];
     $this->view = 'article_content';
 }
}