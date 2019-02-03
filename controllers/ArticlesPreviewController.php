<?php


class ArticlesPreviewController extends Controller
{
    public function process($params)
    {
        $contentManager = new ContentManager();
        if(isset($params[0])) {
            $url = $params[0];
        }
        if(empty($url))
        {
            $articles = $contentManager->getArticles(0,10);
            $this->view = 'index-page';
        }
        else
        {
            $exists = $contentManager->category_exists($url);
            if(!$exists)
            {
                $this->redirect('error');
            }
            $articles = $contentManager->getArticlesByCategory(0,10,$url);
            $this->view = 'category';
            $this->data['category'] = $contentManager->CategoryNameByUrl($url)['category_name'];
        }

        $this->head = array(
            'title' => 'Kotounovy listy - s námi víte vše',
            'keywords' => 'zpravodajství, novinky, zprávy, aktuality',
            'description' => 'Zprávy z české republiky a světa',
            'scripts' => array('ajaxLoader' => 'AjaxLoader.js', 'navbar-toggling' => 'navbar-scripts.js', 'articles-loading'=>'articleLoader.js')
        );
        $this->data['articles'] = $articles;

    }
}