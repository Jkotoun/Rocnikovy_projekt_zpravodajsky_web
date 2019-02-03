<?php


class AjaxArticlesController extends Controller
{
public function process($params)

{
$contentManager = new ContentManager();
$offset = $_POST['offset'];
$limit  = $_POST['limit'];
$parentPageUrl = $this->urlToArray($params); //zpracování URL stránky, z které byl odeslán AJAX požadavek
if(empty($parentPageUrl[1]))
{
    $articles = $contentManager->getArticles($offset,$limit);
    $this->data['is_category'] = false;
}
else
{
    $articles = $contentManager->getArticlesByCategory($offset,$limit,$parentPageUrl[1]);
    $this->data['is_category'] = true;
}

$this->view = 'ajax/articles';
$this->data['articles'] = $articles;
}



}